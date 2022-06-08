<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;

class ReviewThreadsViewer extends Component
{
    public $user;
    public $threads;
    public $threadstotalcount;
    public $hasmore;

    public function __construct($user)
    {
        $threads = $user->threads()->withoutGlobalScopes()->orderBy('created_at', 'desc')->take(11)->get();
        $hasmore = $threads->count() > 10;
        $this->threads = $threads->take(10);
        $this->hasmore = $hasmore;
        $this->user = $user;
        $this->threadstotalcount = $user->threads()->withoutGlobalScopes()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.review.review-threads-viewer', $data);
    }
}
