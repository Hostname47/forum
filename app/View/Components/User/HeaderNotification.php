<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{User, NotificationDisable};
use App\Classes\NotificationHelper;

class HeaderNotification extends Component
{
    public $id;
    // public $action_user;
    public $image;
    public $image_alt;
    public $link;
    public $bold;
    public $notification_statement;
    public $resource_slice;
    public $resource_action_icon;
    public $action_date_hummans;
    public $action_date;
    public $read;
    public $disableinfo;
    public $can_be_disabled;
    public $can_be_deleted;

    /**
     * Create a new component instance.
     *
     * * notification: is an object include distinct notification record from notifications table 
    *     by data->resource_id, data->resource_type and data->action_type along with additional
    *     column for users to include all users who perform the same operation on the same resource
    *     of the same id
     * @return: an object include everything related to the notification like action statement, link ..
     * 
     * @return void
     */
    public function __construct($notification)
    {
        $this->id = $notification['id'];
        // $this->action_user = $notification['action_user'];
        $this->image = $notification['image'];
        $this->image_alt = $notification['image_alt'];
        $this->bold = $notification['bold'];
        $this->notification_statement = $notification['notification_statement'];
        $this->resource_slice = $notification['resource_slice'];
        // Date : humman format, as well as normal format when hover
        $this->action_date_hummans = $notification['action_date_hummans'];
        $this->action_date = $notification['action_date'];
        $this->link = $notification['link'];
        $this->read = $notification['read'];
        $this->resource_action_icon = $notification['action_icon'];
        $this->can_be_disabled = $notification['options']->canbedisabled;
        $this->can_be_deleted = $notification['options']->canbedeleted;
        if($this->can_be_disabled)
            $this->disableinfo = $notification['disableinfo'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.header-notification', $data);
    }
}
