<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Classes\Helper;

class UserPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, $u)
    {
        if($user->id != $u->id) return false;
        
        return true;
    }

    public function able_to_update(User $user, $u) {
        if($user->isBanned())
            return false;

        if($user->id != $u->id)
            return false;
        
        return true;
    }

    public function update(User $user)
    {
        if($user->isBanned())
            return $this->deny(__("You can't update your settings because you're currently banned"));
        
        return true;
    }

    public function set_first_password(User $user) {
        if($user->isBanned())
            return $this->deny(__("You can't update your settings because you're currently banned"));

        if(!is_null($user->password)) {
            $user->log_authbreak('trying-to-set-new-password-while-has-already-password', ['resource_id'=>$user->username, 'resource_type'=>'User']);
            return $this->deny(__('This account has already a password. Admins will review this unauthorized action'));
        }

        return true;
    }

    public function update_password(User $user) {
        if($user->isBanned())
            return $this->deny(__("You can't update your settings because you're currently banned"));

        if(is_null($user->password)) {
            $user->log_authbreak('trying-to-update-password-wihout-an-attached-password', ['resource_id'=>$user->username, 'resource_type'=>'User']);
            return $this->deny(__('This account does not have any attached password. Admins will review this unauthorized action'));
        }
        
        return true;
    }

    public function deactivate_account(User $user) {
        if($user->isBanned())
            return $this->deny(__("You can't deactivate your account because you're currently banned"));

        return true;
    }

    public function delete_user_avatar(User $user) {
        return $user->has_permission('user-avatar-delete');
    }

    public function delete_user_cover(User $user) {
        return $user->has_permission('user-cover-delete');
    }

    public function clear_user_warning(User $user) {
        return $user->has_permission('remove-warning-from-user');
    }

    public function clear_user_strike(User $user) {
        return $user->has_permission('remove-strike-from-user');
    }

    public function ban_user_temporarily(User $user) {
        return $user->has_permission('ban-user-temporarily');
    }

    public function ban_user_permanently(User $user) {
        return $user->has_permission('ban-user-permanently');
    }

    public function unban_user(User $user) {
        return $user->has_permission('unban-user');
    }

    public function review_user_resources_and_activities(User $user) {
        return $user->has_permission('review-user-resources-and-activities');
    }

    public function patch_resource_reports_review(User $user) {
        return $user->has_permission('patch-resource-reports-review');
    }

    public function warn_group_of_users(User $user) {
        return $user->has_permission('warn-group-of-users');
    }

    public function strike_group_of_users(User $user) {
        return $user->has_permission('strike-group-of-users');
    }

    public function mark_contact_message_as_read(User $user) {
        return $user->has_permission('mark-contact-message-as-read');
    }

    public function delete_contact_message(User $user) {
        return $user->has_permission('delete-contact-message');
    }

    public function delete_feedback(User $user) {
        return $user->has_permission('delete-feedback-message');
    }
}
