<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\{User, Thread, Post, Warning, Strike, Report, BanReason, UserBan, StrikeReason, WarningReason};
use App\Classes\Helper;
use App\View\Components\Admin\Report\{NotifyResourceOwner, NotifyReportersViewerBox};
use App\View\Components\Admin\User\{ManageAvatarsViewer, ManageCoversViewer, AuthorizationbreakComponent, BanComponent};
use App\View\Components\Admin\User\Review\{ReviewThreadsViewer, ReviewPostsViewer, ReviewVotesViewer, ReviewVisitsViewer, ReviewAuthbreaksViewer, ReviewWarningsViewer, ReviewStrikesViewer};
use App\View\Components\Admin\Post\PostReviewComponent;
use App\View\Components\Admin\Thread\ThreadReviewComponent;
use App\View\Components\User\{WarningComponent, StrikeComponent};
use App\Notifications\{UserAction, UserWarning as UserWarningNotification, UserStrike as UserStrikeNotification};
use App\View\Components\Admin\Viewers\NewSignupsViewer;
use App\View\Components\Admin\User\SignupUser;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    public function set_admin_status(Request $request) {
        $status = $request->validate([
            'status'=>['required', Rule::in(['online', 'away', 'busy', 'appear-offline'])]
        ])['status'];

        \Illuminate\Support\Facades\Cache::forever('admin-status-for-user-'.auth()->user()->id, $status);
    }

    public function warn(Request $request) {
        $this->authorize('warnuser', [Warning::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'resource_id'=>'required|numeric',
            'resource_type'=>'required|min:2|max:255',
            'reason_id'=>'required|exists:warning_reasons,id'
        ]);
        $data['warned_by'] = auth()->user()->id;
        $warning = Warning::create($data);
        
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $type = strtolower(substr($data['resource_type'], strrpos($data['resource_type'], '\\') + 1)) . '-warning';
        // Notify the resource owner
        $user->notify(
            new UserWarningNotification([
                'action_type'=>'warn-user',
                'resource_id'=>$warning->id,
                'resource_type'=>'warning',
                'options'=>[
                    'canbedisabled'=>0,
                    'canbedeleted'=>0,
                    'type'=>$type,
                    // Normally we need to set this to thread if a thread get a strike (or one of its posts) but for making things simple we set its source to the user who has the strike
                    'source_type'=>'user',
                    'source_id'=>$user->id
                ],
                'resource_slice'=>'',
                'action_statement'=>$type,
                'link'=>route('user.strikes'),
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );
        
        // Flash message
        \Session::flash('message', "User has been warned successfully.");
        
    }

    public function strike(Request $request) {
        $this->authorize('strikeuser', [Strike::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'resource_id'=>'required|numeric',
            'resource_type'=>'required|min:2|max:255',
            'reason_id'=>'required|exists:warning_reasons,id'
        ]);
        $data['striked_by'] = auth()->user()->id;
        $strike = Strike::create($data);
        
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $type = strtolower(substr($data['resource_type'], strrpos($data['resource_type'], '\\') + 1)) . '-strike';
        $user->notify(
            new UserStrikeNotification([
                'action_type'=>'strike-user',
                'resource_id'=>$strike->id, // See reason for appending time() above in warn method
                'resource_type'=>'strike',
                'options'=>[
                    'canbedisabled'=>0,
                    'canbedeleted'=>0,
                    'type'=>$type,
                    // Read the notice in warn above
                    'source_type'=>'user',
                    'source_id'=>$user->id
                ],
                'resource_slice'=>'',
                'action_statement'=>$type,
                'link'=>route('user.strikes'),
                'bold'=>'',
                'image'=>asset('assets/images/logos/IC.png')
            ])
        );

        // Flash message
        \Session::flash('message', "User has been striked successfully.");
    }

    public function warn_group(Request $request) {
        $this->authorize('warn_group_of_users', [User::class]);
        /**
         * Warn group of users - each user get a warning on a particular resource id in resources_ids that
         * is attached to user by order between users_to_warn and resources_ids
         * We asume here that the resource type is common between all resources because when we warn a group of users
         * most of the time is for the same reason so the resource type mostly common
         */
        $data = $request->validate([
            'resources_ids'=>'required',
            'resources_ids.*'=>'numeric',
            'resource_type'=>'required|min:1|max:255',
            'reason_id'=>'required|exists:warning_reasons,id',
            'users_to_warn'=>'required',
            'users_to_warn.*'=>'required|exists:users,id'
        ]);

        $c = 0;
        $rtype = strtolower(substr($data['resource_type'], strrpos($data['resource_type'], '\\') + 1));
        foreach($data['users_to_warn'] as $usertowarn) {
            $warning = new Warning;
            $warning->warned_by = auth()->user()->id;
            $warning->reason_id = $data['reason_id'];
            $warning->user_id = $usertowarn;
            $warning->resource_type = $data['resource_type'];
            $warning->resource_id = $data['resources_ids'][$c];
            $warning->save();
            $c++;
            
            // Notify the resource owner
            User::withoutGlobalScopes()->find($usertowarn)->notify(
                new UserWarningNotification([
                    'action_type'=>'warn-user',
                    'resource_id'=>$warning->resource_id,
                    'resource_type'=>$rtype,
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'warning'
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'warning',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        }

        \Session::flash('message', "Selected reporters have been warned successfully.");
    }

    public function strike_group(Request $request) {
        $this->authorize('strike_group_of_users', [User::class]);
        $data = $request->validate([
            'resources_ids'=>'required',
            'resources_ids.*'=>'numeric',
            'resource_type'=>'required|min:1|max:255',
            'reason_id'=>'required|exists:strike_reasons,id',
            'users_to_strike'=>'required',
            'users_to_strike.*'=>'required|exists:users,id'
        ]);

        $c = 0;
        $rtype = strtolower(substr($data['resource_type'], strrpos($data['resource_type'], '\\') + 1));
        foreach($data['users_to_strike'] as $usertostrike) {
            $strike = new Strike;
            $strike->striked_by = auth()->user()->id;
            $strike->reason_id = $data['reason_id'];
            $strike->user_id = $usertostrike;
            $strike->resource_type = $data['resource_type'];
            $strike->resource_id = $data['resources_ids'][$c];
            $strike->save();
            $c++;
            
            // Notify the resource owner
            User::withoutGlobalScopes()->find($usertostrike)->notify(
                new UserStrikeNotification([
                    'action_type'=>'strike-user',
                    'resource_id'=>$strike->resource_id,
                    'resource_type'=>$rtype,
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'strike'
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'strike',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        }

        \Session::flash('message', "Selected reporters have been striked successfully.");
    }

    public function remove_warning(Request $request) {
        $this->authorize('clear_user_warning', [User::class]);
        $data = $request->validate([
            'warning_id'=>'required|exists:warnings,id'
        ]);

        $warning = Warning::find($data['warning_id']);
        $warning->delete();
        \Session::flash('message', "Warning has been removed from user successfully.");
    }

    public function remove_strike(Request $request) {
        $this->authorize('clear_user_strike', [User::class]);
        $data = $request->validate([
            'strike_id'=>'required|exists:strikes,id'
        ]);

        $strike = Strike::find($data['strike_id']);
        $strike->delete();
        \Session::flash('message', "Strike has been removed from user successfully.");
    }

    public function admin_users_dashboard(Request $request) {
        return view('admin.users.dashboard');
    }

    public function manage_user(Request $request) {
        $user = null;
        $userstats = [];
        $accountstatus = 'active';
        
        // for ban section
        $banned = false;
        $ban = null;
        $bans = $banreasons = collect([]);
        $totaluserbans = 0;

        if($request->has('uid') && ($user=User::withoutGlobalScopes()->find($request->get('uid')))) {
            $userstats['followers'] = $user->followers()->count();
            $userstats['follows'] = $user->follows()->count();
            $userstats['threads'] = $user->totalthreadscount;
            $userstats['posts'] = $user->totalpostscount;
            $userstats['votes'] = $user->totalvotescount;
            $userstats['warnings'] = $user->warnings()->count();
            $userstats['strikes'] = $user->strikes()->count();
            $userstats['authbreaks'] = $user->authorizationbreaks()->count();

            $accountstatus = $user->status;
            // For ban section
            $banned = $user->isBanned();
            if($banned) $ban = $user->ban;
            $totaluserbans = $user->bans()->withoutGlobalScopes()->count();
            $bans = $user->bans()->withoutGlobalScopes()->with('bannedby', 'reason')->orderBy('created_at', 'desc')->take(3)->get();
            $banreasons = BanReason::all();
        }

        return view('admin.users.manage-user')
            ->with(compact('user'))
            ->with(compact('userstats'))
            ->with(compact('accountstatus'))
            // Ban section
            ->with(compact('banned'))
            ->with(compact('bans'))
            ->with(compact('ban'))
            ->with(compact('banreasons'))
            ->with(compact('totaluserbans'))
            ;
    }

    /**
     * When the admin choose to ban a user, there are 2 choices
     * 1. Temporary ban, which last for a period of time
     * 2. Permanent ban which last forever
     * 
     * Both ban types has a reason for the ban (or a raw message in case admin choose a raw message)
     * when admin ban a user permanently, we set the duration to -1
     */
    public function ban_user(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'ban_reason'=>'sometimes|exists:ban_reasons,id',
            'ban_duration'=>'required_if:type,temporary|numeric|min:7|max:365',
            'type'=>['required', Rule::in(['temporary', 'permanent'])]
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);

        if($user->isBanned())
            abort(422, 'User already banned');

        $userban = new UserBan;
        $userban->admin_id = auth()->user()->id;
        $userban->user_id = $data['user_id'];
        $userban->type = $data['type']; 
        $userban->ban_reason = $data['ban_reason'];
        
        if($data['type'] == 'temporary') {
            $this->authorize('ban_user_temporarily', [User::class]);
            $userban->ban_duration = $data['ban_duration'];
            $userban->save();
            $user->set_account_status('temp-banned');

            $user->notify(
                new \App\Notifications\UserBanned([
                    'action_type'=>'temporarily-ban-user',
                    'resource_id'=>$userban->id,
                    'resource_type'=>'ban',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'source_type'=>'App\Models\User',
                        'source_id'=>$user->id
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'temporary-ban',
                    'link'=>route('user.account'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        } else {
            $this->authorize('ban_user_permanently', [User::class]);
            /**
             * For permanent ban we set duration to -1, and we use -1 as an indicator to see if the
             * ban record is a permanent ban or just a temporary ban
             */
            $userban->ban_duration = -1;
            $userban->save();
            $user->set_account_status('banned');
        }

        \Session::flash('message', $user->username . ' has been banned successfully');
    }
    public function unban_user(Request $request) {
        $this->authorize('unban_user', [User::class]);
        $data = $request->validate(['user_id'=>'required|exists:users,id']);
        $user = User::withoutGlobalScopes()->find($data['user_id']);

        $ban = $user->bans()->delete();

        // Then we open the user account
        $user->set_account_status('active');
    }
    public function clean_expired_ban(Request $request) {
        $this->authorize('unban_user', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id'
        ]);

        if(!auth()->user()->has_permission('clean-expired-ban'))
            abort(403, 'Unauthorized action due to lack ofpermission');

        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $user->bans()->where('ban_duration', '<>', -1)->orderBy('created_at', 'desc')->first()->delete();
        $user->set_account_status('active');

        \Session::flash('message', 'Expired ban has been deleted successfully along with setting user account status to active');
    }

    public function check_resource(Request $request) {
        $data = $request->validate([
            'uid'=>'required|exists:users,id',
            'resourceid'=>'required|numeric',
            'resourcetype'=>[
                'required',
                Rule::in(['App\Models\Thread', 'App\Models\Post']),
            ],
        ]);

        $user = User::withoutGlobalScopes()->find(intval($data['uid']));
        $found = false;
        switch($data['resourcetype']) {
            case 'App\Models\Thread':
                $found = $user->threads()
                    ->withoutGlobalScopes()->where('id', $data['resourceid'])->count() > 0;
                break;
            case 'App\Models\Post':
                $found = $user->userposts()
                    ->withoutGlobalScopes()->where('id', $data['resourceid'])->count() > 0;
                break;
        }

        return $found;
    }

    public function get_avatars_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ManageAvatarsViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_covers_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ManageCoversViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_threads_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewThreadsViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_posts_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewPostsViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_votes_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewVotesViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_visits_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewVisitsViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_authbreaks_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewAuthbreaksViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_user_warnings_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewWarningsViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function get_user_strikes_review_viewer(Request $request) {
        $user = User::withoutGlobalScopes()->find($request->userid);
        $viewer = (new ReviewStrikesViewer($user));
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }

    public function delete_avatar(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'link'=>'required|max:200',
            'wsaction'=>['required', Rule::in(['warn','strike'])]
        ]);

        $this->authorize('delete_user_avatar', [User::class]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $avatarname = basename($data['link']);
        $message = "Avatar has been deleted successfully along with a warning sent to user";

        if($data['wsaction'] == 'warn') {
            $warning = new Warning;
            $warning->user_id = $user->id;
            $warning->warned_by = auth()->user()->id;
            $warning->reason_id = WarningReason::where('slug', 'avatar-guidelines-non-respect')->first()->id;
            $warning->resource_type = 'User\Avatar';
            $warning->rawcontent = json_encode([
                'avatar'=>$avatarname,
            ]);
            $warning->save();

            // Notify the resource owner
            $user->notify(
                new UserWarningNotification([
                    'action_type'=>'warn-user',
                    'resource_id'=>$warning->id,
                    'resource_type'=>'warning',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'avatar-warning'
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'avatar-warning',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        } else {
            $strike = new Strike;
            $strike->striked_by = auth()->user()->id;
            $strike->user_id = $user->id;
            $strike->reason_id = StrikeReason::where('slug','avatar-guidelines-non-respect')->first()->id;
            $strike->resource_type = 'User\Avatar';
            $strike->rawcontent = json_encode([
                'avatar'=>$avatarname,
            ]);
            $strike->save();

            // Notify the resource owner
            $user->notify(
                new UserStrikeNotification([
                    'action_type'=>'strike-user',
                    'resource_id'=>$strike->id,
                    'resource_type'=>'strike',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'avatar-strike'
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'avatar-strike',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
            $message = "Avatar has been deleted successfully along with a strike sent to user";
        }

        // If the deleted avatar is the one he used, we have to set it to null
        if($avatarname == basename($user->avatar))
            $user->update(['avatar'=>null]);

        Storage::disk('public')->move(
            'users/' . $user->id . '/usermedia/avatars/originals/' . $avatarname, 
            'users/' . $user->id . '/usermedia/avatars/trash/' . $avatarname
        );

        \Session::flash('message', $message);
    }

    public function delete_cover(Request $request) {
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'link'=>'required|max:200',
            'wsaction'=>['required', Rule::in(['warn','strike'])]
        ]);

        $this->authorize('delete_user_cover', [User::class]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $covername = basename($data['link']);
        $message = "Cover has been deleted successfully along with a warning sent to user";

        if($data['wsaction'] == 'warn') {
            $warning = new Warning;
            $warning->user_id = $user->id;
            $warning->warned_by = auth()->user()->id;
            $warning->reason_id = WarningReason::where('slug', 'cover-guidelines-non-respect')->first()->id;
            $warning->resource_type = 'User\Cover';
            $warning->rawcontent = json_encode([
                'cover'=>$covername,
            ]);
            $warning->save();

            // Notify the resource owner
            $user->notify(
                new UserWarningNotification([
                    'action_type'=>'warn-user',
                    'resource_id'=>$warning->id,
                    'resource_type'=>'warning',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'cover-warning'
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'cover-warning',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
        } else {
            $strike = new Strike;
            $strike->striked_by = auth()->user()->id;
            $strike->user_id = $user->id;
            $strike->reason_id = StrikeReason::where('slug','cover-guidelines-non-respect')->first()->id;
            $strike->resource_type = 'User\Cover';
            $strike->rawcontent = json_encode([
                'cover'=>$covername,
            ]);
            $strike->save();

            // Notify the resource owner
            $user->notify(
                new UserStrikeNotification([
                    'action_type'=>'strike-user',
                    'resource_id'=>$strike->id,
                    'resource_type'=>'strike',
                    'options'=>[
                        'canbedisabled'=>0,
                        'canbedeleted'=>0,
                        'type'=>'cover-strike'
                    ],
                    'resource_slice'=>'',
                    'action_statement'=>'cover-strike',
                    'link'=>route('user.strikes'),
                    'bold'=>'',
                    'image'=>asset('assets/images/logos/IC.png')
                ])
            );
            $message = "Cover has been deleted successfully along with a strike sent to user";
        }

        // If the deleted cover is the one he used, we have to set it to null
        if($covername == basename($user->cover))
            $user->update(['cover'=>null]);
        Storage::disk('public')->move(
            'users/' . $user->id . '/usermedia/covers/originals/' . $covername, 
            'users/' . $user->id . '/usermedia/covers/trash/' . $covername
        );

        \Session::flash('message', $message);
    }

    public function fetch_more_user_review_votes(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'take'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $votes = $user->votes()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $votes->count() > $data['take'];
        $votes = $votes->take($data['take']);

        $threads = Thread::withoutGlobalScopes()
            ->whereIn('id', $votes->where('votable_type', 'App\Models\Thread')->pluck('votable_id'))->get();
        $posts = Post::withoutGlobalScopes()->with('user')
            ->whereIn('id', $votes->where('votable_type', 'App\Models\Post')->pluck('votable_id'))->get();

        $resources = collect([]);
        foreach($votes as $vote) {
            if($vote->votable_type == 'App\Models\Thread') {
                $resources->push($threads->find($vote->votable_id));
            } else if($vote->votable_type == 'App\Models\Post') {
                $resources->push($posts->find($vote->votable_id));
            }
        }

        $payload = "<div class='user-votes-review-chunk'>";
        foreach($resources as $resource) {
            $resourceview="";
            if($resource instanceof \App\Models\Thread)
                $resourceview = new ThreadReviewComponent($resource, $user->id);
            else if($resource instanceof \App\Models\Post)
                $resourceview = new PostReviewComponent($resource, $user->id);
            
            $resourceview = $resourceview->render(get_object_vars($resourceview))->render();
            $payload .= $resourceview;
        }
        $payload .= '</div>';

        return [
            "hasmore"=> $hasmore,
            "payload"=>$payload,
            "count"=>$votes->count()
        ];
    }

    public function fetch_more_user_review_authbreaks(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $authbreaks = $user->authorizationbreaks()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $authbreaks->count() > $data['take'];
        $authbreaks = $authbreaks->take($data['take']);
        
        $payload = '';
        foreach($authbreaks as $authbreak) {
            $viewer = (new AuthorizationbreakComponent($authbreak));
            $viewer = $viewer->render(get_object_vars($viewer))->render();
            $payload .= $viewer;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$authbreaks->count(), // used to handle last count authbreaks events (front-end)
        ];
    }

    public function fetch_more_user_review_warnings(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $warnings = $user->warnings()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $warnings->count() > $data['take'];
        $warnings = $warnings->take($data['take']);
        $can_clear_warning = auth()->user()->can('clear_user_warning', [User::class]);
        $payload = '';
        foreach($warnings as $warning) {
            $viewer = (new WarningComponent($warning, true, $can_clear_warning));
            $viewer = $viewer->render(get_object_vars($viewer))->render();
            $payload .= $viewer;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$warnings->count(), // used to handle last count warnings events (front-end)
        ];
    }

    public function fetch_more_user_review_strikes(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $strikes = $user->strikes()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $strikes->count() > $data['take'];
        $strikes = $strikes->take($data['take']);
        $can_clear_strikes = auth()->user()->can('clear_user_strike', [User::class]);
        
        $payload = '';
        foreach($strikes as $strike) {
            $viewer = (new StrikeComponent($strike, true, $can_clear_strikes));
            $viewer = $viewer->render(get_object_vars($viewer))->render();
            $payload .= $viewer;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$strikes->count(), // used to handle last count strikes events (front-end)
        ];
    }

    public function fetch_more_user_review_bans(Request $request) {
        $this->authorize('review_user_resources_and_activities', [User::class]);
        $data = $request->validate([
            'user_id'=>'required|exists:users,id',
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $user = User::withoutGlobalScopes()->find($data['user_id']);
        $bans = $user->bans()->withoutGlobalScopes()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $bans->count() > $data['take'];
        $bans = $bans->take($data['take']);
        
        $payload = '';
        foreach($bans as $ban) {
            $viewer = (new BanComponent($ban));
            $viewer = $viewer->render(get_object_vars($viewer))->render();
            $payload .= $viewer;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$bans->count(), // used to handle last count bans events (front-end)
        ];
    }

    public function get_newsignups_viewer() {
        $viewer = new NewSignupsViewer();
        $viewer = $viewer->render(get_object_vars($viewer))->render();

        return $viewer;
    }
    
    public function fetch_more_newsignups(Request $request) {
        $data = $request->validate([
            'skip'=>'required|Numeric',
            'take'=>'required|Numeric',
        ]);
        $users = User::withoutGlobalScopes()->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take'] + 1)->get();
        $hasmore = $users->count() > $data['take'];
        $users = $users->take($data['take']);
        
        $payload = '';
        foreach($users as $user) {
            $viewer = (new SignupUser($user));
            $viewer = $viewer->render(get_object_vars($viewer))->render();
            $payload .= $viewer;
        }

        return [
            "payload"=>$payload,
            "hasmore"=> $hasmore,
            "count"=>$users->count(),
        ];
    }
}
