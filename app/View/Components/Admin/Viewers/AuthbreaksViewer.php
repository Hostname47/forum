<?php

namespace App\View\Components\Admin\Viewers;

use Illuminate\View\Component;
use App\Models\Authorizationbreak;

class AuthbreaksViewer extends Component
{
    public $totalcount;
    public $authbreaks;
    
    public function __construct()
    {
        $this->totalcount = Authorizationbreak::count();
        $this->authbreaks = Authorizationbreak::with(['user', 'breaktype'])->orderBy('created_at', 'desc')->take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.viewers.authbreaks-viewer', $data);
    }
}
