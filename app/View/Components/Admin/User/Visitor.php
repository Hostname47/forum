<?php

namespace App\View\Components\Admin\User;

use Illuminate\View\Component;
use Carbon\Carbon;

class Visitor extends Component
{
    public $visitor;
    public $guest;
    public $visitor_ip;
    public $visited_at_hummans;
    public $visited_at;

    public function __construct($visitor)
    {
        $this->visitor = $visitor['visitor'];
        $this->guest = is_null($visitor['visitor']);
        $this->visitor_ip = $visitor['visitor_ip'];
        $this->visited_at_hummans = (new Carbon($visitor['last_visit']))->diffForHumans();
        $this->visited_at = (new Carbon($visitor['last_visit']))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.user.visitor', $data);
    }
}
