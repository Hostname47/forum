<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function able_to_create_permission(User $user) {
        return $user->has_permission('create-permission');
    }
    public function create_permission(User $user) {
        if(!$user->has_permission('create-permission')) {
            // Log auth break
            return $this->deny("You don't have permission to create permissions. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_update_permission(User $user) {
        return $user->has_permission('update-permission');
    }
    public function update_permission(User $user) {
        if(!$user->has_permission('update-permission')) {
            // Log auth break
            return $this->deny("You don't have permission to create permissions. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_grant_permission_to_users(User $user) {
        return $user->has_permission('grant-permission-to-user');
    }
    public function grant_permission_to_users(User $user) {
        if(!$user->has_permission('grant-permission-to-user')) {
            // Log auth break
            return $this->deny("You don't have permission to grant permissions to users. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_revoke_permission_from_users(User $user) {
        return $user->has_permission('revoke-permission-from-user');
    }
    public function revoke_permission_from_users(User $user) {
        if(!$user->has_permission('revoke-permission-from-user')) {
            // Log auth break
            return $this->deny("You don't have permission to revoke permissions from users. This activity will be reviewed by site owners");
        }

        return true;
    }

    public function able_to_delete_permission(User $user) {
        return $user->has_permission('delete-permission');
    }
    public function delete_permission(User $user) {
        if(!$user->has_permission('delete-permission')) {
            // Log auth break
            return $this->deny("You don't have permission to delete permissions. This activity will be reviewed by site owners");
        }

        return true;
    }
}
