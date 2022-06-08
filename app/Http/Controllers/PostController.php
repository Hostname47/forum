<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exceptions\ThreadClosedException;
use App\Models\{Post, PostStatus, Thread, ThreadStatus};
use App\View\Components\PostComponent;
use App\View\Components\Thread\ViewerReply;
use App\Scopes\ExcludeAnnouncements;
use App\Classes\NotificationHelper;
use Markdown;

class PostController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'thread_id'=>'required|exists:threads,id',
            'content'=>'required|min:1|max:40000',
            'from'=> [
                'required',
                Rule::in(['thread-show','media-viewer']),
            ]
        ]);
        
        $currentuser = auth()->user();
        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($data['thread_id']);
        $thread_owner = $thread->user;
        
        $this->authorize('store', [Post::class, $thread]);

        $data['user_id'] = $currentuser->id;
        $data['status_id'] = PostStatus::where('slug', 'live')->first()->id;
        $from = $request->from;
        unset($data['from']);
        $post = Post::create($data);
        $threadtype = ($thread->type == 'poll') ? 'poll' : 'typical';

        $disableinfo = NotificationHelper::extract_notification_disable($thread_owner, $thread->id, 'thread', 'thread-reply');
        if(!$disableinfo['disabled']) { // Only notify thread owner if he doesn't disable notifs on the parent thread
            if($thread_owner->id != $currentuser->id) {
                // If the user is already reply to this thread we have to delete his previous associated notification
                \DB::statement(
                    "DELETE FROM `notifications` 
                    WHERE JSON_EXTRACT(data, '$.action_type')='thread-reply'
                    AND JSON_EXTRACT(data, '$.action_user') = " . $currentuser->id .
                    " AND JSON_EXTRACT(data, '$.resource_type')='thread' 
                    AND JSON_EXTRACT(data, '$.resource_id')=" . $thread->id
                );

                /**
                 * Here we store the thread id as resource id, because we want to combine replies of same thread in one notification
                 * and because we are groupping by resource_id and action_type to get distinct notifications; 
                 * resource_id should be the same among replies of the same thread; for that reason the resource id will be thread id and not reply id
                 */
                $thread_owner->notify(
                    new \App\Notifications\UserAction([
                        'action_user'=>$currentuser->id,
                        'action_type'=>'thread-reply',
                        'resource_id'=>$thread->id,
                        'resource_type'=>'thread',
                        'options'=>[
                            'canbedisabled'=>true,
                            'canbedeleted'=>true,
                            'source_type'=>'App\Models\Thread',
                            'source_id'=>$thread->id
                        ],
                        'resource_slice'=>' : ' . mb_convert_encoding($thread->slice, 'UTF-8', 'UTF-8'),
                        'action_statement'=>$threadtype.'-thread-reply',
                        'link'=>$thread->link,
                        'bold'=>$currentuser->minified_name,
                        'image'=>$currentuser->sizedavatar(100)
                    ])
                );
            }
        }

        $canbeticked = !$thread->isticked();
        if($from == 'thread-show')
            // Generate thread show post (reply) component
            return $this->thread_show_post_generate($post, ['thread-owner-id'=>$thread_owner->id, 'can-be-ticked'=>$canbeticked]);
        else if($from == 'media-viewer')
            // Generate thread viewer post (reply) component
            return $this->thread_viewer_post_generate($post, ['thread-owner-id'=>$thread_owner->id, 'can-be-ticked'=>$canbeticked]);
    }

    public function update(Request $request) {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'content'=>'sometimes|min:1|max:40000'
        ]);
        $post = Post::find($data['post_id']);

        $this->authorize('update', $post);
        $post->update(['content'=>$data['content']]);

        return [
            'parsedcontent'=>Markdown::parse($post->content)->toHtml()
        ];
    }

    public function delete(Request $request) {
        $post = $request->validate(['post_id'=>'required|exists:posts,id'])['post_id'];
        $post = Post::find($post);
        $thread = $post->thread()->withoutGlobalScopes()->setEagerLoads([])->first();
        $this->authorize('delete', [Post::class, $post, $thread]);

        \DB::statement(
            "DELETE FROM `notifications` 
            WHERE JSON_EXTRACT(data, '$.action_type')='thread-reply'
            AND JSON_EXTRACT(data, '$.action_user') = " . $post->user->id .
            " AND JSON_EXTRACT(data, '$.resource_type')='post' 
            AND JSON_EXTRACT(data, '$.resource_id')=" . $post->thread->id
        );
        $post->update(['status_id'=>PostStatus::where('slug', 'deleted-by-owner')->first()->id]);
        // Later we're going to create a scheduled job to force delete posts (by owner) that are older than 30 days
        $post->delete();

        return [
            'post_id'=>$post->id,
            'thread_id'=>$thread->id,
            'posts_count_after_delete'=>$thread->posts()->count()
        ];
    }

    public function tick(Post $post) {
        $this->authorize('tick', $post);
        $currentuser = auth()->user();
        /**
         * Here we disable timestamps and use save method instead of update directly model because we don't
         * want to set updated_at timestamp when changing ticked column
        */
        $post->timestamps = false;
        if($post->ticked) {
            $post->ticked = false;
            $post->save();

            \DB::statement(
                "DELETE FROM `notifications` 
                WHERE JSON_EXTRACT(data, '$.action_type')='post-tick' 
                AND JSON_EXTRACT(data, '$.action_user')=$currentuser->id 
                AND JSON_EXTRACT(data, '$.resource_type')='post' 
                AND JSON_EXTRACT(data, '$.resource_id')=$post->id"
            );
            return 0;
        } else {
            $post->ticked = true;
            $post->save();

            $thread = $post->thread;
            $postowner = $post->user;
            $disableinfo = NotificationHelper::extract_notification_disable($postowner, $post->id, 'post', 'post-tick');

            if(!$disableinfo['disabled']) {
                if($post->user_id != $currentuser->id) {
                    $postowner->notify(
                        new \App\Notifications\UserAction([
                            'action_user'=>$currentuser->id,
                            'action_type'=>'post-tick',
                            'resource_id'=>$post->id,
                            'resource_type'=>'post',
                            'options'=>[
                                'canbedisabled'=>true,
                                'canbedeleted'=>true,
                                'source_type'=>'App\Models\Thread',
                                'source_id'=>$thread->id
                            ],
                            'resource_slice'=>' : ' . mb_convert_encoding($post->slice, 'UTF-8', 'UTF-8'),
                            'action_statement'=>'post-tick',
                            'link'=>$thread->link, // Ticked reply always in first page, so we on't have to define reply query string
                            'bold'=>$currentuser->minified_name,
                            'image'=>$currentuser->sizedavatar(100)
                        ])
                    );
                }
            }
            return 1;
        }
    }

    public function post_raw_content_fetch(Request $request) {
        $post = $request->validate(['post_id'=>'required|exists:posts,id'])['post_id'];
        $post = Post::find($post);
        
        $this->authorize('fetch_content', [Post::class, $post]);
        return $post->content;
    }

    public function post_parsed_content_fetch(Request $request) {
        $data = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'min'=>'sometimes|boolean'
        ]);
        $post = Post::find($data['post_id']);

        $this->authorize('fetch_parsed_content', [Post::class, $post]);
        if(isset($data['min']))
            return Markdown::parse($post->contentslice);
        else
            return Markdown::parse($post->content);
    }

    public function thread_show_post_generate(Post $post, $data=[]) {
        $component = (new PostComponent($post, $data));
        $component = $component->render(get_object_vars($component))->render();
        return $component;
    }

    public function thread_viewer_post_generate(Post $post, $data=[]) {
        $component = (new ViewerReply($post, $data));
        $component = $component->render(get_object_vars($component))->render();
        return $component;
    }
}
