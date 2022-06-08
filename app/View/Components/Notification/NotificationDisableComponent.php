<?php

namespace App\View\Components\Notification;

use Illuminate\View\Component;
use App\Classes\NotificationHelper;

class NotificationDisableComponent extends Component
{
    public $disable;

    public function __construct($disable)
    {
        $this->disable = $disable;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.notification.notification-disable-component', $data);
    }
}
