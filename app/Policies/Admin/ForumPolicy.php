<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        // if ($user->isSiteOwner())
        //     return true;
    }

    public function add_forum(User $user) {
        return $user->has_permission('create-forum');
    }
    public function store_forum(User $user, $data) {
        if(isset($data['icon']) && !$user->isSuperadmin()) {
            // log auth break
            return $this->deny('Only super admins could add raw icons. (This action will be reviewed by site owners)');
        }
        
        if(!$user->has_permission('create-forum')) {
            // log auth break
            return $this->deny("You cannot create forums because you don't have permission. (This action will be reviewed by site owners)");
        }

        return true;
    }

    public function able_to_approve_forum(User $user) {
        return $user->has_permission('approve-forum');
    }
    
    public function approve_forum(User $user, $forum) {
        if(!$user->has_permission('approve-forum'))
            return $this->deny('You cannot approve forums due to lack of permission. (This action will be reviewed by admins)');

        if($forum->status->slug != 'under-review')
            return $this->deny('Forum already approved.');

        return true;
    }

    public function able_to_ignore_forum(User $user) {
        return $user->has_permission('ignore-forum');
    }

    public function ignore_forum(User $user, $forum) {
        if(!$user->has_permission('ignore-forum'))
            return $this->deny('You cannot ignore forums due to lack of permission. (This action will be reviewed by admins)');

        if($forum->status->slug != 'under-review')
            return $this->deny("You can't ignore this forum because it is already approved. only under-review forums could be ignored and deleted");

        return true;
    }

    /**
     * The reason why we have edit_forum and update_forum is because edit forum used just
     * to verify if user has the ability to edit forum infos
     * update_forum instead is used in controller method when user click update to verify
     * and if the user does not have the permission we log auth break records (the thing we don't have to do with edit_forum)
     */
    public function edit_forum(User $user) {
        return $user->has_permission('update-forum-infos');
    }
    public function update_forum(User $user) {
        if(!$user->has_permission('update-forum-infos')) {
            // Log user ath break
            return $this->deny("You don't have the permission to update forums informations. (This action will be reviewed by site owners)");
        }

        return true;
    }

    public function able_to_update_forum_status(User $user) {
        return $user->has_permission('update-forum-status');
    }
    public function update_forum_status(User $user, $forum, $status) {
        if(!$user->has_permission('update-forum-status'))
            return $this->deny('You could not update forum status due to lack of permissions. (This action will be reviewed by admins)');
        
        $fstatus = $forum->status->slug;

        if($fstatus == 'under-review')
            return $this->deny("You can't change the status of this forum becaus it's currently under review");

        if($fstatus == 'archived')
            return $this->deny("You can't change the status of this forum becaus it's currently archived");
            
        if($status == 'under-review')
            return $this->deny("You can't change the status of approved forum back to under review");

        return true;
    }

    public function able_to_archive_forum(User $user) {
        return $user->has_permission('archive-forum');
    }
    public function archive_forum(User $user, $forum) {
        if(!$user->has_permission('archive-forum'))
            return $this->deny('You could not archive forums due to loack of permissions. (This action will be reviewed by admins)');

        $fstatus = $forum->status->slug;
        if($fstatus == 'under-review')
            return $this->deny("You cannot archive forums that are under review.");

        if($fstatus == 'archived')
            return $this->deny("This forum is already archived");

        return true;
    }

    public function able_to_restore_forum(User $user) {
        return $user->has_permission('restore-forum');
    }
    public function restore_forum(User $user, $forum) {
        if(!$user->has_permission('restore-forum'))
            return $this->deny('You could not restore forums due to lack of permissions. (This action will be reviewed by admins)');

        if($forum->status->slug != 'archived')
            return $this->deny('You cannot restore this forum because it is not archived');

        return true;
    }

    public function able_to_delete_forum(User $user) {
        return $user->has_permission('destroy-forum');
    }
    public function delete_forum(User $user, $forum) {
        if(!$user->has_permission('destroy-forum'))
            return $this->deny("You don't have permission to destroy forums. This action will be reviewed by site owners");

        if($forum->status->slug != 'archived')
            return $this->deny('You cannot delete this forum because it is not archived');

        return true;
    }
}
