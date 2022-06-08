<?php

namespace App\View\Components\Admin\Forumsandcategories;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\Forum;

class ForumSection extends Component
{
    public $forum;

    public $today_threads_count;
    public $thisweek_threads_count;
    public $thismonth_threads_count;
    public $totalthreads_count;

    public $today_posts_count;
    public $thisweek_posts_count;
    public $thismonth_posts_count;
    public $totalposts_count;

    public $todaythreads_votes_count;
    public $thisweekthreads_votes_count;
    public $thismonththreads_votes_count;
    public $totalthreads_votes_count;

    public $todayposts_votes_count;
    public $thisweekposts_votes_count;
    public $thismonthposts_votes_count;
    public $totalposts_votes_count;

    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
        // Threads statistics
        $this->today_threads_count = $forum->threads()->withoutGlobalScopes()->whereRaw('Date(threads.created_at) = CURDATE()')->count();
        $this->thisweek_threads_count = $forum->threads()->withoutGlobalScopes()
            ->whereBetween('threads.created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
            ->count();
        $this->thismonth_threads_count = $forum->threads()->withoutGlobalScopes()->whereYear('threads.created_at', Carbon::now()->year)
            ->whereMonth('threads.created_at', Carbon::now()->month)
            ->count();
        $this->totalthreads_count = $forum->threads()->withoutGlobalScopes()->count();
        // Posts statistics
        $this->today_posts_count = $forum->posts()->withoutGlobalScopes()->whereRaw('Date(posts.created_at) = CURDATE()')->count();
        $this->thisweek_posts_count = $forum->posts()->withoutGlobalScopes()
            ->whereBetween('posts.created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
            ->count();
        $this->thismonth_posts_count = $forum->posts()->withoutGlobalScopes()->whereYear('posts.created_at', Carbon::now()->year)
            ->whereMonth('posts.created_at', Carbon::now()->month)
            ->count();
        $this->totalposts_count = $forum->posts()->withoutGlobalScopes()->count();
        // Votes statistics
        //      threads - votes
        $this->todaythreads_votes_count = $forum->threadsvotes()->withoutGlobalScopes()->whereRaw('Date(votes.created_at) = CURDATE()')->count();
        $this->thisweekthreads_votes_count = $forum->threadsvotes()->withoutGlobalScopes()
            ->whereBetween('votes.created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
            ->count();
        $this->thismonththreads_votes_count = $forum->threadsvotes()->withoutGlobalScopes()->whereYear('votes.created_at', Carbon::now()->year)
            ->whereMonth('votes.created_at', Carbon::now()->month)
            ->count();
        $this->totalthreads_votes_count = $forum->threadsvotes()->withoutGlobalScopes()->count();
        //      posts - votes
        $this->todayposts_votes_count = $forum->postsvotes()->withoutGlobalScopes()->whereRaw('Date(votes.created_at) = CURDATE()')->count();
        $this->thisweekposts_votes_count = $forum->postsvotes()->withoutGlobalScopes()
            ->whereBetween('votes.created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
            ->count();
        $this->thismonthposts_votes_count = $forum->postsvotes()->withoutGlobalScopes()->whereYear('votes.created_at', Carbon::now()->year)
            ->whereMonth('votes.created_at', Carbon::now()->month)
            ->count();
        $this->totalposts_votes_count = $forum->postsvotes()->withoutGlobalScopes()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.forumsandcategories.forum-section', $data);
    }
}
