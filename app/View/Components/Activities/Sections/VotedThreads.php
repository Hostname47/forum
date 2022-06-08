<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class VotedThreads extends Component
{
    public $user;
    public $votedthreads;
    public $votedthreadscount;
    public $actiontype;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->votedthreads = $user->votedthreads()->take(10)->get(); // Skip 0 and get 10
        $this->votedthreadscount = $user->votedthreads()->count();
        $this->actiontype = 'thread-voted';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.voted-threads', $data);
    }
}
