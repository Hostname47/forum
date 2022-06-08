<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Http\Request;
use App\Models\{Forum};
use App\View\Components\ForumComponent;

class ForumController extends Controller
{
    public function fetch_more_forums(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric'
        ]);

        $forums = Forum::with('status')->orderBy('id')->skip($data['skip'])->take(8)->get();
        $hasmore = $forums->count() > 7;
        $forums = $forums->take(7);

        $payload = "";
        foreach($forums as $forum) {
            $forumcomponent = (new ForumComponent($forum));
            $forumcomponent = $forumcomponent->render(get_object_vars($forumcomponent))->render();
            $payload .= $forumcomponent;
        }

        return [
            'payload'=>$payload,
            'hasmore'=>$hasmore,
            'count'=>$forums->count()
        ];
    }
}