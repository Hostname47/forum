<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class RepliedThreads extends Component
{
    public $user;
    public $repliedthreads;
    public $repliedthreadscount;
    public $actiontype;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->repliedthreads = $user->repliedthreads()->take(10)->get();
        $this->repliedthreadscount = $user->repliedthreadscount;
        $this->actiontype = 'thread-replied';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.replied-threads', $data);
    }
}
