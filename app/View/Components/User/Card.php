<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use App\Models\User;

class Card extends Component
{
    public $user;
    public $activestatus;

    public function __construct(User $user)
    {
        $this->activestatus = \Cache::has('user-is-online-' . $user->id) ? 'active' : 'inactive';
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.card', $data);
    }
}
