<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Post};
use Carbon\Carbon;
use Markdown;

class PostComponent extends Component
{
    public $post;
    public $owner; // Post owner
    public $thread_owner;
    public $votes;
    public $post_content;
    public $canbeticked;

    public $likescount;
    public $liked;
    public $votevalue;
    public $upvoted;
    public $downvoted;

    public $already_reported;
    public $post_created_at;
    public $post_date;

    // public function __construct(Post $post, $threadownerid, $canbeticked=false)
    public function __construct(Post $post, $data=[])
    {
        $this->post = $post;
        $this->owner = isset($data['postowner']) ? $data['postowner'] : $post->user;
        $this->post_content = Markdown::parse($post->content);
        $this->post_created_at = (new Carbon($post->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
        $this->post_date = (new Carbon($post->created_at))->diffForHumans();
        $this->thread_owner = isset($data['thread-owner-id']) ? $data['thread-owner-id'] : \DB::select("SELECT user_id FROM threads WHERE id = $post->thread_id")[0]->user_id;
        $this->canbeticked = isset($data['can-be-ticked']) 
            ? $data['can-be-ticked'] 
            : \DB::select("SELECT COUNT(*) as ticked FROM posts WHERE thread_id = $post->thread_id AND ticked=1")[0]->ticked == 0;
        $this->already_reported = ($post->already_reported) ? 1 : 0;

        $likemanager = $post->likedandlikescount;
        $this->likescount = $likemanager['count'];
        $this->liked = $likemanager['liked'];

        $votemanager = $post->votedandvotescount;
        if($votemanager['voted'])
            if($votemanager['uservote'] == 1)
                $this->upvoted = true;
            else
                $this->downvoted = true;

        $this->votevalue = $votemanager['votevalue'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.post.post-component', $data);
    }
}
