<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Classes\NotificationHelper;

class NotifyFollowers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $notification;
    protected $disable_data;

    public function __construct($user, $notification, $disable_data=[])
    {
        $this->user = $user;
        $this->notification = $notification;
        $this->disable_data = $disable_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->user->followers()->cursor() as $follower) {
            $disableinfo = NotificationHelper::extract_notification_disable(
                $follower, 
                $this->disable_data['resource_id'], 
                $this->disable_data['resource_type'],
                $this->disable_data['action_type']
            );

            if(!$disableinfo['disabled'])
                $follower->notify($this->notification);
        }
    }
}
