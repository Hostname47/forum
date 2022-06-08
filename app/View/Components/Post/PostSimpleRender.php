<?php

namespace App\View\Components\Post;

use Illuminate\View\Component;

class PostSimpleRender extends Component
{
    public $post;
    public $postowner;
    public $thread;
    public $threadowner;

    public function __construct($post)
    {
        $this->post = $post;
        $this->postowner = isset($post->user) ? $post->user : $post->user()->withoutGlobalScopes()->first();
        $this->thread = isset($post->thread) ? $post->thread : $post->thread()->withoutGlobalScopes()->first();
        $this->threadowner = isset($this->thread->user) ? $this->thread->user : $this->thread->user()->withoutGlobalScopes()->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.post.post-simple-render', $data);
    }
}
