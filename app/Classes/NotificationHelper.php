<?php

namespace App\Classes;

use Illuminate\Notifications\DatabaseNotification;
use App\Models\{User, Thread, Post, NotificationStatement};
use Carbon\Carbon;

class NotificationHelper {

    /**
     * This function require 4 parameters : user id to check, and 3 parameters extracted from notification data which are
     * resource_id(action_resource_id), resource_type, action_type
     * It returns array of informations about disable
     */
    public static function extract_notification_disable($user, $resource_id, $resource_type, $action_type) {
        $disabled_action = $action_type;
        $message_after_disable = "";
        $disable_button_label = "";
        $enable_button_label = "";
        $source_id="";
        $source_type="";

        switch($action_type) {
            case 'thread-share':
                /**
                 * When a user share a thread, all followers get notification about this new post;
                 * By disabling this type of notifications; the follower will no longer get notifications about new posts from this poster
                 * This means the follower disables thread share (disabled_action) events to be broadcasted FROM 'user' which is the resource owner (resource_type) with id=2 (resource_id)
                 * 
                 * This method allows us to easily check if an event could be broadcasted to a follower (or resource owner) or not letter
                 */
                $u = User::withoutGlobalScopes()->find($resource_id);
                $message_after_disable = __('You will no longer receive notifications like these from') . ' ' . $u->minifiedname . '. ' . __('You can re-enable them from the settings page') . '.';
                $disable_button_label = __('Disable notifications like these from this user');
                $enable_button_label = __('Re-enable this type of notifications of this user');

                $source_id=$resource_id;
                $source_type='user';
                break;
            case 'thread-vote':
            case 'thread-like':
            case 'thread-reply':
            case 'poll-vote':
            case 'poll-option-add':
                /**
                 * If action type is one of the above values, it simply means that the user disable notifications
                 * on the thread; It doesn't matter the type of action; what does matter is the resource id
                 */
                $resource_type='thread';
                $message_after_disable = __(' You will no longer receive notifications like these from this post') . '. ' . __('You can re-enable them from the settings page') . '.';
                $disable_button_label = __('Disable this type of notifications on this post');
                $enable_button_label = __('Re-enable this type of notifications on this post');

                $source_id=$resource_id;
                $source_type='thread';
                break;
            case 'post-like':
            case 'post-vote':
                $resource_type='post';
                $message_after_disable = __('You will no longer receive notifications like these from this reply') . '. ' . __('You can re-enable them from the settings page') . '.';
                $disable_button_label = __('Disable notifications on this reply');
                $enable_button_label = __('Re-enable notifications on this reply');

                $post = Post::withoutGlobalScopes()->find($resource_id);
                $source_id = is_null($post) ? -1 : $post->thread_id;
                $source_type='thread';
                break;
            case 'post-tick':
                $message_after_disable = __('You will no longer receive notifications about replies tick') . '. ' . __('You can re-enable them from the settings page') . '.';
                $disable_button_label = __('Disable notifications Like these');
                $enable_button_label = __('Re-enable notifications');

                $post = Post::withoutGlobalScopes()->find($resource_id);

                $resource_id= is_null($post) ? -1 : $post->user_id;
                $resource_type='user';

                $source_id = is_null($post) ? -1 : $post->user_id;
                $source_type='user';
                break;
            case 'user-avatar-change':
            case 'user-cover-change':
                $message_after_disable = __('You will no longer receive notifications like these from this user') . '. ' . __('You can re-enable them from the settings page') . '.';
                $disable_button_label = __('Disable notifications like these on this user');
                $enable_button_label = __('Re-enable this type of notifications on this user');

                $source_id=$resource_id;
                $source_type='user';
                break;
            case 'user-follow':
                /**
                 * resource_id=1(from notification action_resource_id); resource_type='user'; $disabled_action='user-follow';
                 * means disable user-follow (disabled_action) events to be broadcasted to user (resource_type) with id=$user->id (resource_id)
                 */
                $message_after_disable = __('You will no longer receive notifications about new follows') . '. ' . __('You can re-enable them from the settings page') . '.';
                $disable_button_label = __('Disable notifications when other people follow you');
                $enable_button_label = __('Re-enable notifications when others follow you');

                $source_id=$resource_id;
                $source_type='user';
                break;
        }

        $disabled = $user->notificationsdisables()
            ->where('resource_id', $resource_id)
            ->where('resource_type', $resource_type)
            ->where('disabled_action', $disabled_action)->count() > 0;

        return [
            'resource_id'=>$resource_id,
            'resource_type'=>$resource_type,
            'disabled_action'=>$disabled_action,
            'disabled'=>$disabled,
            'message_after_disable'=>$message_after_disable,
            'message_after_enable'=>__('Notifications re-enabled successfully') . '.',
            'disable_button_label'=>$disable_button_label,
            'enable_button_label'=>$enable_button_label,
            'source_id'=>$source_id,
            'source_type'=>$source_type
        ];
    }

