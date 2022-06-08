<?php

namespace App\View\Components\Admin\User\Review;

use Illuminate\View\Component;

class ReviewWarningsViewer extends Component
{
    public $user;
    public $warnings;
    public $totalwarningscount;

    public function __construct($user)
    {
        $this->user = $user;
        $this->warnings = $user->warnings()->orderBy('created_at', 'desc')->take(8)->get();
        $this->totalwarningscount = $user->warnings()->count();
    }

    public function render($data=[])
    {
        return view('components.admin.user.review.review-warnings-viewer', $data);
    }
}
