<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Poll,PollOption};

class PollPolicy
{
    use HandlesAuthorization;

    const MAX_OPTIONS_ENABLED = 30;
    const NONOWNER_OPTIONS_LIMIT = 1;

    public function option_vote(User $user) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        return true;
    }

    public function option_delete(User $user, PollOption $option) {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        if($option->poll->thread->user_id != $user->id) {
            $user->log_authbreak('try-to-delete-poll-option-does-not-own', ['resource_id'=>$option->poll->thread->id, 'resource_type'=>'Thread']);
            return $this->deny(__("Unauthorized action. Admins will review this action"));
        }
        
        if($option->poll->options()->count() < 3)
            return $this->deny(__("You can't delete this option because polls should have at least 2 options"));

        return true;
    }

    public function add_option(User $user, $poll, $data) {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        if($poll->options()->count() >= self::MAX_OPTIONS_ENABLED)
            return $this->deny(__("Poll could have only 30 options max"));

        $poll_owner_id = \DB::select(
            "SELECT user_id FROM threads WHERE id IN 
                (SELECT thread_id FROM polls WHERE id = " . $poll->id .")")[0]->user_id;

        if($poll->options()->where('content', $data['content'])->count())
            return $this->deny(__('Option already exists with that content. options content must be unique'));

        if($user->id != $poll_owner_id) {
            if($poll->allow_options_add == 0) {
                return $this->deny(__("Poll owner disable options adding"));
            } else {
                $limit = $poll->options_add_limit;
                $limit_reached = $poll->options()->where('user_id', $user->id)->count() == $limit;
                if($limit_reached)
                    return $this->deny(__("Poll owner specified a limit of :n options to be added per user as maximum", ['n'=>$limit]));
            }
        }

        return true;
    }
}
