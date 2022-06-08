<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Post, PostStatus, Warning, Strike, User, WarningReason, StrikeReason, Report};
use App\Classes\Helper;
use Illuminate\Validation\Rule;
use App\Notifications\{UserAction, UserWarning as UserWarningNotification, UserStrike, PostRestored};
use App\View\Components\Admin\Post\{RenderViewer, PostReviewComponent};

class AdminPostController extends Controller
{
    public function managepost(Request $request) {
        $post = $postowner = $pstatus = null;
        $resourcewarnings = $resourcestrikes = [];
        $postwarningreasons = $poststrikereasons = $reportwarningreasons = $reportstrikereasons = [];
        $reports=[];
        $reportshasmore = $reports_reviewed = false;
        $reportscount = 0;
        $all_reporters_ids="";
        $all_reports_ids="";

        if($request->has('postid')) {
            $post = Post::withoutGlobalScopes()->find($request->get('postid'));
            if($post) {
                $pstatus = $post->status->slug;
                $postowner = $post->user;
                // warnings and strikes post owner got on this resource
                $resourcewarnings = $postowner->warnings()->where('resource_type', 'App\Models\Post')->where('resource_id', $post->id)->get();
                $resourcestrikes = $postowner->strikes()->where('resource_type', 'App\Models\Post')->where('resource_id', $post->id)->get();
                // post reports
                $reports = $post->reports()->orderBy('created_at', 'desc')->take(9)->get();
                $reportshasmore = $reports->count() > 8;
                $reports = $reports->take(8);
                $reportscount = $post->reports()->count();
                $reports_reviewed = $post->reports()->where('reviewed', 0)->count() == 0;
    
                $all_reporters_ids = implode(',', $post->reports()->pluck('reporter')->toArray());
                $all_reports_ids = implode(',', $post->reports()->pluck('id')->toArray());
    
                // warning and strikes about inappropriate post
                $postwarningreasons = WarningReason::where('resource_type', 'post')->get();
                $poststrikereasons = StrikeReason::where('resource_type', 'post')->get();
                // Warning and strikes reasons about inappropriate report
                $reportwarningreasons = WarningReason::where('resource_type', 'report')->get();
                $reportstrikereasons = StrikeReason::where('resource_type', 'report')->get();
            }
        }

        return view('admin.posts.manage-post')
            ->with(compact('post'))
            ->with(compact('postowner'))
            ->with(compact('pstatus'))
            ->with(compact('postwarningreasons'))
            ->with(compact('poststrikereasons'))
            ->with(compact('reportwarningreasons'))
            ->with(compact('reportstrikereasons'))
            ->with(compact('resourcewarnings'))
            ->with(compact('resourcestrikes'))
            ->with(compact('reports'))
            ->with(compact('reportshasmore'))
            ->with(compact('reportscount'))
            ->with(compact('reports_reviewed'))
            ->with(compact('all_reporters_ids'))
            ->with(compact('all_reports_ids'))
        ;
    }

