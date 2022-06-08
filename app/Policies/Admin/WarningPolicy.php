<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarningPolicy
{
    use HandlesAuthorization;

    public function warnuser(User $user) {
        if(!$user->has_permission('warn-user'))
            return $this->deny('You cannot warn users because you do not have the permission to do so');

        return true;
    }
}
