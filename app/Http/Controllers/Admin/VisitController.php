<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\View\Components\Admin\User\Visitor;
use App\Models\User;
use App\View\Components\Admin\Viewers\VisitorsViewer;
use Carbon\Carbon;

class VisitController extends Controller
{
    public function fetch_more_visits(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric',
            'filter'=>['required', Rule::in(['today', 'lastweek', 'lastmonth'])]
        ]);

        $visits = collect([]);
        switch($data['filter']) {
            case 'today':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE DATE(created_at) = '" . date('Y-m-d') . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11 OFFSET " . $data['skip']);
                break;
            case 'lastweek':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(7) . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11 OFFSET " . $data['skip']);
                break;
            case 'lastmonth':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(30) . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11 OFFSET " . $data['skip']);
                break;
        }
        

        return [
            'visits'=>array_slice($visits, 0, 10),
            'hasmore'=>count($visits) > 10
        ];
    }

    public function get_filtered_visits(Request $request) {
        $data = $request->validate([
            'filter'=>['required', Rule::in(['today', 'lastweek', 'lastmonth'])]
        ]);

        $visits = [];
        $hasmore = false;
        switch($data['filter']) {
            case 'today':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE DATE(created_at) = '" . date('Y-m-d') . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11");
                break;
            case 'lastweek':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(7) . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11");
                break;
            case 'lastmonth':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(30) . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11");
                break;
        }

        return [
            'visits'=>array_slice($visits, 0, 10),
            'hasmore'=>count($visits) > 10
        ];
    }

    public function get_user_filtered_visits(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'filter'=>['required', Rule::in(['today', 'lastweek', 'lastmonth'])]
        ]);

        $visits = [];
        $hasmore = false;
        switch($data['filter']) {
            case 'today':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE DATE(created_at) = '" . date('Y-m-d') . "' AND visitor_id=" . $data['user_id'] 
                    . " GROUP BY `url` ORDER BY hits DESC LIMIT 11");
                break;
            case 'lastweek':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(7) . "' AND visitor_id=" . $data['user_id'] 
                    . " GROUP BY `url` ORDER BY hits DESC LIMIT 11");
                break;
            case 'lastmonth':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(30) . "' AND visitor_id=" . $data['user_id'] 
                    . " GROUP BY `url` ORDER BY hits DESC LIMIT 11");
                break;
        }

        return [
            'visits'=>array_slice($visits, 0, 10),
            'hasmore'=>count($visits) > 10
        ];
    }

    public function fetch_more_user_review_visits(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'filter'=>['required', Rule::in(['today','lastweek','lastmonth'])],
            'skip'=>'required|numeric'
        ]);

        switch($data['filter']) {
            case 'today':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE DATE(created_at) = '" . date('Y-m-d') . "' AND visitor_id=" . $data['user_id'] . " GROUP BY `url` ORDER BY hits DESC LIMIT 11 OFFSET " . $data['skip']);
                break;
            case 'lastweek':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(7) . "' AND visitor_id=" . $data['user_id'] . " GROUP BY `url` ORDER BY hits DESC LIMIT 11 OFFSET " . $data['skip']);
                break;
            case 'lastmonth':
                $visits = DB::select(
                    "SELECT `url`, SUM(hits) as hits FROM `visits` 
                    WHERE created_at > '" . Carbon::now()->subDays(30) . "' AND visitor_id=" . $data['user_id'] . " GROUP BY `url` ORDER BY hits DESC LIMIT 11 OFFSET " . $data['skip']);
                break;
        }

        return [
            'visits'=>array_slice($visits, 0, 10),
            'hasmore'=>count($visits) > 10
        ];
    }

    public function fetch_more_visitors(Request $request) {
        $data = $request->validate([
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $visits = DB::table('visits')
            ->select(DB::raw("ANY_VALUE(visitor_id) as visitor_id, ANY_VALUE(visitor_ip) as visitor_ip, MAX(created_at) as created_at"))
            ->groupByRaw("visitor_ip")
            ->orderBy('created_at', 'desc')
            ->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $visits->count() > $data['take'];
        $visits = $visits->take($data['take']);
        
        $visitors = $visits->map(function($visit) {
            return [
                'visitor'=>User::withoutGlobalScopes()->find($visit->visitor_id),
                'visitor_ip'=>$visit->visitor_ip,
                'last_visit'=>$visit->created_at
            ];
        });
        $payload = '';
        foreach($visitors as $visitor) {
            $visitor = (new Visitor($visitor));
            $visitor = $visitor->render(get_object_vars($visitor))->render();
            $payload .= $visitor;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$visitors->count(),
        ];
    }

    public function get_visitors_viewer() {
        $viewer = new VisitorsViewer();
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }
}
