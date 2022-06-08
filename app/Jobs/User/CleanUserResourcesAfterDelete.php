<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use App\Models\{User, Like, Vote, Notification, ProfileView};
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;

class CleanUserResourcesAfterDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user->withoutRelations();
    }

    public function handle()
    {
        $user = $this->user;

        /**
         * The following queries and operations will clean up all user resources
         */

        DB::beginTransaction();
        try {
            // user likes (on posts and threads)
            Like::where('user_id', $user->id)->delete();
            // user votes (on posts and threads)
            Vote::where('user_id', $user->id)->delete();
            /**
             * saved threads
             * The following query delete user saved threads RECORDS in saved_threads table (not saved threads)
             * For other users who save this user's threads, saved threads records will be deleted in cascading
             * when we will delete this user's threads
             */
            DB::statement("DELETE FROM saved_threads WHERE user_id=$user->id");
            // contact messages
            DB::statement("DELETE FROM contact_messages WHERE user=$user->id");
            // emoji-feedbacks
            DB::statement("DELETE FROM emoji_feedback WHERE user_id=$user->id");
            // Unverified faqs
            DB::statement("DELETE FROM faqs WHERE user_id=$user->id AND live=0");
            // feedbacks
            DB::statement("DELETE FROM feedbacks WHERE user_id=$user->id");
            // followers records
            DB::statement("DELETE FROM follows WHERE follower=$user->id");
            // follows users (records where other users follow this user)
            DB::statement("DELETE FROM follows WHERE followable_id=$user->id");
            // notifications
            Notification::where('data->action_user', $user->id)->orWhere('notifiable_id', $user->id)->delete();
            // notifications disabled
            $user->notificationsdisables()->delete();
            // Delete roles and permissions
            DB::statement("DELETE FROM permission_user WHERE user_id=$user->id");
            DB::statement("DELETE FROM role_user WHERE user_id=$user->id");
            // profile views
            ProfileView::where('visited_id', $user->id)->delete();
            // reportings
            $user->reportings()->delete();
            // reach records
            $user->reach()->delete();
            // user visits
            $user->visits()->delete();
            /**
             * Every thread deleted will delete all its associated relationships either by cascading
             * or in boot method in thread model for morph relationships
             * This may take some time so it is better to use it as a queued job
             */
            foreach ($user->threads()->withoutGlobalScopes()->cursor() as $thread) {
                $thread->forceDelete();
            }
            // user proposal options on other users's polls
            DB::statement("DELETE FROM polloptions WHERE user_id=$user->id");
            DB::statement("DELETE FROM optionsvotes WHERE user_id=$user->id");

            $user->personal->update(['birth'=>null, 'country'=>null, 'city'=>null, 'phone'=>null, 'website'=>null, 'facebook'=>null, 'twitter'=>null, 'instagram'=>null]);
            $user->update(['avatar'=>null, 'cover'=>null]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->user->id))->expireAfter(180)];
    }
}
