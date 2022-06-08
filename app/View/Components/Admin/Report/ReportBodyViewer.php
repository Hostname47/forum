<?php

namespace App\View\Components\Admin\Report;

use Illuminate\View\Component;
use App\Models\{Report, User, Thread, Post};
use Carbon\Carbon;

class ReportBodyViewer extends Component
{
    public $report;
    public $reporter;
    public $resourcetype;
    public $content;
    public $at;
    public $athummans;
    // Case it's a thread
    public $thread;
    public $forum;
    public $category;
    public $threadowner;
    // Case it's a post
    public $post;
    public $postowner;

    public function __construct(Report $report)
    {
        $this->report = $report;
        $this->reporter = User::withoutGlobalScopes()->find($report->reporter);
        $this->athummans = (new Carbon($report->created_at))->diffForHumans();
        $this->at = (new Carbon($report->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");

        if($report->reportable_type == 'App\Models\Thread') {
            $this->resourcetype = 'thread';
            $thread = Thread::withoutGlobalScopes()->without('status', 'visibility', 'user')->find($report->reportable_id);
            $threadowner = $thread->user()->withoutGlobalScopes()->first();

            $this->thread = $thread;
            $this->threadowner = $threadowner;
            $this->category = $thread->category;
            $this->forum = $this->category->forum;
        } else if($report->reportable_type == 'App\Models\Post') {
            $this->resourcetype = 'post';
            $post = Post::withoutGlobalScopes()->find(intval($report->reportable_id));
            $postowner = $post->user()->withoutGlobalScopes()->first();
            
            $this->post = $post;
            $this->postowner = $postowner;
            $this->content = $post->contentslice;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.report.report-body-viewer', $data);
    }
}
