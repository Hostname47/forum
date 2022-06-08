<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;

    public function store(User $user)
    {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        return true;
    }
}
