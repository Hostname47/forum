<?php

namespace App\View\Components\Admin\Report;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{Report,Thread,Post,User};

class ResourceReportManage extends Component
{
    public $rowid;
    public $rowbackground;

    public $report;
    public $reportbody;
    public $reports_count;
    public $unreviewed_reports_count;
    public $resourcetype;
    public $reporter;
    public $athummans;
    public $at;
    public $resourcereviewed;
    // Case it's a thread
    public $thread;
    public $forum;
    public $category;
    public $threadowner;
    // Case it's a post
    public $post;
    public $postowner;
    

    public $content;

    public function __construct(Report $report)
    {
        $this->report = $report;
        
        /**
         * Here we get count of reports as well as the sum of reviewed column so that we can know how many reports
         * this resource has using COUNT(*) as well as the sum of reviewed column which means all reports are reviewed
         * when sum of reviewed columns equals to count (1 when reviewed)
         */
        $resourcereports = Report::where('reportable_id', $report->reportable_id)->where('reportable_type', $report->reportable_type);
        
        $reportcounts = \DB::table('reports')
            ->selectRaw('COUNT(*) as count, SUM(reviewed) as reviewcount')
            ->where('reportable_id', $report->reportable_id)
            ->where('reportable_type', $report->reportable_type)
            ->first();

        $this->reports_count = $reportcounts->count;
        $this->unreviewed_reports_count = $reportcounts->count - $reportcounts->reviewcount;
        $this->reportbody = $report->body;
        $this->reporter = User::withoutGlobalScopes()->find($report->reporter);
        $this->athummans = (new Carbon($report->created_at))->diffForHumans();
        $this->at = (new Carbon($report->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
        $this->resourcereviewed = $reportcounts->reviewcount == $reportcounts->count;

        if($report->reportable_type == 'App\Models\Thread') {
            $this->rowid = 'threadreport'.$report->reportable_id;
            $this->rowbackground = '#f3fcff78';

            $this->resourcetype = 'thread';
            $thread = Thread::withoutGlobalScopes()->without('status', 'visibility', 'user')->find($report->reportable_id);
            $threadowner = $thread->user()->withoutGlobalScopes()->first();

            $this->thread = $thread;
            $this->threadowner = $threadowner;
            $this->category = $thread->category;
            $this->forum = $this->category->forum;
        } else if($report->reportable_type == 'App\Models\Post') {
            $this->rowid = 'postreport'.$report->reportable_id;
            $this->rowbackground = '#effff47a';

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
    public function render()
    {
        return view('components.admin.report.resource-report-manage');
    }
}
