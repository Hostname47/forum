<?php

namespace App\Policies;

use App\Models\{User, Thread, Category, Forum, CategoryStatus, Authorizationbreak, AuthBreakType};
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Exceptions\UserBannedException;
use App\Classes\Helper;

class ThreadPolicy
{
    use HandlesAuthorization;

    const THREADS_RATE_PER_DAY = 240;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        // if($user->isSiteowner())
        //     return true;
    }

    public function create(User $user) {
        return true;
    }

    public function able_to_edit(User $user, Thread $thread) {
        if($thread->user_id != $user->id)
            return false;

        return true;
    }

    public function edit(User $user, Thread $thread) {
        if(!($thread->user_id == $user->id || $user->has_permission('force-edit-thread')))
            return false;

        return true;
    }

    /**
     * Determine whether the user can store models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user, $data, $helpers=[])
    {
        if($user->isBanned()) {
            return $this->deny(__("You can't create new posts because you're currently banned"));
        }
        
        if($user->threads()->withoutGlobalScopes()->today()->count() >= self::THREADS_RATE_PER_DAY) {
            $user->log_authbreak('thread-share-daily-limit-reached');
            return $this->deny(__("You reached your posts sharing limit allowed per day, try out later") . '. (' . self::THREADS_RATE_PER_DAY . ' ' . __('posts') . ')');
        }

        $category = isset($helpers['category']) 
            ? $helpers['category'] 
            : Category::withoutGlobalScopes()->find($data['category_id']);
        $category_status = $category->status->slug;
        $forum = isset($helpers['forum']) 
            ? $helpers['forum'] 
            : Forum::withoutGlobalScopes()->find($category->forum_id);
        $forum_status = $forum->status->slug;

        // Verify the category status
        if($category_status != 'live') {
            if($category_status == 'closed')
                return $this->deny(__("You could not share posts on a closed category"));
            if($category_status == 'under-review')
                return $this->deny(__('This category is under review. (Be careful, this is unauthorized action)'));
            if($category_status == 'archived')
                return $this->deny(__("You could not share posts on archived categories"));
        }

        // Verify the forum status
        if($forum_status != 'live') {
            if($forum_status == 'closed')
                return $this->deny(__("You could not share posts on a closed forum"));
            if($forum_status == 'under-review')
                return $this->deny(__("You could not share posts on a forums under review"));
            if($forum_status == 'archived')
                return $this->deny(__("You could not share posts on a archived forums"));
        }

        
        // Verify category by preventing normal user to post on announcements
        if($category->slug == 'announcements' && !$user->has_permission('create-announcement')) {
            $user->log_authbreak('try-to-share-announcement-without-permission');
            return $this->deny(__("You could not share announcements because you don't have the right privileges"));
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Thread  $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread, $catid=false)
    {
        if($user->isBanned())
            return $this->deny(__("You can't edit your posts because you're currently banned"));

        if($thread->status->slug == 'closed') {
            return $this->deny(__("You could not update a closed post"));
        }

        if($catid) { // catid is false if the user doesn't change the category because we want to check category only if the user change it
            if(Category::find($catid)->slug == 'announcements') {
                $user->log_authbreak('abusively-change-thread-category-to-announcement', ['resource_id'=>$thread->id, 'resource_type'=>'Thread']);
                return $this->deny(__("You don't have permission to share announcements"));
            }
        }

        if($thread->user_id != $user->id && !$user->has_permission('force-edit-thread')) {
            $user->log_authbreak('update-thread-that-is-not-belong-to-the-updater', ['resource_id'=>$thread->id, 'resource_type'=>'Thread']);
            return $this->deny(__("You can't update this post because you don't own it. Be careful ! These actions could lead your account to be banned"));
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Thread  $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));

        if($thread->user_id != $user->id) {
            $user->log_authbreak('delete-thread-that-does-not-belong-to-deleter', ['resource_id'=>$thread->id, 'resource_type'=>'Thread']);
            return $this->deny(__("You can't delete this post because you don't own it. Be careful ! These actions could lead your account to be banned"));
        }

        return true;
    }

    public function save(User $user, Thread $thread, $data) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));

        // Check first if it exists; only save it if it's not exist
        $saved = $thread->is_saved;
        if($saved && $data['save_switch'] == 'save')
            return $this->deny(__("You cannot save this post because it is already saved"));
        if(!$saved && $data['save_switch'] == 'unsave')
            return $this->deny(__("You cannot unsave this post because it is not saved"));

        return true;
    }

    public function restore(User $user, $thread) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        $status = $thread->status->slug;

        if($status == 'deleted-by-an-admin')
            return $this->deny(__("You can't restore this post because it is deleted by admins"));

        if($status == 'closed-and-deleted-by-an-admin')
            return $this->deny(__("You can't restore this post because it is deleted by admins"));

        return true;
    }

    public function destroy(User $user, Thread $thread)
    {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        $status = $thread->status->slug;
        if($status == 'closed')
            return $this->deny(__("You can't delete this post because it was closed by admins"));

        if($status == 'deleted-by-an-admin')
            return $this->deny(__("You can't delete this post because it was deleted by admins"));

        if($status == 'closed-and-deleted-by-an-admin')
            return $this->deny(__("You can't delete this post because it was deleted by admins"));

        if($thread->user_id != $user->id) {
            $user->log_authbreak('trying-to-destroy-thread-that-does-not-belong-to-destroyer', ['resource_id'=>$thread->id, 'resource_type'=>'Thread']);
            return $this->deny(__("You can't delete this post because you don't own it. Be careful ! These actions could lead your account to be banned"));
        }

        /**
         * Here we prevent user from deleting a thread that have more than 3 reports and one of the reports is not reviewed yet
         * The user can only delete a thread with many reports if all reports are reviewed
         */
        $reportcounts = \DB::table('reports')
            ->selectRaw('COUNT(*) as count, SUM(reviewed) as reviewcount')
            ->where('reportable_id', $thread->id)
            ->where('reportable_type', 'App\Models\Thread')->first();
        if($reportcounts->count > 3 && $reportcounts->reviewcount < $reportcounts->count)
            return $this->deny(__("You can't delete this post because it has some unreviewed reportings. Admins will review this post as soon as possible to make sure the post respect our guidelines."));

        return true;
    }

    public function untick_thread(User $user, Thread $thread) {
        if(is_null($thread))
            return $this->deny(__("Oops something went wrong. Please refresh the page"));

        if($user->id != $thread->user_id)
            return $this->deny(__("Unauthorized action. Admins will review this unauthorized action"));

        return true;
    }

    public function create_announcement(User $user) {
        return $user->has_permission('create-announcement');
    }

    public function update_announcement(User $user, $announcement) {
        if($user->has_permission('update-announcement'))
            return true;

        return $user->id == $announcement->user_id;
    }

    public function delete_announcement(User $user, $announcement) {
        if($user->has_permission('delete-announcement'))
            return true;

        return $user->id == $announcement->user_id;
    }

    public function close_thread(User $user) {
        return $user->has_permission('close-thread');
    }

    public function open_thread(User $user) {
        return $user->has_permission('open-closed-thread');
    }

    public function delete_thread(User $user) {
        return $user->has_permission('delete-thread');
    }

    public function delete_thread_permanently(User $user) {
        return $user->has_permission('delete-thread-permanently');
    }

    public function restore_thread(User $user) {
        return $user->has_permission('restore-thread');
    }
}
