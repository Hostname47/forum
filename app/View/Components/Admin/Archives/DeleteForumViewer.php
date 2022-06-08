<?php

namespace App\View\Components\Admin\Archives;

use Illuminate\View\Component;

class DeleteForumViewer extends Component
{
    public $forum;
    public $categories;
    public function __construct($forum)
    {
        $this->forum = $forum;
        $this->categories = $forum->categories()->withoutGlobalScopes()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.archives.delete-forum-viewer', $data);
    }
}
