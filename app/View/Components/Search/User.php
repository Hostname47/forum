<?php

namespace App\View\Components\Search;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\User as Usr;

class User extends Component
{

    public $user;
    public $avatar;
    public $member_since;
    public function __construct(Usr $user)
    {
        $this->user = $user;
        $this->member_since = (new Carbon($user->created_at))->toFormattedDateString();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search.user');
    }
}
