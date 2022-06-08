<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{Forum, Category, Thread, User};
use Markdown;

class ThreadComponent extends Component
{
    public $thread_owner;
    public $thread_owner_avatar;
    public $thread_owner_username;
    public $thread_owner_reputation;
    public $thread_owner_posts_number;
    public $thread_owner_threads_number;
    public $thread_owner_joined_at;

    public $thread;
    public $forum_slug;
    public $category_slug;

    public $thread_url;
    public $thread_edit_url;
    public $thread_votes;
    public $thread_delete_endpoint;
    public $thread_subject;
    public $thread_created_at;
    public $thread_created_at_hummans;
    public $thread_view_counter;
    public $thread_content;
    public $thread_replies_num;

    public function __construct(Thread $thread)
    {
        // Incrementing the view counter
        $thread->update([
            'view_count'=>$thread->view_count+1
        ]);

        $this->thread = $thread;
        $this->forum = $forum = Forum::find($thread->category->forum_id);
        $this->category = $category = Category::find($thread->category_id);
        $this->thread_type = $thread->thread_type;

        $vote_count = 0;
        foreach($thread->votes as $vote) {
            $vote_count += $vote->vote;
        }
        $this->thread_votes = $vote_count;

        $this->thread_delete_endpoint = route('thread.destroy', ['thread'=>$thread->id]);
        
        $this->thread_replies_num = $thread->posts->count();
        $this->thread_owner = $thread_owner = User::find($thread->user_id);
        $this->thread_owner_avatar = $thread_owner->avatar;
        $this->thread_owner_username = $thread_owner->username;
        $this->thread_owner_reputation = $thread_owner->reputation;
        $this->thread_owner_threads_number = $thread_owner->threads->count();
        $this->thread_owner_posts_number = $thread_owner->posts_count();
        $this->thread_owner_joined_at = (new Carbon($thread_owner->created_at))->toDayDateTimeString();

        $this->thread_edit_url = route('thread.edit', ['user'=>$this->thread_owner_username, 'thread'=>$thread->id]);
        $this->thread_url = route('thread.show', ['forum'=>$forum->slug, 'category'=>$category->slug,'thread'=>$thread->id]);

        $this->thread_subject = $thread->subject;
        $this->thread_created_at_hummans = (new Carbon($thread->created_at))->diffForHumans();
        $this->thread_created_at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->thread_view_counter = $thread->view_count;
        $this->thread_content = strip_tags(Markdown::parse($thread->content));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.thread-component');
    }
}
