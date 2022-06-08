<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use App\Models\Forum;

class Quickaccess extends Component
{
    public $forums;
    public $categories;

    public function __construct()
    {
        $forums = Forum::all();
        $this->forums = $forums;
        $this->categories = $forums->first()->categories()->excludeannouncements()->get();
    }

    public function render($data=[])
    {
        return view('components.user.quickaccess', $data);
    }
}
