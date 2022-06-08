<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class SavedThreads extends Component
{
    public $user;
    public $savedthreads;
    public $totalsavedthreads;
    public $actiontype;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->savedthreads = $user->savedthreads()->take(10)->get();
        $this->totalsavedthreads = $user->savedthreads()->count();

        $this->actiontype = 'thread-saved';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.saved-threads', $data);
    }
}
