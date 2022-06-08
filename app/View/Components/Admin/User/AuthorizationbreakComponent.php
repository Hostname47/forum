<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;
use App\Models\User;

class AuthorizationbreakComponent extends Component
{
    public $authbreak;
    public $infos;
    public $showowner;
    public $owner;

    public function __construct($authbreak, $showowner=false)
    {
        $this->authbreak = $authbreak;
        $this->infos = is_null($authbreak->data) ? null : json_decode($authbreak->data);
        $this->showowner = $showowner;

        if($showowner)
            $this->owner = !is_null($authbreak->user) ? $authbreak->user : User::withoutGlobalScopes()->find($authbreak->user_id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.authorizationbreak-component', $data);
    }
}
