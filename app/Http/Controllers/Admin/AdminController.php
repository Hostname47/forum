<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{User, Forum, ForumStatus, Category, CategoryStatus, Thread, Post, Visit, ContactMessage, Authorizationbreak};
use Carbon\Carbon;
use App\View\Components\Admin\Viewers\AuthbreaksViewer;
use App\View\Components\Admin\User\AuthorizationbreakComponent;

class AdminController extends Controller
{
    public function dashboard() {
        /**
         * In order to get online users, we get all cache records who have not expired by checking expiration field
         * We are updating the user last activity every 2 minutes by updating the cache record.
         * So to get the online users we get the count of records who have expiration > current time 
         */
        $online_users = DB::select("SELECT COUNT(*) as onlineusers FROM cache WHERE `key` LIKE 'gladiator_cacheuser-is-online-%' AND expiration > " . time())[0]->onlineusers;
        $today_visitors = DB::select("SELECT COUNT(*) as todayvisitors FROM (SELECT COUNT(*) as tv FROM visits WHERE DATE(created_at) = '" . date('Y-m-d') . "' GROUP BY visitor_ip) as B")[0]->todayvisitors;
        $today_signups = DB::select('SELECT COUNT(*) as total FROM users WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        
        $todaythreads = DB::select('SELECT COUNT(*) as total FROM threads WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todayposts = DB::select('SELECT COUNT(*) as total FROM posts WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todayvotes = DB::select('SELECT COUNT(*) as total FROM votes WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todaylikes = DB::select('SELECT COUNT(*) as total FROM likes WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todayfeedbacks = DB::select('SELECT COUNT(*) as total FROM feedbacks WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todaycmessages = DB::select('SELECT COUNT(*) as total FROM contact_messages WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todayreports = DB::select('SELECT COUNT(*) as total FROM reports WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
        $todayunauthoritylogs = DB::select('SELECT COUNT(*) as total FROM authorizationbreaks WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;

        $cmperiteration = 8;
        $contactmessages = ContactMessage::where('read', 0)->with('owner')->orderBy('created_at', 'desc')->take($cmperiteration+1)->get();
        $cmhasmore = false;
        if($contactmessages->count() > $cmperiteration) $cmhasmore = true;
        $contactmessages = $contactmessages->take($cmperiteration);
        $unreadmessages = DB::select("SELECT COUNT(*) as unreadmessages FROM contact_messages WHERE `read` = 0")[0]->unreadmessages;

        // Visits
        $visits = DB::select(
            "SELECT `url`, SUM(hits) as hits FROM `visits` 
            WHERE DATE(created_at) = '" . date('Y-m-d') . "' GROUP BY `url` ORDER BY hits DESC LIMIT 11");
        $visits_hasmore = count($visits) > 10;
        $visits = array_slice($visits, 0, 10);

        $emojis = DB::select('SELECT emoji_feedback, COUNT(*) as count FROM emoji_feedback WHERE DATE(created_at) = \''. date('Y-m-d').'\' GROUP BY emoji_feedback');
        $emojisresult = [
            'sad' => 0,
            'sceptic' => 0,
            'so-so' => 0,
            'happy' => 0,
            'veryhappy' => 0,
        ];
        foreach($emojis as $emoji) {
            $emojisresult[$emoji->emoji_feedback] = $emoji->count;
        }

        return view('admin.dashboard')
        ->with(compact('today_signups'))
        ->with(compact('today_visitors'))
        ->with(compact('todaythreads'))
        ->with(compact('todayposts'))
        ->with(compact('todayvotes'))
        ->with(compact('todaylikes'))
        ->with(compact('todayfeedbacks'))
        ->with(compact('todaycmessages'))
        ->with(compact('todayreports'))
        ->with(compact('todayunauthoritylogs'))
        ->with(compact('emojisresult'))
        ->with(compact('unreadmessages'))
        ->with(compact('cmhasmore'))
        ->with(compact('contactmessages'))
        ->with(compact('visits'))
        ->with(compact('visits_hasmore'))
        ->with(compact('online_users'));
    }

    public function get_dashboard_statistics(Request $request) {
        $data = $request->validate([
            'filter'=>['required', Rule::in(['today', 'lastweek', 'lastmonth'])]
        ]);

        $filter = $data['filter'];
        $statistics = [];

        switch($filter) {
            case 'today':
                $statistics['visitors'] = DB::select("SELECT COUNT(*) as todayvisitors FROM (SELECT COUNT(*) as tv FROM visits WHERE DATE(created_at) = '" . date('Y-m-d') . "' GROUP BY visitor_ip) as B")[0]->todayvisitors;
                $statistics['signups'] = DB::select('SELECT COUNT(*) as total FROM users WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['threads'] = DB::select('SELECT COUNT(*) as total FROM threads WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['posts'] = DB::select('SELECT COUNT(*) as total FROM posts WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['votes'] = DB::select('SELECT COUNT(*) as total FROM votes WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['likes'] = DB::select('SELECT COUNT(*) as total FROM likes WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;

                $emojis = DB::select('SELECT emoji_feedback, COUNT(*) as count FROM emoji_feedback WHERE DATE(created_at) = \''. date('Y-m-d').'\' GROUP BY emoji_feedback');
                $statistics['emojifeedbacks'] = [
                    'sad' => 0,
                    'sceptic' => 0,
                    'soso' => 0,
                    'happy' => 0,
                    'veryhappy' => 0,
                ];
                foreach($emojis as $emoji)
                    $statistics['emojifeedbacks'][$emoji->emoji_feedback] = $emoji->count;

                $statistics['feedbackmessages'] = DB::select('SELECT COUNT(*) as total FROM feedbacks WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['contactmessages'] = DB::select('SELECT COUNT(*) as total FROM contact_messages WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['reports'] = DB::select('SELECT COUNT(*) as total FROM reports WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                $statistics['authbreaks'] = DB::select('SELECT COUNT(*) as total FROM authorizationbreaks WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total;
                break;
            case 'lastweek':
                $statistics['visitors'] = DB::select('SELECT COUNT(*) as weekcount FROM (SELECT COUNT(*) FROM visits WHERE created_at > \'' . Carbon::now()->subDays(7) . '\' GROUP BY visitor_ip) as B')[0]->weekcount;
                $statistics['signups'] = DB::select('SELECT COUNT(*) as weekcount FROM users WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->weekcount;
                $statistics['threads'] = DB::select('SELECT COUNT(*) as weekcount FROM threads WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->weekcount;
                $statistics['posts'] = DB::select('SELECT COUNT(*) as weekcount FROM posts WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->weekcount;
                $statistics['votes'] = DB::select('SELECT COUNT(*) as weekcount FROM votes WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->weekcount;
                $statistics['likes'] = DB::select('SELECT COUNT(*) as weekcount FROM likes WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->weekcount;

                $emojis = DB::select('SELECT emoji_feedback, COUNT(*) as count FROM emoji_feedback WHERE created_at > \'' . Carbon::now()->subDays(7) . '\' GROUP BY emoji_feedback');
                $statistics['emojifeedbacks'] = [
                    'sad' => 0,
                    'sceptic' => 0,
                    'soso' => 0,
                    'happy' => 0,
                    'veryhappy' => 0,
                ];
                foreach($emojis as $emoji)
                    $statistics['emojifeedbacks'][$emoji->emoji_feedback] = $emoji->count;

                $statistics['feedbackmessages'] = DB::select('SELECT COUNT(*) as total FROM feedbacks WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->total;
                $statistics['contactmessages'] = DB::select('SELECT COUNT(*) as total FROM contact_messages WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->total;
                $statistics['reports'] = DB::select('SELECT COUNT(*) as total FROM reports WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->total;
                $statistics['authbreaks'] = DB::select('SELECT COUNT(*) as total FROM authorizationbreaks WHERE created_at > \'' . Carbon::now()->subDays(7) . '\'')[0]->total;
                break;
            case 'lastmonth':
                $statistics['visitors'] = DB::select('SELECT COUNT(*) as weekcount FROM (SELECT COUNT(*) FROM visits WHERE created_at > \'' . Carbon::now()->subDays(30) . '\' GROUP BY visitor_ip) as B')[0]->weekcount;
                $statistics['signups'] = DB::select('SELECT COUNT(*) as weekcount FROM users WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->weekcount;
                $statistics['threads'] = DB::select('SELECT COUNT(*) as weekcount FROM threads WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->weekcount;
                $statistics['posts'] = DB::select('SELECT COUNT(*) as weekcount FROM posts WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->weekcount;
                $statistics['votes'] = DB::select('SELECT COUNT(*) as weekcount FROM votes WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->weekcount;
                $statistics['likes'] = DB::select('SELECT COUNT(*) as weekcount FROM likes WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->weekcount;

                $emojis = DB::select('SELECT emoji_feedback, COUNT(*) as count FROM emoji_feedback WHERE created_at > \'' . Carbon::now()->subDays(30) . '\' GROUP BY emoji_feedback');
                $statistics['emojifeedbacks'] = [
                    'sad' => 0,
                    'sceptic' => 0,
                    'soso' => 0,
                    'happy' => 0,
                    'veryhappy' => 0,
                ];
                foreach($emojis as $emoji)
                    $statistics['emojifeedbacks'][$emoji->emoji_feedback] = $emoji->count;

                $statistics['feedbackmessages'] = DB::select('SELECT COUNT(*) as total FROM feedbacks WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->total;
                $statistics['contactmessages'] = DB::select('SELECT COUNT(*) as total FROM contact_messages WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->total;
                $statistics['reports'] = DB::select('SELECT COUNT(*) as total FROM reports WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->total;
                $statistics['authbreaks'] = DB::select('SELECT COUNT(*) as total FROM authorizationbreaks WHERE created_at > \'' . Carbon::now()->subDays(30) . '\'')[0]->total;
                break;
        }

        return $statistics;
    }
    
    public function archives() {
        $archivedforums = Forum::withoutGlobalScopes()->with(['creator', 'approver'])->where('status_id', ForumStatus::where('slug', 'archived')->first()->id)->get();
        $archivedcategories = Category::withoutGlobalScopes()->with(['creator', 'approver'])->where('status_id', CategoryStatus::where('slug', 'archived')->first()->id)->get();

        return view('admin.archives')
        ->with(compact('archivedforums'))
        ->with(compact('archivedcategories'))
        ;
    }

    public function get_athbreaks_viewer() {
        $viewer = new AuthbreaksViewer();
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function fetch_more_authbreaks(Request $request) {
        $data = $request->validate([
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        
        $authbreaks = Authorizationbreak::with(['user', 'breaktype'])->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $authbreaks->count() > $data['take'];
        $authbreaks = $authbreaks->take($data['take']);
        
        $payload = '';
        foreach($authbreaks as $authbreak) {
            $viewer = (new AuthorizationbreakComponent($authbreak, true));
            $viewer = $viewer->render(get_object_vars($viewer))->render();
            $payload .= $viewer;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$authbreaks->count(), // used to handle last count authbreaks events (front-end)
        ];
    }

    public function checkpath(Request $request) {
        $path = $request->validate(['path'=>'required|min:1|max:400'])['path'];

        clearstatcache(); // Clear cache
        $exists = is_dir(base_path($path)) ? 'dir' : (is_file(base_path($path)) ? 'file' : 0);

        return [
            'exists'=>(bool)$exists,
            'type'=>$exists
        ];
    }
}
