<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    const THREADS_VOTE_LIMIT = 200;
    const POSTS_VOTE_LIMIT = 300;

    public function store(User $user, $vote_value, $resource, $resource_name)
    {
        if($resource_name == 'thread') $resource_name = 'posts';
        if($resource_name == 'post') $resource_name = 'replies';

        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));

        if($resource->user->id == $user->id)
            return $this->deny(__("You cannot vote your own :n", ['n'=>__($resource_name)]));

        if($resource_name == 'posts') { // Posts means threads just for i18n
            if($user->votes_on_threads() >= self::THREADS_VOTE_LIMIT) {
                $user->log_authbreak('thread-votes-daily-limit-reached');
                return $this->deny(__("You reached your posts voting limit allowed per day, try out later") . '. (' . self::THREADS_VOTE_LIMIT . ' ' . 'votes' . ')');
            }
        } else if($resource_name == 'replies') {
            if($user->votes_on_posts() >= self::POSTS_VOTE_LIMIT) {
                $user->log_authbreak('post-votes-daily-limit-reached');
                return $this->deny(__("You reached your replies voting limit allowed per day, try out later") . '. (' . self::POSTS_VOTE_LIMIT . ' ' . 'votes' . ')');
            }
        }

        return true;
    }
}
