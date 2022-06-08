<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;
use App\Models\Feedback as Fdb;
use Carbon\Carbon;
use App\Models\User;

class Feedback extends Component
{
    public $feedback;
    public $owner;
    public $at_hummans;
    public $at;
    // Authorization
    public $can_delete;

    public function __construct(Fdb $feedback, $data=[])
    {
        $this->feedback = $feedback;
        $this->owner = $feedback->owner;
        $this->at = (new Carbon($feedback->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
        $this->at_hummans = (new Carbon($feedback->created_at))->diffForHumans();
        $this->can_delete = isset($data['candelete']) ? $data['candelete'] : auth()->user()->can('delete_feedback', [User::class]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.feedback', $data);
    }
}
