<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;
use App\Models\User;
use Carbon\Carbon;

class SignupUser extends Component
{
    public $user;
    public $signed_at_humans;
    public $signed_at;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->signed_at_humans = (new Carbon($user->created_at))->diffForHumans();
        $this->signed_at = (new Carbon($user->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.signup-user', $data);
    }
}
