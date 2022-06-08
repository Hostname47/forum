<?php

namespace App\View\Components\RightPanels;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\Thread;

class Recentthreads extends Component
{
    public $recent_threads;
    
    public function __construct()
    {
        /**
         * Cache::remember checks if cache has cached data for recent threads; If so it simply returns it;
         * otherwise it will cache rencent threads
         * 
         * we remember results forever for dev phase only and it will be reverted to chaching results for 2 minutes in prod
         */
        // $this->recent_threads = Cache::remember( 
        //     'recent-threads', 60, function() {
        //         return Thread::orderBy('created_at', 'desc')->take(5)->get();
        //     }
        // );
        $this->recent_threads = Cache::rememberForever(
            'recent-threads', function() {
                return Thread::orderBy('created_at', 'desc')->take(5)->get()->map(function($thread) {
                    return [
                        'thread'=>$thread,
                        'postscount'=>$thread->posts()->count(),
                        'votevalue'=>$thread->votevalue,
                    ];
                });
            }
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.right-panels.recentthreads');
    }
}
