<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Forum, Thread, Category, User};
use App\View\Components\IndexResource;
use Carbon\Carbon;

class ThreadComponentsFetchController extends Controller
{
    const PAGESIZE = 8;
    const FETCH_PAGESIZE = 8;

    public function forum_threads_load_more(Request $request, Forum $forum) {
        $indexes = $request->validate([
            'skip'=>'required|numeric|max:600',
            'tab'=>[
                'required',
                Rule::in(['all', 'today', 'thisweek']),
            ]
        ]);
        $categories = Category::excludeannouncements()->where('forum_id', $forum->id)->get()->pluck('id');
        $threads = Thread::without(['category.forum'])->whereIn('category_id', $categories);
        
        switch($indexes['tab']) {
            case 'all':
                $threads = $threads->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
            case 'today':
                $threads = $threads->today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
            case 'thisweek':
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')
                ->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
        }

        $has_more = false;
        if($threads->count() > self::FETCH_PAGESIZE) {
            $threads->pop();
            $has_more = 1;
        } else
            $has_more = 0;

        $payload = "";
        foreach($threads as $thread) {
            $thread_component = (new IndexResource($thread));
            $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
            $payload .= $thread_component;
        }

        return [
            "content"=>$payload,
            'count'=>$threads->count(),
            'hasmore'=>$has_more
        ];
    }
    public function category_threads_load_more(Request $request, Forum $forum, Category $category) {
        $indexes = $request->validate([
            'skip'=>'required|numeric|max:600',
            'tab'=>[
                'required',
                Rule::in(['all', 'today', 'thisweek']),
            ]
        ]);

        $threads = Thread::where('category_id', $category->id);
        switch($indexes['tab']) {
            case 'all':
                $threads = $threads->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
            case 'today':
                $threads = $threads->today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
            case 'thisweek':
                $threads = $threads->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')
                ->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
        }

        $has_more = 0;
        if($threads->count() > self::FETCH_PAGESIZE) {
            $threads->pop();
            $has_more = 1;
        }

        $payload = "";
        foreach($threads as $thread) {
            $thread_component = (new IndexResource($thread));
            $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
            $payload .= $thread_component;
        }

        return [
            "content"=>$payload,
            'count'=>$threads->count(),
            'hasmore'=>$has_more
        ];
    }
    public function index_load_more(Request $request) {
        $indexes = $request->validate([
            'skip'=>'required|numeric|max:600',
            'tab'=>[
                'required',
                Rule::in(['all', 'today', 'thisweek']),
            ]
        ]);
        
        switch($indexes['tab']) {
            case 'all':
                $threads = Thread::without(['posts', 'votes', 'likes'])->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
            case 'today':
                $threads = Thread::without(['posts', 'votes', 'likes'])->today()->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
            case 'thisweek':
                $threads = Thread::without(['posts', 'votes', 'likes'])->where(
                    'created_at', 
                    '>=', 
                    \Carbon\Carbon::now()->subDays(7)->setTime(0, 0)
                )->orderBy('view_count', 'desc')->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
                break;
        }

        $hasmore = false;
        if($threads->count() > self::FETCH_PAGESIZE) {
            $hasmore = true;
            $threads = $threads->take(self::FETCH_PAGESIZE);
        }

        $payload = "";
        foreach($threads as $thread) {
            $thread_component = (new IndexResource($thread));
            $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
            $payload .= $thread_component;
        }

        return [
            "content"=>$payload,
            'count'=>$threads->count(),
            'hasmore'=>$hasmore
        ];
    }
    public function profile_threads_load_more(Request $request) {
        $indexes = $request->validate([
            'skip'=>'required|numeric|max:600',
            'user'=>'required|exists:users,id'
        ]);
        $user = User::find($indexes['user']);
        $threads = $user->threads()->without(['posts', 'votes', 'likes'])->orderBy('created_at', 'desc')->skip($indexes['skip'])->take(self::FETCH_PAGESIZE+1)->get();
        
        $hasmore = 0;
        if($threads->count() > self::FETCH_PAGESIZE) {
            $hasmore = 1;
            $threads->pop();
        }

        $payload = "";
        foreach($threads as $thread) {
            $thread_component = (new IndexResource($thread));
            $thread_component = $thread_component->render(get_object_vars($thread_component))->render();
            $payload .= $thread_component;
        }

        return [
            "content"=>$payload,
            'count'=>$threads->count(),
            'hasmore'=>$hasmore,
        ];
    }
}
