<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use App\Models\User;

class RightPanelUserCard extends Component
{
    public $user;
    public $userthreadscount;
    public $withcover;
    
    public function __construct(User $user, $withcover=false, $data=[])
    {
        $this->user = $user;
        $this->userthreadscount = isset($data['threadscount']) ? $data['threadscount'] : $user->threads()->count();
        $this->withcover = $withcover;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user.right-panel-user-card');
    }
}
