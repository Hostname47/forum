<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{Thread, UserReach};
use App\Classes\Helper;

class ViewerInfos extends Component
{
    public $thread;
    public $threadowner;
    public $content;
    public $posts;
    public $ticked = false;
    public $missed_ticked_post;
    public $edit_link;
    public $followed;
    public $posts_count;
    public $likescount;
    public $liked;
    public $votevalue;
    public $upvoted;
    public $downvoted;
    public $saved;

    public function __construct(Thread $thread, $data=[])
    {
        $thread->update(['view_count'=>$thread->view_count+1]); // Increase thread views when user open media viewer

        $threadowner = $thread->user;
        $this->thread = $thread;
        $this->threadowner = $threadowner;
        $this->content = Helper::mdparse($thread->content);
        if(auth()->user() && auth()->user()->id == $thread->user_id)
            $this->edit_link = route('thread.edit', ['user'=>$threadowner->username, 'thread'=>$thread->id]);
        $this->posts_count = $thread->posts()->count();
        $this->saved = (auth()->user()) ? auth()->user()->isthatthreadsaved($thread) : false;

        $likemanager = $thread->likedandlikescount;
        $this->likescount = $likemanager['count'];
        $this->liked = $likemanager['liked'];

        $votemanager = $thread->votedandvotescount;
        if($votemanager['voted'])
            if($votemanager['votevalue'] == 1)
                $this->upvoted = true;
            else
                $this->downvoted = true;
        $this->votevalue = $votemanager['votevalue'];

        if(auth()->user() && auth()->user()->id != $threadowner->id)
            $this->followed = (bool)$threadowner->followers()->where('follower', auth()->user()->id)->count();
        else
            $this->followed = false;

        $this->posts = $thread->posts()->with(['user'])->where('ticked', 0)->orderBy('created_at', 'desc')->take(6)->get();
        if($thread->isticked()) {
            $this->ticked = true;
            $tickedpost = $thread->tickedPost();
            if($tickedpost)
                $this->posts->prepend($tickedpost);
            else
                $this->missed_ticked_post = true;
        }

        /**
         * Handling posts reaching
         */
        $reachedposts = $this->posts->unique('user_id');
        $currentuser = auth()->user();
        if($currentuser)
            $reachedposts = $reachedposts->where('user_id', '<>', $currentuser->id);
        
        foreach($reachedposts as $post) {
            $reach = new UserReach;
            if($currentuser) $reach->reacher = $currentuser->id;
            
            $reach->reachable = $post->user_id;
            $reach->resource_id = $post->id;
            $reach->resource_type = 'App\Models\Post';
            $reach->reacher_ip = $data['ip'];

            $alreadyreached = UserReach::where('reachable', $post->user_id)
                ->where('resource_id', $post->id)
                ->where('resource_type', 'App\Models\Post')
                ->whereRaw('created_at > \'' . \Carbon\Carbon::now()->subDays(2) . '\'');
            if($currentuser)
                $alreadyreached = (bool) $alreadyreached->where('reacher', $currentuser->id)->count();
            else
                $alreadyreached = (bool) $alreadyreached->where('reacher_ip', $data['ip'])->count();

            if(!$alreadyreached)
                $reach->save();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.viewer-infos', $data);
    }
}
