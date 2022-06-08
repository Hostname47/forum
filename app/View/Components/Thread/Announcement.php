<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\{Thread};
use App\Scopes\{ExcludeAnnouncements};
use Carbon\Carbon;

class Announcement extends Component
{
    public $announcement;
    public $forum;
    public $at;
    public $at_hummans;
    
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
        $this->forum = $announcement->category->forum;
        $this->at = (new Carbon($announcement->created_at))->isoFormat("dddd D MMM YYYY - H:M A");
        $this->at_hummans = (new Carbon($announcement->created_at))->diffForHumans();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.announcement');
    }
}
