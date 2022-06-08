<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Forum, Thread};
use Carbon\Carbon;

class ForumComponent extends Component
{
    public $forum;
    public $threads_count;
    public $posts_count;
    public $isclosed=false;
    // Last thread
    public $thread;

    public function __construct($forum)
    {
        $fstatus = $forum->status;
        $this->forum = $forum;
        $this->isclosed = $fstatus->slug == 'closed';
        $this->threads_count = $forum->threads()->withoutGlobalScopes()->count();
        $this->posts_count = $forum->posts()->withoutGlobalScopes()->count();

        $this->thread = $forum->threads()->withoutGlobalScopes()->setEagerLoads([])->orderBy('created_at', 'desc')->first();
    }

    public function render($data=[])
    {
        return view('components.forum-component', $data);
    }
}