    /**
     * This function take a database notification and users parameters, and return an array that
     * hold every information about notification
     * 
     * users parameter: hold all users who perform the same action on same resource as string with comma separated
     */
    public static function get_user_notification_fragments(DatabaseNotification $notification, $users) {
        $result = [];
        $ucount = count($users);
        $ndata = $notification['data'];
        $noptions = $ndata['options'];

        // First let's put the shared segments
        $result['id'] = $notification['id'];
        $result['image']="";
        $result['image_alt']="";
        $result['action_date_hummans'] = (new Carbon($notification['created_at']))->diffForHumans();
        $result['action_date'] = (new Carbon($notification['created_at']))->isoFormat("dddd D MMM YYYY - H:mm A");
        $result['read'] = !is_null($notification['read_at']);
        $result['options'] = (object)$noptions;
        // get action icon based on action type
        $result['action_icon'] = (new \App\Classes\Helper)->notification_icon($ndata['action_type']);

        if($users[0]) {
            $user = User::withoutGlobalScopes()->find($users[0]); // Last user perform action on the resource
            $result['image'] = $user->sizedavatar(36, '-l');
            $result['image_alt'] = $user->minified_name . ' ' . __('profile picture');
        }

        $action_type = $ndata['action_type'];
        $resource_id = $ndata['resource_id'];
        $resource_type = $ndata['resource_type'];

        $link="";
        $bold=""; // notification bold text that comes in the begining of notification
        $statement="";
        $resourceslice="";
        $mergetype;

        switch($action_type) {
            case 'first-signin-welcome':
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $link = '/';
                $bold = __('Moroccan Gladiator');
                $statement = __(NotificationStatement::where('slug', 'first-signin-welcome')->first()->statement);
                break;
            case 'first-signin-password-set':
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $link = route('user.passwords.settings');
                $bold = __('Please read this') . ': ';
                $statement = __(NotificationStatement::where('slug', 'first-signin-password-set')->first()->statement);
                break;
            case 'thread-like':
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'thread-like')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;
                }
                $link = $thread->link;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'thread-like')->first()->statement, $ucount);
                $resourceslice = ' : ' . $thread->slice;
                break;
            case 'post-like':
                $post = Post::withoutGlobalScopes()->find($resource_id);
                if(is_null($post)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'post-like')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'post-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;                    
                }
                $link = ($post->ticked) ? $post->thread()->withoutGlobalScopes()->first()->link : $post->thread()->withoutGlobalScopes()->first()->link . '?reply=' . $post->id;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'post-like')->first()->statement, $ucount);
                $resourceslice = ' : ' . $post->slice;
                break;
            case 'thread-vote':
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'thread-vote')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;
                }
                $link = $thread->link;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'thread-vote')->first()->statement, $ucount);
                $resourceslice = ' : ' . $thread->slice;
                break;
            case 'post-vote':
                $post = Post::withoutGlobalScopes()->find($resource_id);
                if(is_null($post)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'post-vote')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'post-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;                    
                }
                $link = ($post->ticked) ? $post->thread()->withoutGlobalScopes()->first()->link : $post->thread()->withoutGlobalScopes()->first()->link . '?reply=' . $post->id;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'post-vote')->first()->statement, $ucount);
                $resourceslice = ' : ' . $post->slice;
                break;
            case 'user-avatar-change':
                $user = User::withoutGlobalScopes()->find($resource_id);
                $link = $user->profilelink;
                $bold = $user->minified_name;
                $statement = __(NotificationStatement::where('slug', 'user-avatar-change')->first()->statement);
                break;
            case 'thread-share':
                // In thread-share event we store threadowner as resourceid
                $threadowner = User::withoutGlobalScopes()->find($resource_id);
                $thread = Thread::where('user_id', $threadowner->id)->orderBy('created_at', 'desc')->first(); // This will give us the last thread of this user (we want to determine the type of the thread [poll or discussion] to get the proper statement)
                if(is_null($thread)) {
                    $bold = $threadowner->minified_name;
                    $statement = __(NotificationStatement::where('slug', 'typical-thread-share')->first()->statement);
                    $link = $threadowner->profilelink;
                    break;
                }
                $stmslug = ($thread->type == 'poll') ? 'poll-thread-share' : 'typical-thread-share';

                $bold = $threadowner->minified_name;
                $statement = __(NotificationStatement::where('slug', $stmslug)->first()->statement);
                $link = $threadowner->profilelink; // Link will point to the profile of the poster
                if($ucount > 1)
                    if($ucount == 2)
                        $statement .= '. ' . __(NotificationStatement::where('slug', 'thread-share-missed-post')->first()->statement);
                    else
                        $statement .= '. ' . __(NotificationStatement::where('slug', 'thread-share-missed-posts')->first()->statement, ['n'=>$ucount-1]); // n-1 : because we already pointed one in the statement
                else {
                    // If there's only one post (means one user because we use user as resource type for thread-share event so when we combine action user we get array of users with same id)
                    // we're going to add slice
                    if(is_null($thread)) {
                        $statement .= '(<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    } else
                        $resourceslice = ' : ' . $thread->slice;
                }
                break;
            case 'thread-reply':
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'typical-thread-reply')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;
                }
                $link = $thread->link;
                $bold = self::mixusersnames($users);
                $stmslug = ($thread->type == 'poll') ? 'poll-thread-reply' : 'typical-thread-reply';
                $statement = trans_choice(NotificationStatement::where('slug', $stmslug)->first()->statement, $ucount);
                $resourceslice = ' : ' . $thread->slice; // Replied to your post : (thread slice)
                break;
            case 'post-tick':
                $post = Post::withoutGlobalScopes()->find($resource_id);
                if(is_null($post)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = __(NotificationStatement::where('slug', 'post-tick')->first()->statement) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'post-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;                    
                }
                $thread = $post->thread()->withoutGlobalScopes()->first();
                $link = $thread->link;
                $bold = self::mixusersnames($users);
                $statement = __(NotificationStatement::where('slug', 'post-tick')->first()->statement);
                $resourceslice = ' : ' . $post->slice;
                break;
            case 'poll-vote':
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'poll-vote')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;
                }
                $link = $thread->link;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'poll-vote')->first()->statement, $ucount);
                $resourceslice = ' : ' . $thread->slice;
                break;
            case 'poll-option-add':
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = trans_choice(NotificationStatement::where('slug', 'poll-option-add')->first()->statement, $ucount) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    $resourceslice = '';
                    break;
                }
                $link = $thread->link;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'poll-option-add')->first()->statement, $ucount);
                $resourceslice = ' : ' . $thread->slice;
                break;
            case 'user-follow':
                $user = auth()->user();
                $link = $user->profilelink;
                $bold = self::mixusersnames($users);
                $statement = trans_choice(NotificationStatement::where('slug', 'user-follow')->first()->statement, $ucount);
                break;
            case 'post-restore':
                $currentuser = auth()->user();
                $post = Post::withoutGlobalScopes()->find($resource_id);
                $result['image'] = $currentuser->sizedavatar(36, '-l');
                $result['image_alt'] = $currentuser->minified_name . ' ' . __('profile picture');
                if(is_null($post)) {
                    $link = '#';
                    $statement = __(NotificationStatement::where('slug', 'post-restored')->first()->statement) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'post-not-available')->first()->statement) . '</em>)';
                    break;
                }
                $thread = $post->thread()->withoutGlobalScopes()->first();
                if(!is_null($thread->deleted_at)) {
                    $link = '#';
                    $statement = __(NotificationStatement::where('slug', 'post-restored')->first()->statement) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'post-parent-thread-not-available')->first()->statement) . '</em>)';
                    break;
                }
                $link = ($post->ticked) ? $thread->link : $thread->link . '?reply=' . $post->id;
                $statement = __(NotificationStatement::where('slug', 'post-restored')->first()->statement);
                break;
            case 'thread-close':
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $statement = __(NotificationStatement::where('slug', 'thread-closed')->first()->statement) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    break;
                }
                $link = $thread->link;
                $statement = __(NotificationStatement::where('slug', 'thread-closed')->first()->statement);
                break;
            case 'thread-open':
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                if(is_null($thread)) {
                    $link = '#';
                    $bold = self::mixusersnames($users);
                    $statement = __(NotificationStatement::where('slug', 'thread-opened')->first()->statement) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    break;
                }
                $link = $thread->link;
                $statement = __(NotificationStatement::where('slug', 'thread-opened')->first()->statement);
                break;
            case 'thread-delete':
                $link = route('user.activities', ['user'=>auth()->user()->username, 'section'=>'archived-threads']);
                $statement = __(NotificationStatement::where('slug', 'thread-deleted')->first()->statement);
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                break;
            case 'thread-restore':
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $thread = Thread::withoutGlobalScopes()->setEagerLoads([])->find($resource_id);
                $statement = 'thread-restored';
                if(is_null($thread)) {
                    $link = '#';
                    $statement = __(NotificationStatement::where('slug', $statement)->first()->statement) . '. (<em class="gray fs13">' . __(NotificationStatement::where('slug', 'thread-not-available')->first()->statement) . '</em>)';
                    break;
                }
                $link = $thread->link;
                if($thread->status->slug == 'live') {
                    $statement = 'thread-restored-and-opened';
                }
                $statement = __(NotificationStatement::where('slug', $statement)->first()->statement);
                break;
            case 'warn-user':
                $link = route('user.strikes');
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $bold = ''; // MG
                $statement = __(NotificationStatement::where('slug', $noptions['type'])->first()->statement);
                break;
            case 'strike-user':
                $link = route('user.strikes');
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $bold = ''; // MG
                $statement = __(NotificationStatement::where('slug', $noptions['type'])->first()->statement);
                break;
            case 'temporarily-ban-user':
                $link = route('user.account');
                $result['image'] = asset('assets/images/logos/IC.png');
                $result['image_alt'] = "website icon";
                $bold = ''; // MG
                $statement = __(NotificationStatement::where('slug', 'temporary-ban')->first()->statement);
                break;
        }

        $result['link'] = $link;
        $result['bold'] = $bold;
        $result['notification_statement'] = $statement;
        $result['resource_slice'] = $resourceslice;

        if($noptions['canbedisabled'])
            $result['disableinfo'] = self::extract_notification_disable(auth()->user(), 
                $resource_id, $resource_type, $action_type);

        return $result;
    }

    public static function mixusersnames($users) {
        $mix = User::withoutGlobalScopes()->find($users[0])->minified_name;
        if(count($users) > 1)
            if(count($users) == 2)
                $mix .= ' ' . __('and') . ' ' . User::withoutGlobalScopes()->find($users[1])->minified_name;
            else {
                $others = count($users) - 2;
                $mix .= ', ' . User::withoutGlobalScopes()->find($users[1])->minified_name . ' ' . __('and') . ' ' . $others . ' ' . (($others > 1) ? __('others') : __('other'));
            }

        return $mix;
    }

    public static function hummans_action_name($action_type) {
        switch($action_type) {
            case 'thread-like':
                return [
                    'title'=>__('Your posts likes'),
                    'desc'=>__('Posts you have disabled likes notifications on')
                ];
            case 'post-like':
                return [
                    'title'=>__('Your replies likes'),
                    'desc'=>__('Replies you have disabled likes notifications on')
                ];
            case 'thread-vote':
                return [
                    'title'=>__('Your posts votes'),
                    'desc'=>__('Posts you have disabled votes notifications on')
                ];
            case 'post-vote':
                return [
                    'title'=>__('Your replies votes'),
                    'desc'=>__('Posts where you have disabled likes notifications on')
                ];
            case 'user-avatar-change':
                return [
                    'title'=>__('Your follows avatar change'),
                    'desc'=>__('Follows that you have disabled avatar change notifications on')
                ];
            case 'thread-share':
                return [
                    'title'=>__('New posts by your follows'),
                    'desc'=>__('Follows that you have disabled notifications on their new posts')
                ];
            case 'thread-reply':
                return [
                    'title'=>__('Replies on your posts'),
                    'desc'=>__('Posts that you have disabled notifications about new replies')
                ];
            case 'post-tick':
                return [
                    'title'=>__('Post reply tick'),
                    'desc'=>__('Posts where you have disabled reply tick notifications on')
                ];
            case 'poll-vote':
                return [
                    'title'=>__('Votes on your polls'),
                    'desc'=>__('Polls you have disabled votes notifications on')
                ];
            case 'poll-option-add':
                return [
                    'title'=>__('Your poll options adding'),
                    'desc'=>__('Polls you have disable options adding notifications on')
                ];
            case 'user-follow':
                return [
                    'title'=>__('New followers'),
                    'desc'=>__('Notifications disabled when a new follower starts to following you')
                ];
            default:
                return "";
        }
    }
}
