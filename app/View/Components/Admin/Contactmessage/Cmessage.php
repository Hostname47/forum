<?php

namespace App\View\Components\Admin\Contactmessage;

use Illuminate\View\Component;
use App\Models\{ContactMessage, User};
use Carbon\Carbon;

class Cmessage extends Component
{
    public $message;
    public $owner;
    public $at_hummans;
    public $at;
    public $onlymessage;

    public $can_read;
    public $can_delete;

    public function __construct(ContactMessage $message, $onlymessage=false, $data=[])
    {
        $this->message = $message;
        $this->onlymessage = $onlymessage;
        $this->owner = $message->owner;
        $this->at = (new Carbon($message->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
        $this->at_hummans = (new Carbon($message->created_at))->diffForHumans();
        // authorization
        $this->can_read = isset($data['canread']) ? $data['canread'] : auth()->user()->can('mark_contact_message_as_read', [User::class]);
        $this->can_delete = isset($data['candelete']) ? $data['candelete'] : auth()->user()->can('delete_contact_message', [User::class]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.admin.contactmessage.cmessage', $data);
    }
}
