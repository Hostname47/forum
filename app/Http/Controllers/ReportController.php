<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Post, Report, CloseReason, WarningReason, StrikeReason, User};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\View\Components\IndexResource;
use App\View\Components\Admin\Report\{ReportFetchMore, ReportBodyViewer};

class ReportController extends Controller
{
    public function thread_report(Request $request, Thread $thread) {
        $this->authorize('thread_report', [Report::class, $thread]);
        $data = $request->validate([
            'body'=>'required_if:type,moderator-intervention|max:500|min:10',
            'type'=>['required', Rule::in(['spam', 'rude-or-abusive', 'low-quality', 'moderator-intervention'])]
        ]);
        $currentuser = auth()->user();
        
        $report = new Report;
        $report->reporter = $currentuser->id;
        $report->type = $data['type'];
        if(isset($data['body'])) $report->body = $data['body'];

        $thread->reports()->save($report);
    }

    public function post_report(Request $request, Post $post) {
        $this->authorize('post_report', [Report::class, $post]);
        $data = $request->validate([
            'body'=>'required_if:type,moderator-intervention|max:500|min:10',
            'type' => ['required', Rule::in(['spam', 'rude-or-abusive', 'not-a-reply', 'moderator-intervention'])]
        ]);
        $currentuser = auth()->user();
        
        $report = new Report;
        $report->reporter = $currentuser->id;
        $report->type = $data['type'];
        if(isset($data['body'])) $report->body = $data['body'];

        $post->reports()->save($report);
    }

    public function review_page(Request $request) {
        $rperpage = 8;
        /**
         * The following query will group reportsbased on resource_id and resource_type and extract their 
         * ids by taking the maximum id to get the latest report on distinct resources and paginate the result
         * Then we loop through the paginated results (ids) and get reports models
         */
        $reports = DB::table('reports')
            ->selectRaw('MAX(id) as latest_report_id')
            ->groupByRaw('reportable_id, reportable_type')
            ->orderBy('latest_report_id', 'desc')
            ->paginate($rperpage);

        $reports->getCollection()->transform(function($id) {
            return Report::find($id->latest_report_id);
        });

        return view('admin.reports.review')
            ->with(compact('reports'));
    }

    public function generate_resource_reports_components(Request $request, Report $report) {
        $payload = "";
        $reports = Report::where('reportable_id', $report->reportable_id)->where('reportable_type', $report->reportable_type)->orderBy('created_at', 'desc')->take(9)->get();
        $hasmore = $reports->count() > 8;
        $reports = $reports->take(8);

        foreach($reports as $r) {
            $report_component = (new ReportFetchMore($r));
            $report_component = $report_component->render(get_object_vars($report_component))->render();
            $payload .= $report_component;
        }

        return [
            'payload'=>$payload,
            'hasmore'=>$hasmore
        ];
    }

    public function fetch_more_resource_reports(Request $request) {
        $data = $request->validate([
            'report'=>'required|exists:reports,id',
            'skip'=>'required|numeric'
        ]);

        $payload = "";
        $report = Report::find($data['report']);
        $reports = Report::where('reportable_id', $report->reportable_id)->where('reportable_type', $report->reportable_type)->orderBy('created_at', 'desc')->skip($data['skip'])->take(9)->get();
        $hasmore = $reports->count() > 8;
        $reports = $reports->take(8);

        foreach($reports as $r) {
            $report_component = (new ReportFetchMore($r));
            $report_component = $report_component->render(get_object_vars($report_component))->render();
            $payload .= $report_component;
        }

        return [
            'payload'=>$payload,
            'hasmore'=>$hasmore
        ];
    }

    public function fetch_more_resource_raw_reports(Request $request) {
        $data = $request->validate([
            'report'=>'required|exists:reports,id',
            'skip'=>'required|numeric'
        ]);

        $report = Report::find($data['report']);
        $reports = Report::where('reportable_id', $report->reportable_id)->where('reportable_type', $report->reportable_type)->orderBy('created_at', 'desc')->skip($data['skip'])->take(9)->get();
        $hasmore = $reports->count() > 8;
        $reports = $reports->take(8);

        $reports = $reports->map(function($report) {
            $reporter = $report->reporteruser;
            return [
                'id'=>$report->id,
                'reporter_id'=>$reporter->id,
                'reporter_avatar'=>$reporter->sizedavatar(36, '-l'),
                'reporter_username'=>$reporter->username,
                'user_manage_link'=>route('admin.user.manage', ['user'=>$reporter->username]),
                'reported_at'=>$report->athummans,
                'report_type'=>$report->type,
                'report_body'=>$report->body,
                'reporter_already_warned_for_this_report'=>$report->reporter_already_warned_about_this_report(),
                'reporter_already_striked_for_this_report'=>$report->reporter_already_striked_about_this_report(),
            ];
        });

        return [
            'reports'=>$reports,
            'hasmore'=>$hasmore
        ];
    }

    public function get_report_bodyviewer(Request $request) {
        $data = $request->validate([
            'report'=>'required|exists:reports,id'
        ]);

        $report = Report::find($data['report']);
        $bodyviewer = (new ReportBodyViewer($report));
        $bodyviewer = $bodyviewer->render(get_object_vars($bodyviewer))->render();
    
        return $bodyviewer;
    }

