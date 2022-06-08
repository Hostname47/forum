<?php

namespace App\Policies;

use App\Models\{User, Notification};
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, $notification) {
        if($user->id != $notification->notifiable_id) {
            $user->log_authbreak('try-to-delete-a-notification-does-not-belong-to-the-deleter', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("You can't delete this notification, because you don't own it ! Admins will review this unauthorized action"));
        }

        if(!json_decode($notification->data)->options->canbedeleted) {
            $user->log_authbreak('try-to-delete-non-allowable-to-be-deleted-notification', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("This type of notifications can't be deleted ! Admins will review this unauthorized action"));
        }

        return true;
    }

    public function disable(User $user, $notification) {
        if($user->id != $notification->notifiable_id) {
            $user->log_authbreak('try-to-disable-non-allowable-to-be-disabled-notification', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("You can't disable this notification, because you don't own it ! Admins will review this unauthorized action"));
        }

        return true;
    }

    public function enable(User $user, $notification) {
        if($user->id != $notification->notifiable_id) {
            $user->log_authbreak('try-to-enable-a-notification-does-not-belong-to-the-enabler', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("You can't enable this notification, because you don't own it ! Admins will review this unauthorized action"));
        }

        return true;
    }

    public function enablev1(User $user, $disable) {
        if($user->id != $disable->user_id) {
            $user->log_authbreak('try-to-enable-a-notification-does-not-belong-to-the-enabler', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("You can't enable this notification, because you don't own it ! Admins will review this unauthorized action"));
        }

        return true;
    }

    public function mark_single_notification_as_read(User $user, $notification) {
        if($user->id != $notification->notifiable_id) {
            $user->log_authbreak('try-to-read-a-notification-does-not-own', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("Unauthorized action. Admins will review this unauthorized action"));
        }

        return true;
    }

    public function mark_group_of_notifications_as_read(User $user, $ids) {
        // All notifications must belong to the auth user
        foreach($ids as $id) {
            if($user->id != Notification::find($id)->notifiable_id) {
                $user->log_authbreak('try-to-read-a-notification-does-not-own', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
                return $this->deny(__("You can't mark this notification as read, because you don't own it ! Admins will review this unauthorized action"));
            }
        }

        return true;
    }

    public function get_notification_statement(User $user, $notification) {
        if(!$notification)
            throw new \Exception(__('Oops something went wrong. Please refresh the page'));
            
        if($user->id != $notification->notifiable_id) {
            $user->log_authbreak('try-to-read-a-notification-does-not-own', ['resource_id'=>$notification->id, 'resource_type'=>'Notification']);
            return $this->deny(__("Unauthorized action. Admins will review this unauthorized action"));
        }

        return true;
    }
}
