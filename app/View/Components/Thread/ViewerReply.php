<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\Post;

class ViewerReply extends Component
{
    public $post;
    public $owner;
    public $threadownerid;
    public $at;
    public $at_hummans;
    public $likescount;
    public $liked;
    public $votevalue;
    public $upvoted;
    public $downvoted;
    
    public function __construct(Post $post, $data=[])
    {
        $this->post = $post;
        $this->owner = $post->user;
        $this->threadownerid = isset($data['thread-owner-id']) 
            ? $data['thread-owner-id'] 
            : \DB::select("SELECT user_id as userid FROM threads where id=$post->thread_id")[0]->userid;
        $this->at = (new Carbon($post->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
        $this->at_hummans = (new Carbon($post->created_at))->diffForHumans();

        $likemanager = $post->likedandlikescount;
        $this->likescount = $likemanager['count'];
        $this->liked = $likemanager['liked'];

        $votemanager = $post->votedandvotescount;
        $this->votevalue = $votemanager['votevalue'];
        if($votemanager['voted'])
            if($votemanager['votevalue'] == 1)
                $this->upvoted = true;
            else
                $this->downvoted = true;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.viewer-reply', $data);
    }
}
