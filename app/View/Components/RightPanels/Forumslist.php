<?php

namespace App\View\Components\RightPanels;

use Illuminate\View\Component;
use App\Models\Forum;
use Illuminate\Support\Facades\Cache;

class Forumslist extends Component
{
    const FORUMS_LIST_SIZE = 6;

    public $forums;
    
    public function __construct()
    {
        $this->forums = Cache::rememberForever('right_panel_forums_list', function () {
            return Forum::take(self::FORUMS_LIST_SIZE)->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.right-panels.forumslist');
    }
}
