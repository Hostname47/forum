<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function able_to_create_role(User $user) {
        return $user->has_permission('create-role');
    }
    public function create_role(User $user) {
        if(!$user->has_permission('create-role')) {
            // Log auth break
            return $this->deny("You don't have permission to create roles. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_update_role(User $user) {
        return $user->has_permission('update-role');
    }
    public function update_role(User $user) {
        if(!$user->has_permission('update-role')) {
            // Log auth break
            return $this->deny("You don't have permission to update roles. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_grant_role_to_user(User $user) {
        return $user->has_permission('grant-role-to-user');
    }
    public function grant_role_to_user(User $user) {
        if(!$user->has_permission('grant-role-to-user')) {
            // Log auth break
            return $this->deny("You don't have permission to grant roles to users. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_revoke_role_from_user(User $user) {
        return $user->has_permission('revoke-role-from-user');
    }
    public function revoke_role_from_user(User $user, $role, $u) {
        if(!$user->has_permission('revoke-role-from-user')) {
            // Log auth break
            return $this->deny("You don't have permission to revoke roles from users. This activity will be reviewed by site owners");
        }

        if($role->slug == 'site-owner')
            if($role->users()->count() == 1)
                return $this->deny("You cannot revoke this role as it's only one site owner exists.");
        
        if(!$u->has_role($role->slug))
            return $this->deny('This user does not have "' . $role->role . '" role');

        return true;
    }

    public function able_to_attach_permissions_to_role(User $user) {
        return $user->has_permission('attach-permission-to-role');
    }
    public function attach_permissions_to_role(User $user) {
        if(!$user->has_permission('attach-permission-to-role')) {
            // Log auth break
            return $this->deny("You don't have permission to attach permissions to roles. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_detach_permissions_from_role(User $user) {
        return $user->has_permission('detach-permission-from-role');
    }
    public function detach_permissions_from_role(User $user) {
        if(!$user->has_permission('detach-permission-from-role')) {
            // Log auth break
            return $this->deny("You don't have permission to detach permissions from roles. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_delete_role(User $user) {
        return $user->has_permission('delete-role');
    }
    public function delete_role(User $user) {
        if(!$user->has_permission('delete-role')) {
            // Log auth break
            return $this->deny("You don't have permission to delete roles. This activity will be reviewed by site owners");
        }

        return true;
    }
}
