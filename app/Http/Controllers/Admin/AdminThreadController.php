<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Thread, Report, Strike, User, ThreadStatus, ThreadClose, Warning, WarningReason, CloseReason, StrikeReason};
use App\View\Components\Admin\Report\NotifyResourceOwner;
use App\View\Components\Admin\Thread\{ThreadReviewComponent, RenderViewer};
use App\View\Components\IndexResource;
use App\Classes\Helper;
use App\Notifications\{UserAction, UserWarning as UserWarningNotification, UserStrike, ThreadClosed, ThreadOpened, ThreadDeleted, ThreadRestored};

class AdminThreadController extends Controller
{
    public function closethread(Request $request) {
        $this->authorize('close_thread', [Thread::class]);
        $data = $request->validate([
            'threadid'=>'required|exists:threads,id',
            'closereason'=>'required|exists:closereasons,id',
        ]);

        // first we fetch the thread (exclude all scopes) and set its status to closed
        $thread = Thread::withoutGlobalScopes()->find($data['threadid']);
        /**
         * Here we directly set status to closed because thread close section is only accessible if the status
         * is live; So no need to check if it is already deleted in order to set it to closed-and-deleted-by-owner..
         * 
         * Important : in deletion, things will be different; If the thread is already closed and the admin
         * decide to delete, it will take closed-and-deleted-by-an-admin status
         */
        $thread->update(['status_id'=>ThreadStatus::where('slug', 'closed')->first()->id]);

        // Then we store the thread close in order to save close reason and who close the thread
        $threadclose = new ThreadClose;
        $threadclose->closed_by = auth()->user()->id;
        $threadclose->thread_id = $thread->id;
        $threadclose->reason_id = $data['closereason'];
        $threadclose->save();

        // Notify the resource owner
        $threadowner = $thread->user()->withoutGlobalScopes()->first();
        $threadowner->notify(
            new ThreadClosed([
                'action_type'=>'thread-close',
                'resource_id'=>$thread->id,
                'resource_type'=>'thread',
                'options'=>[
                    'canbedisabled'=>false,
                    'canbedeleted'=>false,
                    'source_type'=>'App\Models\Thread',
                    'source_id'=>$thread->id
                ],
                'resource_slice'=>'',
                'action_statement'=>'thread-closed',
                'link'=>$thread->link,
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );
    }
    public function openthread(Request $request) {
        $this->authorize('open_thread', [Thread::class]);
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id'
        ]);
        $thread = Thread::withoutGlobalScopes()->find($data['thread_id']);

        /**
         * If thread is closed, this means could be only closed, closed and deleted by owner, or closed and deleted by an admin
         * so we have to deal with status after opening. If it is simply closed, we set status to live.
         * If it is closed and deleted by owner, we have to set it to deleted by owner after opening.
         * And finally if it is closed and deleted by an admin, we have to set it to deleted by an admin after opening.
         */
        $s = $thread->status->slug;
        $status = ($s == 'closed') ? 'live' : (($s == 'closed-and-deleted-by-owner') ? 'deleted-by-owner' : 'deleted-by-an-admin');
        $thread->update(['status_id'=>ThreadStatus::where('slug', $status)->first()->id]);
        
        // Then we have to delete thread close record
        $thread->threadclose->delete();
        
        // Notify the owner
        $threadowner = $thread->user()->withoutGlobalScopes()->first();
        $threadowner->notify(
            new ThreadOpened([
                'action_type'=>'thread-open',
                'resource_id'=>$thread->id,
                'resource_type'=>'thread',
                'options'=>[
                    'canbedisabled'=>false,
                    'canbedeleted'=>true,
                    'source_type'=>'App\Models\Thread',
                    'source_id'=>$thread->id
                ],
                'resource_slice'=>'',
                'action_statement'=>'thread-opened',
                'link'=>$thread->link,
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );
    }
    public function deletethread(Request $request) {
        $this->authorize('delete_thread', [Thread::class]);
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'wsaction'=>['required', Rule::in(['warn','strike'])],
        ]);

        $thread = Thread::withoutGlobalScopes()->find($data['thread_id']);
        $threadowner = $thread->user()->withoutGlobalScopes()->first();
        /**
         * Before setting status to deleted by an admin, we have to check if thread is already closed
         */
        $status = ($thread->status->slug == 'closed') ? 'closed-and-deleted-by-an-admin' : 'deleted-by-an-admin';
        $thread->update(['status_id'=>ThreadStatus::where('slug', $status)->first()->id]);
        $thread->delete();

        // Here the admin can choose whether warn or strike thread owner (we send 2 notifications one for either warning or strike and one for thread delete)
        if($data['wsaction'] == 'warn') {
            $warning = new Warning;
            $warning->warned_by = auth()->user()->id;
            $warning->user_id = $threadowner->id;
            $warning->resource_id = $thread->id;
            $warning->resource_type = 'App\Models\Thread';
            $warning->reason_id = WarningReason::where('slug', 'thread-guidelines-non-respect')->first()->id;
            $warning->save();

            $threadowner->notify(
                new UserWarningNotification([
                    'action_type'=>'warn-user',
                    'resource_id'=>$warning->id,
                    'resource_type'=>'warning',
                    'options'=>[
                        'canbedisabled'=>false,
                        'canbedeleted'=>false,
                        'type'=>'thread-warning',
                        'source_type'=>'App\Models\Thread',
                        'source_id'=>$thread->id
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'thread-warning',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );

        } else {
            // Strike the the owner of the thread
            $strike = new Strike;
            $strike->striked_by = auth()->user()->id;
            $strike->user_id = $threadowner->id;
            $strike->resource_type = 'App\Models\Thread';
            $strike->resource_id = $thread->id;
            $strike->reason_id = StrikeReason::where('slug', 'thread-guidelines-non-respect')->first()->id;
            $strike->save();

            $threadowner->notify(
                new UserStrike([
                    'action_type'=>'strike-user',
                    'resource_id'=>$strike->id,
                    'resource_type'=>'strike',
                    'options'=>[
                        'canbedisabled'=>false,
                        'canbedeleted'=>false,
                        'type'=>'thread-strike',
                        'source_type'=>'App\Models\Thread',
                        'source_id'=>$thread->id
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'thread-strike',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        }

        // Notify thread owner about thread deletion
        $threadowner->notify(
            new ThreadDeleted([
                'action_type'=>'thread-delete',
                'resource_id'=>$thread->id,
                'resource_type'=>'thread',
                'options'=>[
                    'canbedisabled'=>false,
                    'canbedeleted'=>true,
                    'source_type'=>'App\Models\User',
                    'source_id'=>$threadowner->id
                ],
                'resource_slice'=>'',
                'link'=>route('user.activities', ['user'=>$threadowner->username, 'section'=>'archived-threads']),
                'action_statement'=>'thread-deleted',
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );
    }
    public function delete_thread_permanently(Request $request) {
        $this->authorize('delete_thread_permanently', [Thread::class]);
        $data = $request->validate(['thread_id'=>'required|exists:threads,id']);

        $thread = Thread::withoutGlobalScopes()->find($data['thread_id']);
        $thread->forceDelete();
        \Session::flash('message', "Thread : '" . $thread->slice . "' has been deleted permanently with success along with all its related resources.");

        return ['link'=>route('admin.thread.manage')];
    }
    public function restorethread(Request $request) {
        $this->authorize('restore_thread', [Thread::class]);
        $data = $request->validate(['thread_id'=>'required|exists:threads,id']);
        $thread = Thread::withoutGlobalScopes()->find($data['thread_id']);
        // restore thread
        $thread->restore();
        // Adjust status
        $status = ($thread->status->slug == 'closed-and-deleted-by-an-admin') ? 'closed' : 'live';
        $thread->update(['status_id'=>ThreadStatus::where('slug', $status)->first()->id]);

        $threadowner = $thread->user()->withoutGlobalScopes()->first();
        $threadowner->notify(
            new ThreadRestored([
                'action_type'=>'thread-restore',
                'resource_id'=>$thread->id,
                'resource_type'=>'thread',
                'options'=>[
                    'canbedisabled'=>false,
                    'canbedeleted'=>true,
                    'source_type'=>'App\Models\Thread',
                    'source_id'=>$thread->id
                ],
                'resource_slice'=>'',
                'link'=>$thread->link,
                'action_statement'=>'thread-restored',
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );

        \Session::flash('message', "Thread : '" . $thread->slice . "' has been restoredsuccessfully.");
    }

    public function warn_resource_owner_viewer(Request $request, $resource_owner_id) {
        $user = User::withTrashed()->find($resource_owner_id);
        $notifycomponent = (new NotifyResourceOwner($user));
        $notifycomponent = $notifycomponent->render(get_object_vars($notifycomponent))->render();
        
        return $notifycomponent;
    }

    public function generate_thread_component($thread) {
        $thread = Thread::withoutGlobalScopes()->find($thread);

        $thread_component = (new IndexResource($thread));
        $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
        return $thread_component;
    }

    public function generate_thread_render(Request $request, $thread) {
        $thread = Thread::withoutGlobalScopes()->find($thread);
        $viewer = (new RenderViewer($thread));
        $viewer = $viewer->render(get_object_vars($viewer))->render();
        
        return [
            'payload'=>$viewer,
            'managelink'=>route('admin.thread.manage') . '?threadid=' . $thread->id
        ];
    }

    public function generate_threads_review_fetch_more(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $threads = $user->threads()->withoutGlobalScopes()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $threads->count() > $data['take'];
        $threads = $threads->take($data['take']);
        
        $payload = "";
        foreach($threads as $thread) {
            $threadreview_component = (new ThreadReviewComponent($thread));
            $threadreview_component = $threadreview_component->render(get_object_vars($threadreview_component))->render();
            $payload .= $threadreview_component;
        }

        return [
            "hasmore"=> $hasmore,
            "count"=>$threads->count(), // used to handle last count threads events
            "payload"=>$payload,
        ];
    }

    public function managethread(Request $request) {
        $thread = $threadowner = $threadstatus = null;
        $resourcewarnings = $resourcestrikes=[];
        $threadwarningreasons = $threadstrikereasons = $reportwarningreasons = $reportstrikereasons = $closereasons = [];
        
        $reports=[];
        $reportshasmore = $reports_reviewed = false;
        $reportscount = 0;
        $all_reporters_ids="";
        $all_reports_ids="";

        if($request->has('threadid')) {
            $thread = Thread::withoutGlobalScopes()->find($request->get('threadid'));
            if($thread) {
                $threadstatus=$thread->status->slug;
                $threadowner = $thread->user()->withoutGlobalScopes()->first();
    
                $resourcewarnings = $threadowner->warnings()->where('resource_id', $thread->id)->where('resource_type', 'App\Models\Thread')->get();
                $resourcestrikes = $threadowner->strikes()->where('resource_id', $thread->id)->where('resource_type', 'App\Models\Thread')->get();
                
                $reports = $thread->reports()->orderBy('created_at', 'desc')->take(9)->get();
                $reportshasmore = $reports->count() > 8;
                $reports = $reports->take(8);
                $reportscount = $thread->reports()->count();
                $reports_reviewed = $thread->reports()->where('reviewed', 0)->count() == 0;
                $all_reporters_ids = implode(',', $thread->reports()->pluck('reporter')->toArray());
                $all_reports_ids = implode(',', $thread->reports()->pluck('id')->toArray());
    
                // warning and strikes about inappropriate post
                $threadwarningreasons = WarningReason::where('resource_type', 'thread')->get();
                $threadstrikereasons = StrikeReason::where('resource_type', 'thread')->get();
                // Warning and strikes reasons about inappropriate report
                $reportwarningreasons = WarningReason::where('resource_type', 'report')->get();
                $reportstrikereasons = StrikeReason::where('resource_type', 'report')->get();

                $closereasons = CloseReason::all();
            }
        }

        return view('admin.threads.manage-thread')
        ->with(compact('thread'))
        ->with(compact('threadstatus'))
        ->with(compact('threadowner'))
        ->with(compact('resourcewarnings'))
        ->with(compact('resourcestrikes'))
        ->with(compact('reports'))
        ->with(compact('reportscount'))
        ->with(compact('reportshasmore'))
        ->with(compact('reports_reviewed'))
        ->with(compact('all_reporters_ids'))
        ->with(compact('all_reports_ids'))
        ->with(compact('threadwarningreasons'))
        ->with(compact('threadstrikereasons'))
        ->with(compact('reportwarningreasons'))
        ->with(compact('reportstrikereasons'))
        ->with(compact('closereasons'))
        ;
    }
}
