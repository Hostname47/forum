<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Thread, Category};

class Threads extends Component
{
    public $user_threads_count;
    public $user;
    public $threads;
    public $actiontype;

    public function __construct(User $user, $data=[])
    {
        $this->user = $user;
        $this->threads = $user->threads()->orderBy('created_at', 'desc')->take(10)->get();
        $this->user_threads_count = isset($data['threadscount']) ? $data['threadscount'] : $user->threads()->count();
        $this->actiontype = 'thread-posted';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.threads', $data);
    }
}
