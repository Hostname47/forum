<?php

namespace App\View\Components\Admin\Thread;

use Illuminate\View\Component;
use App\Models\Thread;

class ThreadReviewComponent extends Component
{
    public $thread;
    public $threadowner;
    public $checkuservote=false;
    
    public function __construct($thread, $checkuservote=false)
    {
        $this->thread = $thread;
        /**
         * Please note the ternary syntax below : sometimes we pass the thread along with its owner eager
         * loaded. So if the thread has user already eager loaded we simply return it as threadowner instead
         * of fetching it again
         */
        $this->threadowner = isset($thread->user) ? $thread->user : $thread->user()->withoutGlobalScopes()->first();
        /**
         * if checkuservote(user id passed to it) is supplied, we have to check the thread votes
         * and verify if that user with id passed to checkuservote parameter if he upvoted or downvoted
         * the thread by showing that in viewer
         * 
         * Important: only supply $checkuservote if you are 100% sure that the user passed was already vote the thread
         */
        if($checkuservote)
            $this->checkuservote = ($thread->upvoted($checkuservote)) ? 1 : -1;
            
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.thread.thread-review-component', $data);
    }
}