    public function delete_post(Request $request) {
        $this->authorize('delete_post', [Post::class]);
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'wsvalue'=>['required', Rule::in(['warn', 'strike'])]
        ]);
        $post = Post::withoutGlobalScopes()->find($data['post_id']);
        $postowner = $post->user()->withoutGlobalScopes()->first();

        /**
         * Notice here that we don't warn or strike the post owner as this is done in different section
         * within the same page; The admin should warn or strike the owner first, and then delete the reply
         * Also notice that we don't force delete the reply (we just soft delete it) because we need to render
         * it to the owner in warniong and strikes page
         */
        $post->update(['status_id'=>PostStatus::where('slug', 'deleted-by-an-admin')->first()->id]);
        $post->delete();
        \Session::flash('message', "Reply : '" . $post->slice . "' has been deleted successfully. The reply only accessible to the owner in warning&strikes page");

        if($data['wsvalue'] == 'warn') {
            $warning = new Warning;
            $warning->user_id = $post->user_id;
            $warning->reason_id = WarningReason::where('slug', 'post-deleted-due-to-guidelines-violation')->first()->id;
            $warning->warned_by = auth()->user()->id;
            $warning->resource_id = $post->id;
            $warning->resource_type = 'App\Models\Post';
            $warning->save();
    
            $postowner->notify(
                new UserWarningNotification([
                    'action_type'=>'warn-user',
                    'resource_id'=>$warning->id,
                    'resource_type'=>'warning',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'post-warning',
                        'source_type'=>'user',
                        'source_id'=>$postowner->id
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'post-warning',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        } else if($data['wsvalue'] == 'strike') {
            $strike = new Strike;
            $strike->user_id = $post->user_id;
            $strike->reason_id = StrikeReason::where('slug', 'post-deleted-due-to-guidelines-violation')->first()->id;
            $strike->striked_by = auth()->user()->id;
            $strike->resource_id = $post->id;
            $strike->resource_type = 'App\Models\Post';
            $strike->save();
    
            $postowner->notify(
                new UserStrike([
                    'action_type'=>'strike-user',
                    'resource_id'=>$strike->id,
                    'resource_type'=>'strike',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'post-strike',
                        'source_type'=>'user',
                        'source_id'=>$postowner->id
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'post-strike',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        }


    }

    public function delete_post_permanently(Request $request) {
        $this->authorize('delete_post_permanently', [Post::class]);
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id'
        ]);
        $post = Post::withoutGlobalScopes()->find($data['post_id']);
        $post->forceDelete();
        \Session::flash('message', "Reply : '" . $post->slice . "' has been deleted permanently with success along with all its related resources.");

        return [
            'link'=>route('admin.post.manage')
        ];
    }

    public function restore(Request $request) {
        $this->authorize('restore_post', [Post::class]);
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id'
        ]);

        $post = Post::withoutGlobalScopes()->find($data['post_id']);
        // restore post by changing status to live first, and then restore it
        $post->update(['status_id'=>PostStatus::where('slug', 'deleted-by-an-admin')->first()->id]);
        $post->restore();
        
        $postowner = $post->user()->withoutGlobalScopes()->first();
        $thread = $post->thread()->withoutGlobalScopes()->first();
        
        if($request->has('cleanwarnings')) {
            $postowner->warnings()
            ->where('resource_id', $post->id)
            ->where('resource_type', 'App\Models\Post')
            ->delete();
        }
        if($request->has('cleanstrikes')) {
            $postowner->strikes()
            ->where('resource_id', $post->id)
            ->where('resource_type', 'App\Models\Post')
            ->delete();
        }

        $link = ($post->ticked) ? $thread->link : $thread->link.'?reply='.$post->id;
        if(!is_null($thread->deleted_at))
            $link="#";
        
        // Notify post owner
        $postowner->notify(
            new PostRestored([
                'action_type'=>'post-restore',
                'resource_id'=>$post->id,
                'resource_type'=>'post',
                'options'=>[
                    'canbedisabled'=>0,
                    'canbedeleted'=>0,
                    'source_type'=>'App\Models\Thread',
                    'source_id'=>$thread->id
                ],
                'resource_slice'=>'',
                'action_statement'=>'post-restored',
                'link'=>$link,
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );
    }

    public function generate_post_render(Request $request, $post) {
        $post = Post::withoutGlobalScopes()->find($post);
        $replyrender = (new RenderViewer($post));
        $replyrender = $replyrender->render(get_object_vars($replyrender))->render();
        
        return [
            'payload'=>$replyrender,
            'managelink'=>route('admin.post.manage') . '?postid=' . $post->id
        ];
    }

    public function generate_posts_review_fetch_more(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'take'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $posts = $user->userposts()->withTrashed()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $posts->count() > $data['take'];
        $posts = $posts->take($data['take']);

        $payload = "";
        foreach($posts as $post) {
            $threadreview_component = (new PostReviewComponent($post));
            $threadreview_component = $threadreview_component->render(get_object_vars($threadreview_component))->render();
            $payload .= $threadreview_component;
        }

        return [
            "hasmore"=> $hasmore,
            "payload"=>$payload,
            "count"=>$posts->count()
        ];
    }
}
