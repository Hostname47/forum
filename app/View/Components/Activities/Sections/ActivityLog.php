<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;

class ActivityLog extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // We don't have to accept the user because this section appear to the profile owner only (so the user must be authenticated)
        $user = auth()->user();

        // Logic for retrieving logs
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities.sections.activity-log');
    }
}
