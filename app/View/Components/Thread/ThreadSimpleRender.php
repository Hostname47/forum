<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;

class ThreadSimpleRender extends Component
{
    public $thread;
    public $threadowner;

    public function __construct($thread)
    {
        $this->thread = $thread;
        $this->threadowner = is_null($thread->user) ? $thread->user()->withoutGlobalScope()->first() : $thread->user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.thread-simple-render', $data);
    }
}
