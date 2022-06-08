<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StrikePolicy
{
    use HandlesAuthorization;

    public function strikeuser(User $user) {
        if(!$user->has_permission('strike-user'))
            return $this->deny('You cannot strike users because you do not have the permission to do so');

        return true;
    }
}
