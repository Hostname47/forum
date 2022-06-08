<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;

class ReviewPostsViewer extends Component
{
    public $user;
    public $posts;
    public $poststotalcount;
    public $hasmore;

    public function __construct($user)
    {
        $posts = $user->userposts()->withoutGlobalScopes()->orderBy('created_at', 'desc')->take(11)->get();
        $hasmore = $posts->count() > 10;
        $this->posts = $posts->take(10);
        $this->hasmore = $hasmore;
        $this->user = $user;
        $this->poststotalcount = $user->userposts()->withoutGlobalScopes()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.review.review-posts-viewer', $data);
    }
}
