<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;

class ReviewStrikesViewer extends Component
{
    public $user;
    public $strikes;
    public $totalstrikescount;

    public function __construct($user)
    {
        $this->user = $user;
        $this->strikes = $user->strikes()->orderBy('created_at', 'desc')->take(8)->get();
        $this->totalstrikescount = $user->strikes()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.review.review-strikes-viewer', $data);
    }
}
