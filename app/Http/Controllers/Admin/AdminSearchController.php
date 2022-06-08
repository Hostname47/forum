<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\{User, Thread, Post};

class AdminSearchController extends Controller
{
    public function users_search(Request $request) {
        $data = $request->validate([
            'k'=>'required|max:200'
        ]);
        $keyword = $data['k'];

        $result = User::withTrashed()->where('username', 'like', "%$keyword%")->select('id', 'username', 'firstname', 'lastname', 'avatar', 'provider_avatar')->take(11)->get();

        return [
            'content'=>$result->take(10),
            'hasnext'=>$result->count() > 10
        ];
    }
    
    public function thread_search(Request $request) {
        $data = $request->validate([
            'k'=>'required|max:400'
        ]);

        $keyword = $data['k'];

        $result = Thread::withoutGlobalScopes()
        ->where('id', $keyword)
        ->orWhere('subject', 'LIKE', "%$keyword%")
        ->select('id', 'subject', 'content')->take(11)->get();

        return [
            'content'=>$result->take(10),
            'hasnext'=>$result->count() > 10,
        ];
    }

    public function thread_search_fetch_more(Request $request) {
        $keyword = $request->k;
        $skip = $request->skip;

        $result = Thread::withoutGlobalScopes()
        ->where('id', $keyword)
        ->orWhere('subject', 'LIKE', "%$keyword%")
        ->skip($skip)->take(11)
        ->select('id', 'subject', 'content')->get();

        return [
            'content'=>$result->take(10),
            'hasnext'=>$result->count() > 10,
        ];
    }

    public function user_search_fetch_more(Request $request) {
        $keyword = $request->k;
        $skip = $request->skip;

        $result = User::withoutGlobalScopes()
        ->where('username', 'like', "%$keyword%")
        ->skip($skip)->take(11)
        ->select('id', 'username', 'firstname', 'lastname', 'avatar', 'provider_avatar')->get();

        return [
            'content'=>$result->take(10),
            'hasnext'=>$result->count() > 10,
        ];
    }

    public function post_search(Request $request) {
        $postid = $request->k;

        $post = Post::withoutGlobalScopes()->find($postid);
        if($post)
            return [
                'id'=>$post->id,
                'content'=>$post->mediumcontentslice
            ];

        return null;
    }
}
