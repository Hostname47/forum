<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use App\Models\{Strike, Thread, Post, Report};

class StrikeComponent extends Component
{
    public $strike;
    public $strike_resource;
    public $strike_resource_type;
    // Case strike on report (e.g. random reports)
    public $report;
    public $reportedresource;
    public $reportedresourcetype;

    // case resource is avatar
    public $avatarpath;
    // case resource is cover
    public $coverpath;

    public $is_admin;
    public $can_clear_strike;

    public function __construct(Strike $strike, $admin=false, $canclearstrike=false)
    {
        $this->strike = $strike;
        $strike_resource_type = $strike->resource_type;
        if($strike_resource_type == 'App\Models\Thread') {
            $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($strike->resource_id);
            if(is_null($thread)) {
                $strike_resource_type = 'resource-not-available';
                goto a;
            }
            /**
             * In this case we only pass strike->resource_id and $strike_resource_type that are
             * neccessary to get the thread only when user click on striked thread button (get simple resource render)
             */
        } else if($strike_resource_type == 'App\Models\Post') {
            $post = Post::withoutGlobalScopes()->setEagerLoads([])->find($strike->resource_id);
            if(is_null($post)) {
                $strike_resource_type = 'resource-not-available';
                goto a;
            }
            $this->strike_resource = $post;
        } else if($strike_resource_type == 'App\Models\Report') {
            $report = Report::find($strike->resource_id);
            if(is_null($report)) {
                $strike_resource_type = 'resource-not-available';
                goto a;
            }
            $this->report = $report;
            $reportedresource;
            if($report->reportable_type == 'App\Models\Thread')
                $reportedresource = Thread::withoutGlobalScopes()->setEagerLoads([])->find($report->reportable_id);
            else if($report->reportable_type == 'App\Models\Post')
                $reportedresource = Post::withoutGlobalScopes()->setEagerLoads([])->find($report->reportable_id);

            if(is_null($reportedresource)) {
                $strike_resource_type = 'resource-not-available';
                goto a;
            }
            $this->reportedresource = $reportedresource;
            
        } else if($strike_resource_type == 'User\Avatar') {
            $avatarname = json_decode($strike->rawcontent)->avatar;
            $this->avatarpath = asset('users/' . $strike->user_id . '/usermedia/avatars/trash/' . $avatarname);
        } else if($strike_resource_type == 'User\Cover') {
            $covername = json_decode($strike->rawcontent)->cover;
            $this->coverpath = asset('users/' . $strike->user_id . '/usermedia/covers/trash/' . $covername);
        }
        a:
        $this->strike_resource_type = $strike_resource_type;
        $this->is_admin = $admin;
        $this->can_clear_strike = $canclearstrike;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.strike-component', $data);
    }
}