    // The following 2 function views are deleted to manage resources from resource management pages and not in a dedicated pages for each resource type
    public function managepost(Request $request) {
        $post;
        $postowner;
        $closereasons;
        $warningsreasons;
        $resourcewarnings;
        $resourcestrikes;
        $report; // Report wrapper
        $reports; // Reports stored in data column of report

        $alreadywarned = [];
        $alreadystriked = [];

        if($request->has('reportid')) {
            $report = Report::find($request->get('reportid'));
            $post = Post::withoutGlobalScopes()->find($report->reportable_id);
            $postowner = $post->user;
            $resourcewarnings = $postowner->warnings()->where('resource_type', 'App\Models\Post')->where('resource_id', $post->id)->get();
            $resourcestrikes = $postowner->strikes()->where('resource_type', 'App\Models\Post')->where('resource_id', $post->id)->get();
            $warningsreasons = WarningReason::select('id', 'slug')->get();
            $strikereasons = StrikeReason::select('id', 'slug')->get();

            $reports = json_decode($report->data);
            foreach($reports as $r) {
                $reporter = User::withoutGlobalScopes()->find($r->reporter);
                $r->reporter = $reporter;

                // The checks in warnings and strikes here is for reporters that get w/s for their random or inappropriate reports
                $alreadywarned[] = $reporter->warnings()
                ->where('resource_id', $report->id)
                ->where('resource_type', 'App\Models\Report')
                ->count() > 0;

                $alreadystriked[] = $reporter->strikes()
                ->where('resource_id', $report->id)
                ->where('resource_type', 'App\Models\Report')
                ->count() > 0;
            }
        }

        return view('admin.reports.manage-reported-post')
        ->with(compact('post'))
        ->with(compact('postowner'))
        ->with(compact('warningsreasons'))
        ->with(compact('strikereasons'))
        ->with(compact('resourcewarnings'))
        ->with(compact('resourcestrikes'))
        ->with(compact('alreadywarned'))
        ->with(compact('alreadystriked'))
        ->with(compact('report'))
        ->with(compact('reports'));
    }
    public function managethread(Request $request) {
        $threadexists = false;
        $thread;
        $threadowner;
        $closereasons;
        $warningsreasons;
        $strikereasons;
        $resourcewarnings;
        $resourcestrikes;
        $report; // Report wrapper
        $reports; // Reports stored in data column of report
        $reporters;

        $alreadywarned = [];
        $alreadystriked = [];

        if($request->has('reportid')) {
            $report = Report::find($request->get('reportid'));
            $thread = Thread::withoutGlobalScopes()->find($report->reportable_id);
            $threadowner = $thread->user()->withoutGlobalScopes()->first();
            $resourcewarnings = $threadowner->warnings()->where('resource_type', 'App\Models\Thread')->where('resource_id', $thread->id)->get();
            $resourcestrikes = $threadowner->strikes()->where('resource_type', 'App\Models\Thread')->where('resource_id', $thread->id)->get();
            $closereasons = CloseReason::select('id', 'slug')->get();
            $warningsreasons = WarningReason::select('id', 'slug')->get();
            $strikereasons = StrikeReason::select('id', 'slug')->get();

            $reports = json_decode($report->data);
            foreach($reports as $r) {
                $reporter = User::withoutGlobalScopes()->find($r->reporter);
                $r->reporter = $reporter;

                // The checks in warnings and strikes here is for reporters that get w/s for their random or inappropriate reports
                $alreadywarned[] = $reporter->warnings()
                ->where('resource_id', $report->id)
                ->where('resource_type', 'App\Models\Report')
                ->count() > 0;

                $alreadystriked[] = $reporter->strikes()
                ->where('resource_id', $report->id)
                ->where('resource_type', 'App\Models\Report')
                ->count() > 0;
            }
        }

        return view('admin.reports.manage-reported-thread')
        ->with(compact('thread'))
        ->with(compact('threadowner'))
        ->with(compact('closereasons'))
        ->with(compact('warningsreasons'))
        ->with(compact('strikereasons'))
        ->with(compact('resourcewarnings'))
        ->with(compact('resourcestrikes'))
        ->with(compact('alreadywarned'))
        ->with(compact('alreadystriked'))
        ->with(compact('report'))
        ->with(compact('reports'));
    }

    public function change_resource_reports_review_status(Request $request) {
        $this->authorize('patch_resource_reports_review', [User::class]);
        $data = $request->validate([
            'report'=>'required|exists:reports,id',
            'action'=>['required', Rule::in(['review','unreview'])]
        ]);

        $report = Report::find($data['report']);
        if($data['action'] == 'review') {
            Report::where('reportable_id', $report->reportable_id)->where('reportable_type', $report->reportable_type)->update(['reviewed'=>1]);
            return 'reviewed';
        }

        // In case of unreview a resource reports, we only unreview the last report
        Report::where('reportable_id', $report->reportable_id)
            ->where('reportable_type', $report->reportable_type)
            ->first()->update(['reviewed'=> 0]);
        return 'unreviewed';
    }
}
