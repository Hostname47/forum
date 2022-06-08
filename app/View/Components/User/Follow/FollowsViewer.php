<?php

namespace App\View\Components\User\Follow;

use Illuminate\View\Component;

class FollowsViewer extends Component
{
    public $user;
    public $follows;
    public $totalfollowscount;

    public function __construct($user)
    {
        $this->user = $user;
        $this->follows = $user->follows()->orderBy('username')->take(10)->get();
        $this->totalfollowscount = $user->follows()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.follow.follows-viewer', $data);
    }
}
