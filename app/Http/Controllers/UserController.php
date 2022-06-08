<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\IsValidPassword;
use App\Models\{Thread, Category, User, ProfileView, Like, Vote, Follow, AccountStatus};
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Classes\ImageResize;
use App\Classes\NotificationHelper;
use App\View\Components\User\{WarningComponent, StrikeComponent};
use App\Jobs\ExecuteQuery;
use App\Jobs\User\NotifyFollowers;
use Illuminate\Support\Facades\Bus;

class UserController extends Controller
{
    const PROFILE_THREADS_SIZE = 4;
    const PROFILE_THREADS_FETCH = 6;

    public function activities(Request $request, User $user) {
        $is_current = Auth::check() ? auth()->user()->id == $user->id : false;

        $accountstatus = $user->status->slug;
        /**
         * The reason we pass threads count from here is because in activites
         * view, we use this value in 2 different places (posts activity viewer)
         * and in user card so we have to pass the same value to these 2 components
         * instead of calculating user threads count twice
         */
        $userthreadscount = $user->threads()->count();
        if($accountstatus == 'deactivated') {
            return view('errors.custom.deactivated-account');
        } else if($accountstatus == 'banned') {
            return view('errors.custom.banned-account');
        }

        return view('user.activities')
            ->with(compact('user'))
            ->with(compact('userthreadscount'))
            ->with(compact('is_current'));
    }
    public function profile(Request $request, User $user) {
        $accountstatus = $user->status->slug;
        if($accountstatus == 'deactivated')
            return view('errors.custom.deactivated-account');
        else if($accountstatus == 'banned')
            return view('errors.custom.banned-account');

        // We count only 1 profile view per day (1 profile wiew associated to ip address)
        $alreadyviewed = ProfileView::where('created_at', '>', Carbon::now()->subHours(24)->toDateTimeString())
            ->where('visitor_ip', $request->ip())->count();
        if(!$alreadyviewed) {
            $profile_view = new ProfileView;
            $profile_view->visitor_ip = $request->ip();
            $profile_view->visited_id = $user->id;
            $profile_view->visitor_id = ($currentuser = auth()->user()) ? $currentuser->id : null;

            if($currentuser) // If current user is the same as visited profile, profile view will not saved
                if($user->id != auth()->user()->id)
                    $profile_view->save();
            else
                $profile_view->save();
        }

        // Check if the visitor is a follower of the visited profile
        $followed = false;
        if(auth()->user() && auth()->user()->id != $user->id)
            $followed = (bool) auth()->user()->follows()->where('followable_id', $user->id)->where('followable_type', 'App\Models\User')->count() > 0;
        
        $followerscount = $user->followers()->count();
        $followscount = $user->follows()->count();
        $threadscount = $user->threads()->count();

        $threads = $user->threads()
            ->orderBy('created_at', 'desc')->take(self::PROFILE_THREADS_SIZE)->get();
        $hasmore = $threadscount > $threads->count();

        return view('user.profile')
            ->with(compact('user'))
            ->with(compact('followerscount'))
            ->with(compact('followscount'))
            ->with(compact('followed'))
            ->with(compact('threads'))
            ->with(compact('threadscount'))
            ->with(compact('hasmore'));
    }
    public function edit(Request $request) {
        $user = auth()->user();
        $this->authorize('edit', $user);

        return view('user.settings.settings')
            ->with(compact('user'));
    }
    public function edit_personal_infos(Request $request) {
        $user = auth()->user();
        $this->authorize('update', $user);

        return view('user.settings.personal-settings')
            ->with(compact('user'));
    }
    public function strikes_and_warnings() {
        $user = auth()->user();
        $strikes = $user->strikes()->orderBy('created_at', 'desc')->take(6)->get();
        $warnings = $user->warnings()->orderBy('created_at', 'desc')->take(6)->get();
        $warningscount = $user->warnings()->count();
        $strikescount = $user->strikes()->count();

        return view('user.settings.strikes-and-warnings')
            ->with(compact('user'))
            ->with(compact('warnings'))
            ->with(compact('strikes'))
            ->with(compact('warningscount'))
            ->with(compact('strikescount'))
            ;
    }
    public function fetch_more_user_warnings(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric'
        ]);

        $warnings = auth()->user()->warnings()->orderBy('created_at', 'desc')->skip($data['skip'])->take(7)->get();
        $hasmore = $warnings->count() > 6;
        $warnings = $warnings->take(6);

        $payload = '';
        foreach($warnings as $warning) {
            $warningcomponent = (new WarningComponent($warning));
            $warningcomponent = $warningcomponent->render(get_object_vars($warningcomponent))->render();
            $payload .= $warningcomponent;
        }

        return [
            'payload'=>$payload,
            'hasmore'=>$hasmore,
            'count'=>$warnings->count()
        ];
    }
    public function fetch_more_user_strikes(Request $request) {
        $data = $request->validate([
            'skip'=>'required|numeric'
        ]);

        $strikes = auth()->user()->strikes()->orderBy('created_at', 'desc')->skip($data['skip'])->take(7)->get();
        $hasmore = $strikes->count() > 6;
        $strikes = $strikes->take(6);

        $payload = '';
        foreach($strikes as $strike) {
            $strikecomponent = (new StrikeComponent($strike));
            $strikecomponent = $strikecomponent->render(get_object_vars($strikecomponent))->render();
            $payload .= $strikecomponent;
        }

        return [
            'payload'=>$payload,
            'hasmore'=>$hasmore,
            'count'=>$strikes->count()
        ];
    }

    public function edit_password(Request $request) {
        $user = auth()->user();

        return view('user.settings.password-settings')
            ->with(compact('user'));
    }
    public function account_settings(Request $request) {
        $user = auth()->user();

        $banned = $user->isBanned();
        $ban="";
        $banreason="";
        $banduration="";
        $timeremaining="";

        if($banned) {
            $ban = $user->bans()->orderBy('created_at', 'desc')->first();
            $banreason = is_null($ban->ban_reason) ? $ban->rawreason : $ban->reason->reason;

            $banned_at = $ban->created_at;
            $duration = $ban->ban_duration;
            $duration = $banned_at->addDays($duration);
            // This is the time remaining for the ban duration in seconds
            $timeremaining = $ban->timeremaining;
            $banduration = $ban->formatedduration;
        }

        return view('user.settings.account-settings')
        ->with(compact('user'))
        ->with(compact('banned'))
        ->with(compact('ban'))
        ->with(compact('banreason'))
        ->with(compact('banduration'))
        ->with(compact('timeremaining'))
        ;
    }
    public function username_check(Request $request) {
        $username = $this->validate(
            $request, 
            ['username' => ['required', 'min:6', 'max:256', 'alpha_dash']],
            [
                'username.alpha_dash'=>__('Username must contain only letters, numbers or dashes'),
                'username.min'=>__('Username must contain at least 6 characters'),
                'username.max'=>__('Username is too long'),
            ]
        )['username'];

        $response = [
            'status'=>'valid',
            'message'=>__('valid username'),
            'valid'=>true
        ];

        $currentuser = auth()->user();
        if($currentuser->username == $username) {
            $response['status'] = 'yours';
            $response['message'] = __('valid username (your current username)');
        } else if(User::withoutGlobalScopes()->where('username', $username)->count()) {
            $response = [
                'status'=>'taken',
                'message'=>__('this username is already taken, choose another one'),
                'valid'=>false
            ];
        }

        return $response;
    }
    public function update(Request $request) {
        $user = auth()->user();
        $this->authorize('update', [User::class]);

        $data = $this->validate($request, [
            'firstname'=>'sometimes|alpha|max:266',
            'lastname'=>'sometimes|alpha|max:266',
            'username'=> [
                'sometimes',
                'alpha_dash',
                'required',
                'min:6',
                'max:256',
                Rule::unique('users')->ignore($user->id),   
            ],
            'about'=>'sometimes|max:1400',
            'avatar'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,png|max:5000|dimensions:min_width=20,min_height=10,max_width=2000,max_height=2000',
            'cover'=>'sometimes|file|image|mimes:jpg,gif,jpeg,bmp,png|max:10000|dimensions:min_width=20,min_height=10,max_width=8000,max_height=5000',
            'avatar_removed'=>['sometimes', Rule::in([0, 1])],
            'cover_removed'=>['sometimes', Rule::in([0, 1])],
        ], [
            'firstname.alpha'=>__('Firstname must contain only letters'),
            'lastname.alpha'=>__('Lastname must contain only letters'),
            'username.alpha_dash'=>__('Username must contain only letters, numbers or dashes'),
            'username.min'=>__('Username must contain at least 6 characters'),
            'username.max'=>__('Username is too long'),
            'avatar.max'=>__('Avatar size should be less than 5MB'),
            'avatar.dimensions'=>__('Invalid avatar dimensions. Please read rules in right panel'),
            'cover.max'=>__('Cover size should be less than 10MB'),
            'cover.dimensions'=>__('Invalid cover dimensions. Please read rules in right panel')
        ]);

        if(isset($data['avatar_removed']) && $data['avatar_removed'] == 1) {
            if(strpos($user->provider_avatar, 'deleted-') !== 0) 
                $user->update(['provider_avatar'=>'deleted-'.$user->provider_avatar]);
            $data['avatar'] = null;

            ExecuteQuery::dispatch(
                "DELETE FROM `notifications` 
                WHERE JSON_EXTRACT(data, '$.action_user') = $user->id 
                AND JSON_EXTRACT(data, '$.action_type')='user-avatar-change' 
                AND JSON_EXTRACT(data, '$.resource_id')= $user->id 
                AND JSON_EXTRACT(data, '$.resource_type')='user'"
            );
        }
        else if($request->hasFile('avatar')){
            /*
             * we are going to store the original avatar in avatars folder that contains all user avatars
             * and different dimensions of it in avatar folder
             */
            $path = $request->file('avatar')->storeAs(
                'users/' . $user->id. '/usermedia/avatars/originals', time().'.png', 'public'
            );
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($path);
            
            $avatar_dims = [[26, 50], [26, 100], [36, 50], [36, 100], [100, 50], [100, 100], [160, 50], [160, 100], [200, 60], [200, 100], [300, 70], [300, 100], [400, 80], [400, 100]];
            foreach($avatar_dims as $avatar_dim) {
                // *** 1) Initialise / load image
                $resizeObj = new ImageResize($path);

                // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                $resizeObj->resizeImage($avatar_dim[0], $avatar_dim[0], 'crop');

                $destination = 'users/' . $user->id . '/usermedia/avatars/segments/' . $avatar_dim[0] . (($avatar_dim[1] == 100) ? '-h.png' : '-l.png');
                $destination = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($destination);

                // *** 3) Save image ('image-name', 'quality [int]')
                $resizeObj->saveImage($destination, $avatar_dim[1]);
            }
            $data['avatar'] = 'has-avatar'; // Remember that the path to avatar is not hard coded stored; Instead it is fetched from users storage based on user id

            // Notify followers

            $notification = 
                new \App\Notifications\UserAction([
                    'action_user'=>$user->id,
                    'action_type'=>'user-avatar-change',
                    'resource_id'=>$user->id,
                    'resource_type'=>"user",
                    'options'=>[
                        'canbedisabled'=>true,
                        'canbedeleted'=>true
                    ],
                    'resource_slice'=>"",
                    'action_statement'=>'user-avatar-change',
                    'link'=>route('user.profile', ['user'=>$user->username]),
                    'bold'=>$user->minified_name,
                    'image'=>$user->sizedavatar(100)
                ]);

            /**
             *  --- Notifying folllowers about avatar change ---
             * 
             * before notifying followers we have to remove old notifications followers got 
             * about avatar change of this user. This process should be done before notifying followers 
             * to not delete the new notifications along with the old ones
             */
            
            Bus::chain([
                new ExecuteQuery(
                    "DELETE FROM `notifications` 
                    WHERE JSON_EXTRACT(data, '$.action_type')='user-avatar-change' 
                    AND JSON_EXTRACT(data, '$.action_user')=$user->id 
                    AND JSON_EXTRACT(data, '$.resource_type')='user' 
                    AND JSON_EXTRACT(data, '$.resource_id')=$user->id"
                ),
                new NotifyFollowers(
                    $user, 
                    $notification, 
                    ['resource_id'=>$user->id, 'resource_type'=>'user', 'action_type'=>'user-avatar-change']
                ),
            ])->dispatch();
        }

        if(isset($data['cover_removed']) && $data['cover_removed'] == 1)
            $data['cover'] = null;
        else if($request->hasFile('cover')){
            $path = $request->file('cover')->storeAs(
                'users/' . $user->id. '/usermedia/covers/originals', time() . '.png', 'public'
            );
            $data['cover'] = $path;
        }

        unset($data['avatar_removed']);
        unset($data['cover_removed']);

        $user->update($data);
        \Session::flash('message', __('Your profile settings has been updated successfully'));
    }
    public function update_personal(Request $request) {
        $user = auth()->user();
        $this->authorize('update', [User::class]);

        $data = $this->validate($request, [
            'birth'=>'sometimes|nullable|date',
            'phone'=>'sometimes|nullable|max:266',
            'country'=>'sometimes|min:1|max:100',
            'city'=>'sometimes|alpha|min:2|max:266',
            'facebook'=>'sometimes|nullable|url|max:266',
            'instagram'=>'sometimes|nullable|min:2|url|max:266',
            'twitter'=>'sometimes|nullable|url|max:266',
        ], [
            'birth.date'=>__('Birth is not a valid date'),
            'phone.max'=>__('Invalid phone number'),
            'facebook.url'=>__('Invalid facebook url format'),
            'instagram.url'=>__('Invalid instagram url format'),
            'twitter.url'=>__('Invalid twitter url format'),
        ]);

        $user->personal->update($data);
        \Session::flash('message', __('Your profile informations has been updated successfully'));
    }
    public function set_password(Request $request) {
        $user = auth()->user();
        $this->authorize('set_first_password', [User::class]);

        $data = $request->validate([
            'password' => [
                'required',
                'confirmed',
                new IsValidPassword(),
            ]
        ]);

        $password = Hash::make($data['password']);
        $user->update(['password'=>$password]);

        \Session::flash('message', __('Your password has been saved successfully.'));

        return route('home');
    }
    public function update_password(Request $request) {
        $user = auth()->user();
        $this->authorize('update_password', [User::class]);

        if(!Hash::check($request->currentpassword, $user->password))
            abort(422, __('Current password is invalid'));

        $data = $this->validate($request, ['password' => ['required', 'confirmed', new IsValidPassword()]]);

        $user->update(['password'=>Hash::make($data['password'])]);

        \Session::flash('message', __('Your password has been updated successfully'));
    }
    public function delete_account(Request $request) {
        $user = auth()->user();

        if(Hash::check($request->password, $user->password)) {
            $user->set_account_status('deleted');
            Auth::logout();
            
            $user->delete(); // Look at boot method in User model to check cleanups

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            \Session::flash('message', __('Your account has been deleted successfully'));
            return route('home');
        }

        abort(422, __('Invalid password. Try again'));
    }
    public function deactivate_account(Request $request) {
        $this->authorize('deactivate_account', [User::class]);
        $user = auth()->user();
        $data = $request->validate(['password'=>'required']);

        if(Hash::check($data['password'], $user->password)) {
            /**
             * To deactivate user account, we first set his account status to deactivated, and 
             * then we logged him out along with a flash message that will be printed to home
             * page after redirect
             */
            $user->set_account_status('deactivated');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            \Session::flash('message', __('Your account has been deactivated successfully'));
            return '/';
        }
        
        abort(422, __('Invalid password. Try again'));
    }
    public function activate_account_page() {
        if(!auth()->user() || (auth()->user() && !auth()->user()->account_deactivated()))
            abort(404);
        return view('user.settings.account-activation');
    }
    public function activate_account() {
        if(!auth()->user() || (auth()->user() && !auth()->user()->account_deactivated()))
            abort(404);

        $user = auth()->user();
        $user->set_account_status('active');

        \Session::flash('message', __("Your account is activated successfully"));
        return '/';
    }
    public function account_banned() {
        return view('errors.custom.ban-cant-access');
    }
}
