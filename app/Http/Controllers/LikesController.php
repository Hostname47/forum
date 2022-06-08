<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Post, Like};
use App\Scopes\ExcludeAnnouncements;
use App\Classes\NotificationHelper;

class LikesController extends Controller
{
    public function thread_like(Request $request) {
        $threadid = $this->validate(
            $request, 
            ['resourceid'=>'required|exists:threads,id'], 
            ['resourceid.exists'=>__('Oops something went wrong')]
        )['resourceid'];
        
        // exclude announcement scope -> user could like announcements
        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($threadid);
        if(is_null($thread))
            abort(404, __('Oops something went wrong'));

        $threadowner = $thread->user()->withoutGlobalScopes()->setEagerLoads([])->first();

        $status = $this->handle_resource_like($thread, 'App\Models\Thread');

        $currentuser = auth()->user();
        if($status == 0) { // status == 0 means like is deleted
            if($thread->user_id != $currentuser->id) {
                \DB::statement(
                    "DELETE FROM `notifications` 
                    WHERE JSON_EXTRACT(data, '$.action_type')='thread-like'
                    AND JSON_EXTRACT(data, '$.action_user') = " . $currentuser->id .
                    " AND JSON_EXTRACT(data, '$.resource_type')='thread'
                     AND JSON_EXTRACT(data, '$.resource_id')=" . $thread->id
                );
            }

            return $status;
        }

        // Before notifying thread owner we have to check if he disable notifications on this thread likes
        $disableinfo = NotificationHelper::extract_notification_disable($thread->user, $thread->id, 'thread', 'thread-like');

        if(!$disableinfo['disabled']) {
            if($currentuser->id != $thread->user_id) {
                $threadowner->notify(
                    new \App\Notifications\UserAction([
                        'action_user'=>$currentuser->id,
                        'action_type'=>'thread-like',
                        'resource_id'=>$thread->id,
                        'resource_type'=>'thread',
                        'options'=>[
                            'canbedisabled'=>true,
                            'canbedeleted'=>true,
                            'source_type'=>'App\Models\Thread',
                            'source_id'=>$thread->id
                        ],
                        'resource_slice'=>' : ' . $thread->slice,
                        'action_statement'=>'thread-like',
                        'link'=>$thread->link,
                        'bold'=>$currentuser->minified_name,
                        'image'=>$currentuser->sizedavatar(100)
                    ])
                );
            }
        }

        return $status;
    }

    public function post_like(Request $request) {
        $postid = $this->validate(
            $request, 
            ['resourceid'=>'required|exists:posts,id'], 
            ['resourceid.exists'=>__('Oops something went wrong')]
        )['resourceid'];

        $post = Post::find($postid);
        if(is_null($post))
            abort(404, __('Oops something went wrong'));

        $thread = $post->thread()->withoutGlobalScope(ExcludeAnnouncements::class)->setEagerLoads([])->first();
        if(is_null($thread))
            abort(404, __('Oops something went wrong'));

        $status = $this->handle_resource_like($post, 'App\Models\Post');

        $currentuser = auth()->user();
        if($status == 0) { // status == 0 means like is deleted
            if($post->user_id != $currentuser->id) {
                \DB::statement(
                    "DELETE FROM `notifications` 
                    WHERE JSON_EXTRACT(data, '$.action_type')='post-like'
                    AND JSON_EXTRACT(data, '$.action_user') = " . $currentuser->id .
                    " AND JSON_EXTRACT(data, '$.resource_type')='post'
                     AND JSON_EXTRACT(data, '$.resource_id')=" . $post->id
                );
            }

            return $status;
        }

        $postowner = $post->user()->setEagerLoads([])->first();
        // First we check if the owner of the resource disable the notification on this thread likes
        $disableinfo = NotificationHelper::extract_notification_disable($postowner, $post->id, 'post', 'post-like');

        if(!$disableinfo['disabled']) {
            if($currentuser->id != $post->user_id) {
                $link = $thread->link . (($post->ticked) ? '' : '?reply='.$post->id);

                $postowner->notify(
                    new \App\Notifications\UserAction([
                        'action_user'=>$currentuser->id,
                        'action_type'=>'post-like',
                        'resource_id'=>$post->id,
                        'resource_type'=>'post',
                        'options'=>[
                            'canbedisabled'=>true,
                            'canbedeleted'=>true,
                            'source_type'=>'App\Models\Post',
                            'source_id'=>$post->id
                        ],
                        'resource_slice'=>' : ' . $post->slice,
                        'action_statement'=>'post-like',
                        'link'=>$link,
                        'bold'=>$currentuser->minified_name,
                        'image'=>$currentuser->sizedavatar(100)
                    ])
                );
            }
        }

        return $status;
    }

    private function handle_resource_like($resource, $type) {
        $this->authorize('store', [Like::class]);

        $currentuser = auth()->user();
        $likefound = $currentuser->likes()
            ->where('likable_type', $type)
            ->where('likable_id', $resource->id)->first();

        if($likefound) {
            $likefound->delete();
            return 0;
        }

        $like = new Like;
        $like->user_id = $currentuser->id;
        $resource->likes()->save($like);
        return 1;
    }
}
