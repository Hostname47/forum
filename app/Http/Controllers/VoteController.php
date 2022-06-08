<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Thread, Post, Vote};
use App\Classes\NotificationHelper;
use App\Models\NotificationStatement;
use App\Notifications\UserAction;
use App\Scopes\ExcludeAnnouncements;

class VoteController extends Controller
{
    /**
     * Here we need to check first if the user is already vote on this thread, then we decide if we add this vote or take it off
     * we have 3 cases here:
     *  1- the user is upvoted this thread, then press upvote button again; in this case we're gonna delete the vote
     *  2- the user is not voted at all, in this case we simply add it
     *  3- the user is upvoted  the thread, and then he decide to downvote it; in this case we need to delete the up
     *     vote and then add the down vote
     */
    public function thread_vote(Request $request) {
        $threadid = $this->validate(
            $request, 
            ['resourceid'=>'required|exists:threads,id'], 
            ['resourceid.exists'=>__('Oops something went wrong')]
        )['resourceid'];

        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($threadid);
        if(is_null($thread))
            abort(404, __('Oops something went wrong'));
        
        $currentuser = auth()->user();
        $voteaction = $this->handle_vote($request, $thread);
        /**
         * Before notifying the thread owner, we have to check if the thread owner disable notifications
         * on that thread or not; We only notify him if he didn't
         * => Notifying thread owner should be done in a queued job
         */
        $threadowner = $thread->user()->withoutGlobalScopes()->setEagerLoads([])->first();
        $disableinfo = NotificationHelper::extract_notification_disable($threadowner, $thread->id, 'thread', 'thread-vote');

        if($voteaction != 'deleted' && !$disableinfo['disabled']) {
            \DB::statement(
                "DELETE FROM `notifications` 
                WHERE JSON_EXTRACT(data, '$.action_type')='thread-vote' 
                AND JSON_EXTRACT(data, '$.action_user')=$currentuser->id 
                AND JSON_EXTRACT(data, '$.resource_type')='thread' 
                AND JSON_EXTRACT(data, '$.resource_id')=$thread->id"
            );

            $threadowner->notify(
                new UserAction([
                    // ===== DB =====
                    'action_user'=>$currentuser->id,
                    'action_type'=>'thread-vote',
                    'resource_id'=>$thread->id,
                    'resource_type'=>'thread',
                    'options'=>[
                        'canbedisabled'=>1,
                        'canbedeleted'=>1,
                        'source_type'=>'App\Models\Thread',
                        'source_id'=>$thread->id
                    ],
                    // ===== the following data is only available to notif when broadcast =====
                    'resource_slice'=>' : ' . $thread->slice,
                    'action_statement'=>'thread-vote',
                    'link'=>$thread->link,
                    'bold'=>$currentuser->minified_name,
                    'image'=>$currentuser->sizedavatar(100)
                ])
            );
        }
    }

    public function post_vote(Request $request) {
        $postid = $this->validate(
            $request, 
            ['resourceid'=>'required|exists:posts,id'], 
            ['resourceid.exists'=>__('Oops something went wrong')]
        )['resourceid'];

        $currentuser = auth()->user();

        $post = Post::find($postid);
        if(is_null($post))
            abort(404, __('Oops something went wrong'));

        $thread = $post->thread()->withoutGlobalScope(ExcludeAnnouncements::class)->first();
        /**
         * Here, we only allow users to vote posts if theu have access to its parent thread
         * In case of a private or follower only thread, the user could not vote its posts
         */
        if(is_null($thread))
            abort(404, __('Oops something went wrong'));

        $voteaction = $this->handle_vote($request, $post, 'App\Models\Post');
        
        $postowner = $post->user;
        $disableinfo = NotificationHelper::extract_notification_disable($postowner, $post->id, 'post', 'post-vote');

        if($voteaction != 'deleted' && !$disableinfo['disabled']) {
            \DB::statement(
                "DELETE FROM `notifications` 
                WHERE JSON_EXTRACT(data, '$.action_type')='post-vote' 
                AND JSON_EXTRACT(data, '$.action_user')=$currentuser->id 
                AND JSON_EXTRACT(data, '$.resource_type')='post' 
                AND JSON_EXTRACT(data, '$.resource_id')=$post->id"
            );

            $link = $post->ticked ? $thread->link : $thread->link.'?reply='.$post->id;
            $post->user->notify(
                new \App\Notifications\UserAction([
                    // ===== DB =====
                    'action_user'=>$currentuser->id,
                    'action_type'=>'post-vote',
                    'resource_id'=>$post->id,
                    'resource_type'=>'post',
                    'options'=>[
                        'canbedisabled'=>1,
                        'canbedeleted'=>1,
                        'source_type'=>'App\Models\Thread',
                        'source_id'=>$thread->id
                    ],
                    // ===== the following data is only available to notif when broadcast =====
                    'resource_slice'=>': ' . $post->slice,
                    'action_statement'=>'post-vote',
                    'link'=>$link,
                    'bold'=>$currentuser->minified_name,
                    'image'=>$currentuser->sizedavatar(100)
                ])
            );
        }
    }

    /**
     * handle_vote function will handle vote by either inserting the vote, flipping it (remove up and add down) or delete it
     * completely, and then return the type of handling (either added, deleted, flipped)
     * we use that return to decide whether we notify the resource owner or not
     */
    private function handle_vote($request, $resource) {
        $current_user = auth()->user();
        $data = $request->validate([
            'vote'=> [
                'required',
                Rule::in([-1, 1]),
            ]
        ]);

        $voteaction;
        $resourcetype = strtolower(class_basename($resource)); // if resource votes is a thread (Thread) it returns => thread
        $this->authorize('store', [\App\Models\Vote::class, $data['vote'], $resource, $resourcetype]);
        /**
         * we have to check if the user already vote the resources
         */
        $exists_result = \DB::select("SELECT * FROM votes WHERE user_id=$current_user->id AND votable_id=? AND votable_type=?", [$resource->id, get_class($resource)]);
        $exists = (bool) count($exists_result);
        $founded_vote;
        if($exists) {
            $founded_vote = Vote::find($exists_result[0]->id);
        }

        $vote = new Vote;
        $vote->vote = $data['vote'];
        $vote->user_id = $current_user->id;

        /**
         * If the user already vote the resource we do the following:
         *  1. store vote value in variable before delete the founded vote
         *  2. then we delete the notification of the former vote of the resource owner
         *  3. now we have to check in case the vote found, if resource is already upvoted and the user upvote again or already downvoted and the use..
         *     in that case we don't do anything but delete the vote and notification;
         *     Otherwise, if the user already upvote resource and then later downvote it, we save it again to db
         *     Notice: notifying resource owner is done in the caller method
         */
        if($exists) {
            $vote_value = $founded_vote->vote;
            $founded_vote->delete();

            $voteaction="deleted";
            if(($vote_value == -1 && $data['vote'] == 1) || ($vote_value == 1 && $data['vote'] == -1)) {
                $resource->votes()->save($vote);
                $voteaction="flipped";
            }
        } else {
            $resource->votes()->save($vote); // If the user never vote the resource we simply add the vote record
            $voteaction="added";
        }
        
        return $voteaction;
    }
}
