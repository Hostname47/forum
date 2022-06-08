<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Classes\Helper;
use App\Notifications\Types\TypicalWithoutActionuser;

class UserStrike extends TypicalWithoutActionuser
{
    use Queueable;

    public function __construct($notification)
    {
        parent::__construct($notification);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }
}
