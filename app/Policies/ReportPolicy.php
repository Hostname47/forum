<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Thread, Post, Report};

class ReportPolicy
{
    use HandlesAuthorization;

    const THREAD_REPORT_ATTEMPTS = 20;
    const POST_REPORT_ATTEMPTS = 36;

    public function thread_report(User $user, $thread) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        // User could report threads with a limited number per day (THREAD_REPORT_ATTEMPTS)
        $today_threads_reports = $user->reportings()->where('reportable_type', 'App\Models\Thread')->whereRaw('DATE(created_at) = CURDATE()')->count();

        if($today_threads_reports >= self::THREAD_REPORT_ATTEMPTS) {
            $user->log_authbreak('thread-reports-daily-limit-reached');
            return $this->deny(__("You reached your posts reporting limit allowed per day, try out later") . '. (' . self::THREAD_REPORT_ATTEMPTS . ' ' . 'reports' . ')');
        }
        
        // User can only report a resource once
        $found = $user->reportings()->where('reportable_type', 'App\Models\Thread')->where('reportable_id', $thread->id)->count() > 0;
        if($found) return $this->deny(__("You can't report this post because you already report it"));

        return true;
    }

    public function post_report(User $user, $post) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action. Your account is currently banned"));
        
        // User could report threads with a limited number per day (THREAD_REPORT_ATTEMPTS)
        $today_posts_reports = $user->reportings()->where('reportable_type', 'App\Models\Post')->whereRaw('DATE(created_at) = CURDATE()')->count();

        if($today_posts_reports >= self::POST_REPORT_ATTEMPTS) {
            $user->log_authbreak('post-reports-daily-limit-reached');
            return $this->deny(__("You reached your replies reporting limit allowed per day, try out later") . '. (' . self::THREAD_REPORT_ATTEMPTS . ' ' . 'reports' . ')');
        }

        // User can only report a resource once
        $found = $user->reportings()->where('reportable_type', 'App\Models\Post')->where('reportable_id', $post->id)->count() > 0;
        if($found) return $this->deny(__("You can't report this reply because you already report it"));

        return true;
    }
}
