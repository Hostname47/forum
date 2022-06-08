<?php

namespace App\View\Components\Activities;

use Illuminate\View\Component;
use App\Models\{Thread, User};
use Carbon\Carbon;

class ActivityThread extends Component
{
    public $activity_user;
    public $thread;
    public $status;
    public $is_ticked;
    public $forum;
    public $category;
    public $edit_link;
    
    public $actiontype;
    public $action_at;
    public $action_at_hummans;

    public $votevalue;
    public $upvoted = false;
    public $downvoted = false;

    public $liked;
    public $likescount;
    
    public $postscount;

    public function __construct(Thread $thread, User $user, $actiontype)
    {
        $this->thread = $thread;
        $this->activity_user = $user;
        $this->edit_link = route('thread.edit', ['user'=>$thread->user->username, 'thread'=>$thread->id]);
        $this->is_ticked = $thread->isticked();
        $this->forum = $thread->category->forum;
        $this->category = $thread->category;
        $this->status = $thread->status;

        $votemanager = $thread->votedandvotescount;
        if($votemanager['voted'])
            if($votemanager['uservote'] == 1)
                $this->upvoted = true;
            else
                $this->downvoted = true;
        $this->votevalue = $votemanager['votevalue'];

        $likemanager = $thread->likedandlikescount;
        $this->liked = $likemanager['liked'];
        $this->likescount = $likemanager['count'];

        $this->postscount = $thread->posts()->withoutGlobalScopes()->count();

        $actiondate = $thread->created_at;
        switch($actiontype) {
            case 'thread-posted':
                $this->actiontype = __('Posted');
                break;
            case 'thread-saved':
                $this->actiontype = __('Post saved');
                $actiondate = $thread->pivot->created_at;
                break;
            case 'thread-liked':
                $this->actiontype = __('Post liked');
                $actiondate = $thread->pivot->created_at;
                break;
            case 'thread-replied':
                $this->actiontype = __('Post replied');
                $actiondate = $thread->pivot->created_at;
                break;
            case 'thread-voted':
                $this->actiontype = __('Post voted');
                $actiondate = $thread->pivot->created_at;
                break;
            case 'thread-archived':
                $this->actiontype = __('Post archived');
                $actiondate = $thread->deleted_at;
                break;
        }

        $this->action_at = (new Carbon($actiondate))->isoFormat("dddd D MMM YYYY - H:M A");
        $this->action_at_hummans = (new Carbon($actiondate))->diffForHumans();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.activity-thread', $data);
    }
}
