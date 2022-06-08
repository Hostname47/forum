<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Types\TypicalWithoutActionuser;

class ThreadOpened extends TypicalWithoutActionuser
{
    use Queueable;

    public function __construct($notification)
    {
        parent::__construct($notification);
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }
}
