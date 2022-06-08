<?php

namespace App\View\Components\Admin\Report;

use Illuminate\View\Component;
use App\Models\{Thread, Report, User};
use App\Scopes\{ExcludeAnnouncements,FollowersOnlyScope};

class ReportFetchMore extends Component
{
    public $report;
    public $reporter;
    public $athummans;
    public $at;

    public function __construct(Report $report)
    {
        $this->reporter = User::withoutGlobalScopes()->find($report->reporter);
        $this->report = $report;

        $this->athummans = (new \Carbon\Carbon($report->created_at))->diffForHumans();
        $this->at = (new \Carbon\Carbon($report->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.report.report-fetch-more', $data);
    }
}
