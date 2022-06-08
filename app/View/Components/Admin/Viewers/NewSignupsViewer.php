<?php

namespace App\View\Components\Admin\Viewers;

use Illuminate\View\Component;
use App\Models\{Visit, User};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewSignupsViewer extends Component
{
    public $users;
    public $hasmore;
    public $totalcount;
    public $todaycount;
    public $thisweekcount;
    public $thismonthcount;

    public function __construct()
    {
        $totalcount = DB::select("SELECT COUNT(*) as totalcount FROM users")[0]->totalcount;
        $this->todaycount = DB::select("SELECT COUNT(*) as todaycount FROM  users WHERE DATE(created_at) = '" . date('Y-m-d') . "'")[0]->todaycount;
        $this->thisweekcount = DB::select('SELECT COUNT(*) as thisweekcount FROM users WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->thisweekcount;
        $this->thismonthcount = DB::select('SELECT COUNT(*) as thismonthcount FROM users WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->thismonthcount;
        $this->totalcount = $totalcount;

        $this->users = User::withoutGlobalScopes()->orderBy('created_at', 'desc')->take(10)->get();
        $this->hasmore = $totalcount > 10;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.viewers.new-signups-viewer', $data);
    }
}
