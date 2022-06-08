<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;

class BanComponent extends Component
{
    public $ban;

    public function __construct($ban)
    {
        $this->ban = $ban;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.ban-component', $data);
    }
}
