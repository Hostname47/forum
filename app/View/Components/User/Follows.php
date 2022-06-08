<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Follow};

class Follows extends Component
{
    public $user;
    public $followed;

    /**
     * Please keep in mind that followers and follows components use the same view (see render method below)
     * because they represented users who follow or followed which are pretty similar
     */
    public function __construct(User $followeduser)
    {
        $this->user = $followeduser;
        if(Auth::check()) {
            $this->followed = (bool) auth()->user()->follows()->where('users.id', $followeduser->id)->count() > 0;
        } else
            $this->followed = false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.user-follow-component', $data);
    }
}
