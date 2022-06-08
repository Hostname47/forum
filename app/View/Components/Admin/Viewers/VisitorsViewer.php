<?php

namespace App\View\Components\Admin\Viewers;

use Illuminate\View\Component;
use App\Models\{Visit, User};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitorsViewer extends Component
{
    public $visitors;
    public $hasmore;
    public $todaycount;
    public $thisweekcount;
    public $thismonthcount;

    public function __construct()
    {
        $totalcount = DB::select("SELECT COUNT(*) as totalcount FROM visits GROUP BY visitor_ip")[0]->totalcount;
        $this->todaycount = DB::select("SELECT COUNT(*) as todayvisitors FROM (SELECT COUNT(*) as tv FROM visits WHERE DATE(created_at) = '" . date('Y-m-d') . "' GROUP BY visitor_ip) as B")[0]->todayvisitors;
        $this->thisweekcount = DB::select('SELECT COUNT(*) as weekcount FROM (SELECT COUNT(*) FROM visits WHERE created_at > \'' . Carbon::now()->subDays(7) . '\' GROUP BY visitor_ip) as B')[0]->weekcount;
        $this->thismonthcount = DB::select('SELECT COUNT(*) as monthcount FROM (SELECT COUNT(*) FROM visits WHERE created_at > \'' . Carbon::now()->subDays(30) . '\' GROUP BY visitor_ip) as B')[0]->monthcount;

        $visitors = DB::table('visits')
            ->select(DB::raw("ANY_VALUE(visitor_id) as visitor_id, ANY_VALUE(visitor_ip) as visitor_ip, MAX(created_at) as created_at"))
            ->groupByRaw("visitor_ip")
            ->orderBy('created_at', 'desc')
            ->take(10)->get();

        $this->visitors = $visitors->map(function($visit) {
            return [
                'visitor'=>User::withoutGlobalScopes()->find($visit->visitor_id),
                'visitor_ip'=>$visit->visitor_ip,
                'last_visit'=>$visit->created_at
            ];
        });

        $this->hasmore = $totalcount > 10;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.viewers.visitors-viewer', $data);
    }
}
