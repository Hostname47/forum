<?php

namespace App\Policies;

use App\Exceptions\UserBannedException;
use App\Models\Post;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Scopes\ExcludeAnnouncements;

class PostPolicy
{
    use HandlesAuthorization;

    const POST_LIMIT = 260;

    public function store(User $user, $thread)
    {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        if($thread->replies_off == 1)
            return $this->deny(__("You can't reply on this post because the owner is turning off the replies"));
        
        if($thread->status->slug == 'closed')
            return $this->deny(__("You can't reply on closed posts"));

        if($thread->status->slug == 'temp.closed')
            return $this->deny(__("You can't reply on temporarily closed posts"));
        
        // The user should be: authenticated, not banned and post less than 280 posts per day.
        if($user->today_posts_count() > self::POST_LIMIT) {
            $user->log_authbreak('post-share-daily-limit-reached');
            return $this->deny(__("You reached your replying limit allowed per day, try out later") . '. (' . self::POST_LIMIT . ' ' . 'replies' . ')');
        }
        
        return true;
    }

    public function able_to_update(User $user, Post $post)
    {
        if ($user->isBanned()) return false;
        return $post->user_id == $user->id;
    }

    public function update(User $user, Post $post)
    {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));

        if($post->user_id != $user->id) {
            $user->log_authbreak('try-to-update-post-does-not-own', ['resource_id'=>$post->id, 'resource_type'=>'Post']);
            return $this->deny(__("Unauthorized action. Admins will review this unauthorized action"));
        }

        return true;
    }

    public function able_to_delete(User $user, Post $post, $threadownerid) {
        if($user->isBanned()) return false;
    
        return $post->user_id == $user->id || $user->id == $threadownerid;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post, Thread $thread) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        if($post->user_id != $user->id && $user->id != $thread->user_id) {
            $user->log_authbreak('try-to-delete-post-does-not-own', ['resource_id'=>$post->id, 'resource_type'=>'Post']);
            return $this->deny(__("You cannot delete this reply because it is not belong to you"));
        }

        return true;
    }

    public function fetch_content(User $user, Post $post) {
        $thread_user_id = \DB::select('SELECT user_id FROM threads WHERE id = ' . $post->thread_id)[0]->user_id;
        if($post->user_id != $user->id && $user->id != $thread_user_id) {
            $user->log_authbreak('try-to-fetch-a-post-does-not-own', ['resource_id'=>$post->id, 'resource_type'=>'Post']);
            return $this->deny(__("Unauthorized action. Admins will review this unauthorized action"));
        }

        return true;
    }

    public function fetch_parsed_content(User $user, Post $post) {
        $thread_user_id = \DB::select('SELECT user_id FROM threads WHERE id = ' . $post->thread_id)[0]->user_id;
        if($post->user_id != $user->id && $user->id != $thread_user_id) {
            $user->log_authbreak('try-to-fetch-a-post-does-not-own', ['resource_id'=>$post->id, 'resource_type'=>'Post']);
            return $this->deny(__("Unauthorized action. Admins will review this unauthorized action"));
        }

        return true;
    }

    public function tick(User $user, Post $post) {
        if($user->isBanned()) {
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        }

        /**
         * 1. verify if the user is the owner of the thread where the post is attached to
         * 2. verify if the thread is closed
         * 2. verify if the thread has already a ticked post [different than the curren one because
         * the owner could make it ticked and then click on it to remove the tick]; 
         * If we found one, we can't make the fetched post ticked otherwise we continue
         */
        $thread = $post->thread()->withoutGlobalScopes()->first();
        if($thread->user_id != $user->id) {
            $user->log_authbreak('try-to-tick-a-thread-does-not-own', ['resource_id'=>$thread->id, 'resource_type'=>'Thread']);
            return $this->deny(__("You can't tick a reply attached to a post you don't own"));
        }

        if($thread->isClosed()) {
            return $this->deny(__("You can't tick a post attached to a closed post"));
        }

        $ticked = \DB::select("SELECT id FROM posts WHERE thread_id=$thread->id AND ticked=1");
        if(count($ticked)) {
            if($ticked[0]->id != $post->id) {
                return $this->deny(__("This post has already a ticked reply"));
            }
        }
        
        return true;
    }

    public function delete_post(User $user) {
        return $user->has_permission('delete-post');
    }

    public function delete_post_permanently(User $user) {
        return $user->has_permission('permanent-delete-post');
    }

    public function restore_post(User $user) {
        return $user->has_permission('restore-post');
    }
}
