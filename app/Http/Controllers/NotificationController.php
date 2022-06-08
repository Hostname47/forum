<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Components\User\HeaderNotification;
use Illuminate\Notifications\DatabaseNotification;
use App\Classes\NotificationHelper;
use App\Models\{User, Notification, NotificationDisable, NotificationStatement, Thread, Post};
use App\View\Components\Notification\NotificationDisableComponent;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Enable/disable notifications
     * We have notificationsdisables table which stores disables records to recognize user disabled events(actions)
     * and each record store the following data :
     *  user_id: the user who disable
     *  resource_id: the id of resource disabled
     *  resource_type: the type of resource
     *  disabled_action: the type of event action
     */

    public function notifications() {
        $user = auth()->user();
        $notifications_manager = $user->distinct_notifications(0, 8);
        $notifications = $notifications_manager['notifs'];
        $hasmore = $notifications_manager['hasmore'];

        return view('user.notifications')
            ->with(compact('user'))
            ->with(compact('notifications'))
            ->with(compact('hasmore'));
    }

    public function notifications_settings() {
        $currentuser = auth()->user();
        $totaldisablescount = $currentuser->notificationsdisables()->count();
        // $notificationsdisables = $currentuser->notificationsdisables()->orderBy('created_at', 'desc')->take(6)->get();
        $notificationsdisables = $currentuser->notificationsdisables()
        ->select(\DB::raw(
            "ANY_VALUE(disabled_action) as disabled_action,
            COUNT(*) as disablescount"))
        ->groupBy("disabled_action")
        ->get();

        $disables = $notificationsdisables->map(function($disable) {
            return [
                'action'=>$disable->disabled_action,
                'infos'=>NotificationHelper::hummans_action_name($disable->disabled_action),
                'count'=>$disable->disablescount,
            ];
        })->sortBy('disable_title');

        return view('user.settings.notifications-settings')
            ->with(compact('disables'))
            ->with(compact('totaldisablescount'))
        ;
    }

    public function get_notification_disables_by_type(Request $request) {
        $data = $request->validate([
            'type'=>'required|max:200',
            'skip'=>'sometimes|numeric'
        ]);
        $skip = isset($data['skip']) ? $data['skip'] : 0;

        $currentuser = auth()->user();
        $disables = $currentuser->notificationsdisables()
            ->where('disabled_action', $request->type)->orderBy('created_at', 'desc')->skip($skip)->take(5)->get();
        $hasmore = $disables->count() > 4;
        $disables = $disables->take(4);

        $payload = '';
        foreach($disables as $disable) {
            $disablecomponent = (new NotificationDisableComponent($disable));
            $disablecomponent = $disablecomponent->render(get_object_vars($disablecomponent))->render();
            $payload .= $disablecomponent;
        }

        return [
            'payload'=>$payload,
            'hasmore'=>$hasmore,
            'count'=>$disables->count()
        ];
    }

    public function mark_as_read() {
        $user = auth()->user();

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }

    public function mark_single_notification_as_read(DatabaseNotification $notification) {
        $this->authorize('mark_single_notification_as_read', [Notification::class, $notification]);

        $notification->markAsRead();
    }

    public function mark_group_of_notifications_as_read(Request $request) {
        $data = $request->validate([
            'ids.*'=>'exists:notifications,id'
        ]);
        $this->authorize('mark_group_of_notifications_as_read', [Notification::class, $data['ids']]);

        foreach($data['ids'] as $id)
            DatabaseNotification::find($id)->markAsRead();
    }

    public function notification_generate(Request $request) {
        $data = $request->validate([
            'notification_id'=>'required|exists:notifications,id',
        ]);

        $notification = DatabaseNotification::find($data['notification_id']);
        
        $actionuser = (isset($notification['data']['action_user'])) ? [$notification['data']['action_user']] : [null];
        $notification = NotificationHelper::get_user_notification_fragments($notification, $actionuser);

        $notification_component = (new HeaderNotification($notification));
        $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
        
        return $notification_component;
    }

    public function notification_generate_range(Request $request) {
        $data = $request->validate([
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric'
        ]);

        $currentuser = auth()->user();
        $notifications = $currentuser->distinct_notifications($data['skip'], $data['range']);
        $notifs_to_return = $notifications['notifs'];

        $payload = "";

        foreach($notifs_to_return as $notification) {
            $notification_component = (new HeaderNotification($notification));
            $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
            $payload .= $notification_component;
        }

        return [
            "hasmore"=> $notifications['hasmore'],
            "content"=>$payload,
            "count"=>$notifications['count']
        ];
    }

    public function generate_header_notifications_bootstrap() {
        $payload = "";
        $user = auth()->user();

        $notifications = $user->distinct_notifications(0, 6);
        foreach($notifications['notifs'] as $notification) {
            $notification_component = (new HeaderNotification($notification));
            $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
            $payload .= $notification_component;
        }

        return [
            'count'=>$notifications['count'],
            'content'=>$payload,
            'hasmore'=>$notifications['hasmore'],
        ];
    }

    // To understand how enable/disable notifications work, read the comments docs in top of this file
    public function disable(Request $request, $id) {
        $notification = Notification::find($id);
        if(!$notification)
            throw new \Exception(__('Oops something went wrong'));
        
        $user = auth()->user();
        $ndata = \json_decode($notification->data); // ndata: notification data column content
        $disabledata = NotificationHelper::extract_notification_disable($user, $ndata->resource_id, $ndata->resource_type, $ndata->action_type);

        if($disabledata['disabled'])
            throw new \Exception(__('This type of notification is already disabled'));

        $this->authorize('disable', [Notification::class, $notification]);

        $disable = new NotificationDisable;
        $disable->user_id = $user->id;
        $disable->resource_id = $disabledata['resource_id'];
        $disable->resource_type = $disabledata['resource_type'];
        $disable->disabled_action = $disabledata['disabled_action'];
        $disable->source_id = $disabledata['source_id'];
        $disable->source_type = $disabledata['source_type'];

        $disable->save();

        return [
            'status'=>'disabled',
            'message'=>$disabledata['message_after_disable'],
            'button_label'=>$disabledata['enable_button_label'], // When notification is disabled we have to show enble text label
        ];
    }

    public function enable(Request $request, $id) {
        $notification = Notification::find($id);
        if(!$notification)
            throw new \Exception(__('Oops something went wrong'));
        
        $user = auth()->user();
        $ndata = \json_decode($notification->data); // ndata:notification data column content
        $disabledata = NotificationHelper::extract_notification_disable($user, $ndata->resource_id, $ndata->resource_type, $ndata->action_type);

        if(!$disabledata['disabled'])
            throw new \Exception(__('Notification already enabled'));

        $this->authorize('enable', [Notification::class, $notification]);

        NotificationDisable::
            where('resource_id', $disabledata['resource_id'])
            ->where('resource_type', $disabledata['resource_type'])
            ->where('disabled_action', $disabledata['disabled_action'])
            ->delete();

        return [
            'status'=>'enabled',
            'message'=>$disabledata['message_after_enable'],
            'button_label'=>$disabledata['disable_button_label'],
        ];
    }

    public function enablev1(Request $request) {
        $disable = $request->validate(['disable'=>'required|exists:notificationsdisables,id'])['disable'];
        $disable = NotificationDisable::find($disable);

        $this->authorize('enablev1', [Notification::class, $disable]);

        $disable->delete();

        \Session::flash('message', __('Notifications enabled successfully'));
    }

    public function destroy(Request $request, $id) {
        $notification = Notification::find($id);
        if(!$notification)
            throw new \Exception(__('Oops something went wrong'));

        $this->authorize('delete', [Notification::class, $notification]);

        // In case the user has already disable certain type of notification action based on this notification
        // he will get resource not available in notifications settings page

        $currentuser = auth()->user();
        $notification_data = \json_decode($notification->data);

        \DB::statement(
            "DELETE FROM `notifications` 
            WHERE notifiable_id = $currentuser->id
            AND JSON_EXTRACT(data, '$.action_type')='$notification_data->action_type' 
            AND JSON_EXTRACT(data, '$.resource_type')='$notification_data->resource_type' 
            AND JSON_EXTRACT(data, '$.resource_id')=" . $notification_data->resource_id
        );
    }

    public function get_notification_statement(Request $request, $slug) {
        /**
         * We have to use trans_choice because there are some statements that handle singular and plural forms differently
         * and because this method in called for notification receiving and for only one action per user
         */
        return trans_choice(NotificationStatement::where('slug', $slug)->first()->statement, 1);
    }
}
