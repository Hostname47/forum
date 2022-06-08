<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use App\Classes\Helper;

class UserAction extends Notification implements ShouldBroadcast
{
    use Queueable;

    //public $afterCommit = true;
    public $action_user;
    public $image;
    public $bold;
    public $resource_slice;
    public $resource_type;
    public $action_type;
    public $action_statement;
    public $resource_id;
    public $link;
    public $options; // store informations and operations about notification

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->action_user = $data['action_user'];
        $this->action_type = $data['action_type'];
        $this->action_statement = $data['action_statement'];
        $this->resource_id = $data['resource_id'];
        $this->resource_type = $data['resource_type'];
        $this->options = $data['options'];
        $this->resource_slice = $data['resource_slice'];
        $this->link = $data['link'];
        $this->image = $data['image'];
        $this->bold = $data['bold'];
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

    public function toDatabase($notifiable) {
        return [
            'action_user'=>$this->action_user,
            'action_type'=>$this->action_type,
            'resource_id'=>$this->resource_id,
            'resource_type'=>$this->resource_type,
            'options'=>$this->options
        ];
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
        /**
         * Notice here that action statement must be localized based on receiver language preference;
         * If we passed it from here directly, the receiver may get the statement in the wrong language; for that reason we
         * are going to send just the slug, and then the receiver will send another request to get the statement
         */
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

    public function broadcastType()
    {
        return 'resource.reaction';
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
