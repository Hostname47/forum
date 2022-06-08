<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use App\Models\{Warning, Thread, Post, Report};

class WarningComponent extends Component
{
    public $warning;
    public $warning_resource;
    public $warning_resource_type;
    // Case warning on report (e.g. random reports)
    public $report;
    public $reportedresource;
    public $reportedresourcetype;

    // case resource is avatar
    public $avatarpath;
    // case resource is cover
    public $coverpath;

    public $is_admin;
    public $can_clear_warning;
    
    public function __construct(Warning $warning, $admin=false, $canclearwarning=false)
    {
        $this->warning = $warning;
        $warning_resource_type = $warning->resource_type;
        if($warning_resource_type == 'App\Models\Thread') {
            $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($warning->resource_id);
            if(is_null($thread)) {
                $warning_resource_type = 'resource-not-available';
                goto a;
            }
            /**
             * In this case we only pass warning->resource_id and $warning_resource_type that are
             * neccessary to get the thread only when user click on warned thread button (get simple resource render)
             */
        } else if($warning_resource_type == 'App\Models\Post') {
            $post = Post::withoutGlobalScopes()->setEagerLoads([])->find($warning->resource_id);
            if(is_null($post)) {
                $warning_resource_type = 'resource-not-available';
                goto a;
            }
            $this->warning_resource = $post;
        } else if($warning_resource_type == 'App\Models\Report') {
            $report = Report::find($warning->resource_id);
            if(is_null($report)) {
                $warning_resource_type = 'resource-not-available';
                goto a;
            }
            $this->report = $report;
            $reportedresource;
            if($report->reportable_type == 'App\Models\Thread')
                $reportedresource = Thread::withoutGlobalScopes()->setEagerLoads([])->find($report->reportable_id);
            else if($report->reportable_type == 'App\Models\Post')
                $reportedresource = Post::withoutGlobalScopes()->setEagerLoads([])->find($report->reportable_id);

            if(is_null($reportedresource)) {
                $warning_resource_type = 'resource-not-available';
                goto a;
            }
            $this->reportedresource = $reportedresource;
            
        } else if($warning_resource_type == 'User\Avatar') {
            $avatarname = json_decode($warning->rawcontent)->avatar;
            $this->avatarpath = asset('users/' . $warning->user_id . '/usermedia/avatars/trash/' . $avatarname);
        } else if($warning_resource_type == 'User\Cover') {
            $covername = json_decode($warning->rawcontent)->cover;
            $this->coverpath = asset('users/' . $warning->user_id . '/usermedia/covers/trash/' . $covername);
        }
        a:
        $this->warning_resource_type = $warning_resource_type;
        $this->is_admin = $admin;
        $this->can_clear_warning = $canclearwarning;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.warning-component', $data);
    }
}
