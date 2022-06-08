<?php

namespace App\View\Components\User\Follow;

use Illuminate\View\Component;

class FollowersViewer extends Component
{
    public $user;
    public $followers;
    public $totalfollowerscount;

    public function __construct($user)
    {
        $this->user = $user;
        $this->followers = $user->followers()->orderBy('username')->take(10)->get();
        $this->totalfollowerscount = $user->followers()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.follow.followers-viewer', $data);
    }
}
