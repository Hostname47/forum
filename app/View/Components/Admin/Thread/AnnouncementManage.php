<?php

namespace App\View\Components\Admin\Thread;

use Illuminate\View\Component;
use App\Models\{Thread};

class AnnouncementManage extends Component
{

    public $announcement;
    public $owner;
    public $content;
    public $forum;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
        $this->forum = $announcement->category->forum;
        $this->owner = $announcement->user;

        $content = str_replace('&gt;', '>', $announcement->mediumcontentslice);
        $content = str_replace("\r\n", "  \n", $content);
        $this->content = \Markdown::parse($content);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.thread.announcement-manage');
    }
}
