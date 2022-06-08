<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;

class ReviewAuthbreaksViewer extends Component
{
    public $user;
    public $authbreaks;
    public $totalauthbreaks;
    
    public function __construct($user)
    {
        $this->user = $user;
        $this->authbreaks = $user->authorizationbreaks()->with('breaktype')->orderBy('created_at', 'desc')->take(12)->get();
        $this->totalauthbreaks = $user->authorizationbreaks()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.review.review-authbreaks-viewer', $data);
    }
}
