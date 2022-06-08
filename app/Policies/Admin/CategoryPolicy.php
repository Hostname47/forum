<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Forum, Category};

class CategoryPolicy
{
    use HandlesAuthorization;

    // public function before(User $user, $ability)
    // {
    //     if($user->isSiteOwner()) {
    //         return true;
    //     }
    // }

    public function able_to_store(User $user) {
        return $user->has_permission('create-category');
    }

    public function store(User $user, $data) {
        if(!$user->has_permission('create-category'))
            return $this->deny("You don't have permission to create categories. (This action will be sent to site owners for review)");

        $forum = Forum::withoutGlobalScopes()->find($data['forum_id']);
        $name = $data['category']; // category name
        $slug = $data['slug']; // category slug
        
        /**
         * Icon only included with the data if the current admin is super-admin
         * If the icon is present, and is not null (means its value is included), and the admin is not a super admin we deny the request)
         */
        if(isset($data['icon']) && !$user->isSuperadmin())
            return $this->deny("Only super admin could add raw icons. (This action will be reviewed by admins)");

        // category is unique per forum (forum could not have two categories with the same name or same slug)
        if($forum->categories()->withoutGlobalScopes()->where('slug', $slug)->count())
            return $this->deny("Forums could not have two categories with the same slug");

        if($forum->categories()->withoutGlobalScopes()->where('category', $name)->count())
            return $this->deny("Forums could not have two categories with the same name");

        // Check forum status
        $fstatus = $forum->status->slug;

        if($fstatus == 'archived')
            return $this->deny("You can't add categories on archived forums");

        return true;
    }

    public function able_to_update_category(User $user) {
        return $user->has_permission('update-category-infos');
    }
    public function update_category(User $user, $data) {
        if(!$user->has_permission('update-category-infos'))
            return $this->deny("You don't have permission to update category informations. (This action will be sent to site owners to review)");

        $name = $data['category']; // category name
        $slug = $data['slug']; // category slug
        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $forum = Forum::withoutGlobalScopes()->find($category->forum_id);

        // If there is a category within the same forum with the same name and different id, it means there is duplicates
        $category_name_duplicated = (bool) $forum->categories()->withoutGlobalScopes()
            ->where('category', $name)
            ->where('id', '<>', $data['cid'])->count();
        if($category_name_duplicated)
            return $this->deny("The selected name already exists in another category");

        $category_slug_duplicated = (bool) $forum->categories()->withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('id', '<>', $data['cid'])->count();
        if($category_slug_duplicated)
            return $this->deny("The selected slug already exists in another category");
        
        // Prevernt change announcements category slug
        if($category->slug == 'announcements' && $slug != 'announcements')
            return $this->deny('You cannot change announcements category slug');

        return !true;
    }

    public function able_to_approve_category(User $user) {
        return $user->has_permission('approve-category');
    }
    public function approve_category(User $user, $data) {
        if(!$user->has_permission('approve-category'))
            return $this->deny("You don't have permission to approve categories. (This action will be sent to site owners to review)");

        $category = Category::withoutGlobalScopes()->find($data['cid']);
        $forum = $category->forum()->withoutGlobalScopes()->first();
        $cstatus = $category->status->slug;
        $fstatus = $forum->status->slug;

        if($fstatus == 'under-review')
            return $this->deny('You cannot approve this category because the parent forum is under review');

        if($fstatus == 'archived')
            return $this->deny('You cannot approve this category because the parent forum is currently archived');

        if($cstatus != 'under-review')
            return $this->deny('This category is already approved');

        return true;
    }

    public function able_to_ignore_category(User $user) {
        return $user->has_permission('ignore-category');
    }
    public function ignore_category(User $user, $category) {
        if(!$user->has_permission('ignore-category'))
            return $this->deny("You don't have permission to ignore categories. (This action will be reviewed by site owners)");

        $status = $category->status->slug;
        
        if($status != 'under-review')
            return $this->deny("You cannot ignore this category because it is already approved");

        return true;
    }

    public function able_to_update_category_status(User $user) {
        return $user->has_permission('update-category-status');
    }
    public function update_category_status(User $user, $category) {
        if(!$user->has_permission('update-category-status'))
            return $this->deny("You don't have permission to change category status. (This action will be reviewed by site owners)");

        $forum = $category->forum()->withoutGlobalScopes()->first();
        $fstatus = $forum->status->slug;
        $cstatus = $category->status->slug;

        if($fstatus == 'archived')
            return $this->deny('You cannot change status of this category because the parent forum is archived');
        if($fstatus == 'under-review')
            return $this->deny('You cannot change status of this category because the parent forum is under-review');

        // We can't update category status if it is under review because we can do this only if super admin approve it
        if($cstatus == 'under-review')
            return $this->deny('You cannot change status of this category because it is currently under review.');
        if($cstatus == 'archived')
            return $this->deny('You cannot change status of this category because it is archived. you have to restore it back before changing its status.');
        if($category->slug == 'announcements')
            return $this->deny('You cannot change the status of announcements category');

        return true;
    }

    public function able_to_archive_category(User $user) {
        return $user->has_permission('archive-category');
    }
    public function archive_category(User $user, $category, $forum) {
        if(!$user->has_permission('archive-category'))
            return $this->deny("You don't have permission to archive categories. This action will be reviewed by site owners");

        $cstatus = $category->status->slug;
        $fstatus = $forum->status->slug;

        if($cstatus == 'under-review')
            return $this->deny("You can't archive this category because it is currently under review");
        if($cstatus == 'archived')
            return $this->deny("This category is already archived");

        if($cstatus == 'under-review')
            return $this->deny("You can't archive this category because the parent forum is currently under review");
        if($cstatus == 'archived')
            return $this->deny("You can't archive this cateory because the parent forum is already archived");

        if($category->slug == 'announcements')
            return $this->deny('You cannot archive announcements categories');

        return true;
    }
    
    public function able_to_restore_category(User $user) {
        return $user->has_permission('restore-category');
    }
    public function restore_category(User $user, $category, $forum) {
        if(!$user->has_permission('restore-category'))
            return $this->deny("You don't have permission to restore archived categories. This action will be reviewed by site owners");

        $fstatus = $forum->status->slug;
        $cstatus = $category->status->slug;

        if($fstatus == 'archived')
            return $this->deny('You cannot restore this category because the parent forum is archived');
        // We don't have to check under review(u-r) forums because u-r forums could not have archived categories
        // and u-r forums could not have categories with status different than u-r

        if($cstatus != 'archived')
            return $this->deny('The current category is not archived to be restored');

        return true;
    }

    public function able_to_delete_category(User $user) {
        return $user->has_permission('destroy-category');
    }
    public function delete_category(User $user, $category, $forum) {
        if(!$user->has_permission('destroy-category'))
            return $this->deny("You don't have permission to destroy categories. This action will be reviewed by site owners");
        
        if($category->status->slug != 'archived')
            return $this->deny('You cannot delete this category because it is not archived');

        if($category->slug == 'announcements')
            return $this->deny('You cannot delete announcements categories. If the parent forum is archived, the announcements category will only deleted if the forum is deleted');

        if($forum->categories()->count() == 1)
            return $this->deny('You cannot delete this category because forums need at least one category to be available.');

        return true;
    }
}
