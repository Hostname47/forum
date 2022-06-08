<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Components\User\{Follower, Follows};
use App\Models\{User, Thread, Follow};
use App\Classes\NotificationHelper;
use App\View\Components\User\Follow\{FollowersViewer, FollowsViewer};

class FollowController extends Controller
{
    public function follow_user(Request $request) {
        $user = $request->validate(['user_id'=>'required|exists:users,id'])['user_id'];
        $user = User::find($user);
        if(is_null($user))
            abort(404, __('Oops something went wrong'));
        $currentuser = auth()->user();
        
        $this->authorize('follow_user', [Follow::class, $user]);

        $found = Follow::where('follower', $currentuser->id)
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\User');

        /**
         * Before follow a user, we check if the current user already follow this user;
         * If so ($found->count()>0), we need to delete the follow record because in this case the user click on unfollow button
         * If not we simply create a follow model and attach the current user as follower to the followed user
         * and finally notify this user that the current user follow him
         * If the user unfollow the visited user, we have to delete the notification of following process
         */
        
        if($found->count()) {
            $found->first()->delete();

            \DB::statement("DELETE FROM `notifications` 
            WHERE notifiable_id = " . $user->id .
            " AND JSON_EXTRACT(data, '$.action_type') = 'user-follow'
            AND JSON_EXTRACT(data, '$.action_user') = " . $currentuser->id);

            return -1;
        }

        $follow = new Follow;
        $follow->follower = $currentuser->id;
        $follow->followable_id = $user->id;
        $follow->followable_type = 'App\Models\User';
        $follow->save();

        $disableinfo = NotificationHelper::extract_notification_disable($user, $user->id, 'user', 'user-follow');
        if(!$disableinfo['disabled']) {
            $user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_type'=>'user-follow',
                    'resource_id'=>$user->id,
                    'resource_type'=>'user',
                    'options'=>[
                        'canbedisabled'=>1,
                        'canbedeleted'=>1,
                        'source_id'=>$user->id,
                        'source_type'=>'user'
                    ],
                    'resource_slice'=>"",
                    'action_statement'=>'user-follow',
                    'link'=>route('user.profile', ['user'=>$user->username]),
                    'bold'=>$currentuser->minified_name,
                    'image'=>$currentuser->sizedavatar(100)
                ])
            );
        }
        return 1;
    }

    public function get_followers_viewer(Request $request) {
        $uid = $request->validate(['user_id'=>'required|exists:users,id'])['user_id'];
        $user = User::excludedeactivatedaccount()->find($uid);
        if(is_null($user))
            abort(404, __('Oops something went wrong'));

        $totalfollowerscount = $user->followers()->count();

        $followersviewer = (new FollowersViewer($user));
        $followersviewer = $followersviewer->render(get_object_vars($followersviewer))->render();

        return [
            'payload'=>$followersviewer,
            'hasmore'=>$totalfollowerscount > 10
        ];
    }

    public function get_follows_viewer(Request $request) {
        $uid = $request->validate(['user_id'=>'required|exists:users,id'])['user_id'];
        $user = User::excludedeactivatedaccount()->find($uid);
        if(is_null($user))
            abort(404, __('Oops something went wrong'));

        $totalfollowscount = $user->followers()->count();

        $followsviewer = (new FollowsViewer($user));
        $followsviewer = $followsviewer->render(get_object_vars($followsviewer))->render();

        return [
            'payload'=>$followsviewer,
            'hasmore'=>$totalfollowscount > 10
        ];
    }

    public function fetch_more_followers(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
        ]);

        $user = User::excludedeactivatedaccount()->find($data['user_id']);
        if(is_null($user))
            abort(404, __('Oops something went wrong'));

        $followers = $user->followers()->skip($data['skip'])->orderBy('username')->take(10)->get();
        $hasmore = intval($data['skip']) + 10 < $user->followers()->count();
        
        $payload = "";
        foreach($followers as $follower) {
            $followercomponent = (new Follower($follower));
            $followercomponent = $followercomponent->render(get_object_vars($followercomponent))->render();
            $payload .= $followercomponent;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$followers->count()
        ];
    }

    public function fetch_more_follows(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
        ]);

        $user = User::find($data['user_id']);
        if(!$user) return '';
        $follows = $user->follows()->skip($data['skip'])->orderBy('username')->take(10)->get();
        $hasmore = intval($data['skip']) + 10 < $user->follows()->count();
        
        $payload = "";
        foreach($follows as $followeduser) {
            $followedusercomponent = (new Follows($followeduser));
            $followedusercomponent = $followedusercomponent->render(get_object_vars($followedusercomponent))->render();
            $payload .= $followedusercomponent;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$follows->count()
        ];
    }
    
    public function generate_follower_component(Request $request) {
        $user = $request->validate(['user_id'=>'required|exists:users,id'])['user_id'];
        $user = User::withoutGlobalScopes()->setEagerLoads([])->find($user);
        if(is_null($user))
            abort(404, __('Oops something went wrong'));

        $followercomponent = (new Follower($user));
        $followercomponent = $followercomponent->render(get_object_vars($followercomponent))->render();

        return $followercomponent;
    }
}
