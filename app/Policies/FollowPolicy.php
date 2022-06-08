<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowPolicy
{
    use HandlesAuthorization;

    public function follow_user(User $user, $u) {
        if(is_null($u))
            return $this->deny(__("Something wrong happens"));

        if($u->id == $user->id) {
            $user->log_authbreak('try-to-follow-himself');
            return $this->deny(__("You can't follow yourself"));
        }

        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));

            
        if(!$u->has_status('active')) {
            if($u->isBanned())
                return $this->deny(__("You can't follow this user because it is currently banned"));

            $status = $u->status->slug;
            if($status == 'temp-banned' || $status == 'banned')
                return $this->deny(__("You can't follow this user because it is currently banned"));

            if($status == 'deactivated')
                return $this->deny(__("You can't follow this user because his account is currently deactivated"));
        }

        return true;
    }
}
