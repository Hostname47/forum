<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Forum, Thread};
use App\View\Components\IndexResource;
use App\Scopes\{ExcludeAnnouncements, FollowersOnlyScope};
use Carbon\Carbon;

class IndexController extends Controller
{
    const PAGESIZE = 8;
    const FETCH_PAGESIZE = 6;

    public function index(Request $request) {
        $tab_title = 'All'; // By default is all, until the user choose other option
        $tab = "all";
        $pagesize = self::PAGESIZE;

        if($request->has('tab')) {
            $tab = $request->get('tab');
            if($tab == 'today') {
                $threads = Thread::without(['user.status'])->today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->take(self::PAGESIZE+1)->get();
                $tab_title = 'Today';
            } else if($tab == 'thisweek') {
                $threads = Thread::without(['user.status'])->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->take(self::PAGESIZE)->get();
                $tab_title = 'This week';
            }
        } else {
            $threads = Thread::without(['user.status'])->orderBy('created_at', 'desc')->take(self::PAGESIZE)->get();
        }

        /**
         * Even if thread fetch more should only be displayed when more than PAGESIZE, we'll display it
         * if there are more than 6 and then If the global threads count is less than that it will be removed
         */
        $hasmore = $threads->count() > 6;


        return view('index')
        ->with(compact('hasmore'))
        ->with(compact('threads'))
        ->with(compact('tab'))
        ->with(compact('tab_title'))
        ->with(compact('pagesize'));
    }
    public function forums() {
        $forums = Forum::with('status')->orderBy('id')->take(7)->get();
        return view('forums')
            ->with(compact('forums'));
    }
    public function announcements() {
        $announcements = Thread::
            withoutGlobalScope(ExcludeAnnouncements::class)
            ->withoutGlobalScope(FollowersOnlyScope::class)
            ->whereHas('category', function($query) {
                $query->where('slug', 'announcements');
            })->orderBy('created_at', 'desc')->paginate(8);

        return view('announcements')
        ->with(compact('announcements'));
    }
    public function guidelines() {
        return view('guidelines');
    }
    public function about() {
        return view('aboutus');
    }
    public function privacy() {
        return view('privacy-policy');
    }
}
