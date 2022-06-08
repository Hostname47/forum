<?php

namespace App\View\Components\Admin\Announcement;

use Illuminate\View\Component;

class DeleteViewer extends Component
{
    public $announcement;
    public $forum;
    public $currentuser;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
        $this->forum = $announcement->category->forum;
        $this->currentuser = auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.announcement.delete-viewer',$data);
    }
}
