<?php

namespace App\Notifications\Types;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Classes\Helper;

class TypicalWithoutActionuser extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $image;
    public $bold;
    public $resource_slice;
    public $resource_type;
    public $action_type;
    public $action_statement;
    public $resource_id;
    public $link;
    public $options;

    public function __construct($notification)
    {
        $this->action_type = $notification['action_type'];
        $this->action_statement = $notification['action_statement'];
        $this->resource_id = $notification['resource_id'];
        $this->resource_type = $notification['resource_type'];
        $this->options = $notification['options'];
        $this->resource_slice = $notification['resource_slice'];
        $this->link = $notification['link'];
        $this->image = $notification['image'];
        $this->bold = $notification['bold'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        $action_type = $this->action_type;
        $action_icon = (new Helper)->notification_icon($action_type);

        return (new BroadcastMessage([
            'notification_id'=>$this->id,
            'action_statement'=>$this->action_statement,
            'resource_slice'=>$this->resource_slice,
            'link'=>$this->link,
            "image"=>$this->image,
            "bold"=>$this->bold,
            'action_icon'=>$action_icon,
        ]));
    }

    public function toDatabase($notifiable) {
        return [
            'action_type'=>$this->action_type,
            'resource_id'=>$this->resource_id,
            'resource_type'=>$this->resource_type,
            'options'=>$this->options
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
