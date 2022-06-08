<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Role, Permission, UserStatus, UserReach, ProfileView, 
    Thread, Post, SavedThread, UserPersonalInfos, AccountStatus, ContactMessage,
    Vote, Like, Notification, NotificationDisable, Follow, FAQ, Strike, Warning, UserBan, Report,
    Authorizationbreak, AuthBreakType};
use App\Permissions\HasPermissionsTrait;
use Illuminate\Support\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ExcludeDeactivatedUser;
use App\Classes\NotificationHelper;
use App\Jobs\User\CleanUserResourcesAfterDelete;

class User extends UserAuthenticatable implements Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait, SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $guarded = [];
    private $avatar_dims = [26, 36, 100, 160, 200, 300, 400];
    protected $raw_avatar;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        //"data" => "array"
    ];

    protected static function booted() {
        // Infinite call fore applying global scope to user model
        // static::addGlobalScope(new ExcludeDeactivatedUser);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function(User $user) {
            CleanUserResourcesAfterDelete::dispatch($user); // Queued job for deleting all user resources after deletion
            /**
             * Remember that the following statements only clea the content of the directories
             * and not the directories themselves
             */
            (new Filesystem)->cleanDirectory(public_path() . '/users/' . $user->id . '/usermedia/avatars/segments');
            (new Filesystem)->cleanDirectory(public_path() . '/users/' . $user->id . '/usermedia/avatars/originals');
            (new Filesystem)->cleanDirectory(public_path() . '/users/' . $user->id . '/usermedia/covers/originals');
            // delete user threads directory that containes medias (images and videos of deleted threads)
            (new Filesystem)->cleanDirectory(public_path() . '/users/' . $user->id . '/threads');
        });
    }

    // Even though using local scopes needs a lot of code update like prefixing user fetch queries but
    // it gives me what I need and it doesn't cause infinite (nested) calls to the scope like in global scopes
    public function scopeExcludedeactivatedaccount($query) {
        return $query->where('account_status', '<>', AccountStatus::where('slug', 'deactivated')->first()->id);
    }

    public function getHasavatarAttribute() {
        if(is_null($this->avatar)) {
            /**
             * If user avatar is null we have to check avatar_provider
             * If avatar_provider is not null and it doesn't contains deleted- substring in its value
             * we return true because that means user still use provider_avatar
             * (deleted-) will be appended to provider_avatar if user choose to delete his avatar when it is provided by oauth service)
             */
            if(!is_null($this->provider_avatar) && strpos($this->provider_avatar, 'deleted-') !== 0)
                return true;
            else
                return false;
        }

        return true;
    }

    public function sizedavatar($size, $quality="-h") {
        if($this->hasavatar)
            if(is_null($this->avatar))
                return $this->provider_avatar;
            else
                return asset('/users/' . $this->id . '/usermedia/avatars/segments/' . $size . $quality . '.png');
                
        else
            return asset("users/defaults/medias/avatars/$size-l.png");
    }

    public function sizeddefaultavatar($size, $quality="-h") {
        return asset("users/defaults/medias/avatars/" . $size . $quality . ".png");
    }

    public function visits() {
        return $this->hasMany(Visit::class, 'visitor_id');
    }

    public function reach() {
        return $this->hasMany(UserReach::class, 'reachable');
    }

    public function status() {
        return $this->belongsTo(AccountStatus::class, 'account_status');
    }

    public function strikes() {
        return $this->hasMany(Strike::class);
    }

    public function warnings() {
        return $this->hasMany(Warning::class);
    }

    public function bans() {
        return $this->hasMany(UserBan::class);
    }

    public function authorizationbreaks() {
        return $this->hasMany(Authorizationbreak::class);
    }

    public function log_authbreak($typeslug, $data=[]) {
        $authbreak = new Authorizationbreak;
        $authbreak->user_id = $this->id;
        $authbreak->type = AuthBreakType::where('slug', $typeslug)->first()->id;
        $authbreak->data = empty($data) ? null : json_encode($data);
        $authbreak->save();
    }

    public function getBanAttribute() {
        return $this->bans()->orderBy('created_at', 'desc')->first();
    }

    public function getReachcountAttribute() {
        return UserReach::where('reachable', $this->id)->count();
    }

    public function getCoverAttribute($value) {
        if($value) return asset($value);

        return $value;
    }

    public function getAvatarDimensionsCountAttribute() {
        return count($this->avatar_dims);
    }

    public function getProfileViewsAttribute() {
        return ProfileView::where('visited_id', $this->id)->count();
    }

    // Relationships
    public function personal() {
        return $this->hasOne(UserPersonalInfos::class);
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function threadsvotes() {
        return $this->votes()->where('votable_type', 'App\Models\Thread');
    }

    public function threadslikes() {
        return $this->likes()->where('likable_type', 'App\Models\Thread');
    }

    public function posts() {
        return $this->hasManyThrough(Post::class, Thread::class);
    }

    public function reportings() {
        return $this->hasMany(Report::class, 'reporter');
    }

    public function userposts() {
        return $this->hasMany(Post::class);
    }

    public function likedthreads() {
        return $this->belongsToMany(Thread::class, 'likes', 'user_id', 'likable_id')
        ->withTimestamps()
        ->withPivot('created_at')
        ->where('likable_type', 'App\\Models\\Thread')
        ->orderBy('likes.created_at', 'desc');
    }

    public function repliedthreads() {
        return $this->belongsToMany(Thread::class, 'posts', 'user_id', 'thread_id')
            ->withTimestamps()
            ->withPivot('created_at')
            ->where('posts.deleted_at', null)
            ->groupBy('posts.thread_id')
            ->orderBy('posts.created_at', 'desc');
    }

    public function getRepliedthreadscountAttribute() {
        return $this->belongsToMany(Thread::class, 'posts', 'user_id', 'thread_id')
            ->withTimestamps()
            ->withPivot('created_at')
            ->where('posts.deleted_at', null)
            ->distinct('posts.thread_id')
            ->orderBy('posts.created_at', 'desc')->count();
    }

    public function votedthreads() {
        return $this->belongsToMany(Thread::class, 'votes', 'user_id', 'votable_id')
        ->withTimestamps()
        ->withPivot('created_at')
        ->where('votable_type', 'App\\Models\\Thread')
        ->orderBy('votes.created_at', 'desc');
    }

    public function savedthreads() {
        return $this->belongsToMany(Thread::class, 'saved_threads', 'user_id', 'thread_id')
        ->withTimestamps()
        ->withPivot('created_at')
        ->orderBy('saved_threads.created_at', 'desc');
    }

    public function archivedthreads() {
        return $this->threads()->onlyTrashed()->orderBy('deleted_at', 'desc');
    }

    public function notificationsdisables() {
        return $this->hasMany(NotificationDisable::class);
    }

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'followable_id', 'follower');
    }

    public function follows() {
        return $this->belongsToMany(User::class, 'follows', 'follower', 'followable_id');
    }

    public function faqs() {
        return $this->hasMany(FAQ::class);
    }

    public function isthatthreadsaved($thread) {
        return \DB::select(
            "SELECT COUNT(*) as saved
            FROM saved_threads
            WHERE user_id=$this->id AND thread_id=$thread->id")[0]->saved > 0;
    }

    public function getFollowedUsersAttribute() {
        return 
            Follow::where('follower', $this->id)
            ->where('followable_type', 'App\Models\User')
            ->get();
    }

    public function votes_on_threads() {
        return $this->threadsvotes()->count();
    }

    public function votes_on_posts() {
        return Vote::where('user_id', $this->id)->where('votable_type', 'App\Models\Post')->count();
    }

    public function votes_count() {
        return $this->votes()->count();
    }

    public function getTotalthreadscountAttribute() {
        return $this->threads()->withoutGlobalScopes()->count();
    }

    public function getTotalpostscountAttribute() {
        return $this->userposts()->withoutGlobalScopes()->count();
    }

    public function getTotalvotescountAttribute() {
        return $this->votes()->withoutGlobalScopes()->count();
    }

    public function isBanned() {
        $status = $this->status->slug;
        if($status == 'banned') return true;
        
        $banned = false;
        if($status == 'temp-banned')
            /**
             * Here because we're using soft deleting in userban models we have to check whether it exists a userban
             * record that is not soft deleted and not expired
             */
            if($ban=$this->bans()->orderBy('created_at', 'desc')->first()) {
                $now_in_seconds = Carbon::now()->timestamp;
                $deadline_in_seconds = $ban->created_at->addDays($ban->ban_duration)->timestamp;
                $banned = $deadline_in_seconds - $now_in_seconds > 0; // user is banned if ban deadline is greather than the current(now) timestamp
            }

        return $banned;
    }

    public function isPermanentBanned() {
        return $this->status->slug == 'banned';
    }

    public function high_role() {
        return $this->roles->sortBy('priority')->first();
    }

    public function isModerator() {
        return (bool) $this->roles()->whereIn('slug', ['admin', 'super-admin', 'site-owner', 'moderator'])->count();
    }

    public function isAdmin() {
        return (bool) $this->roles()->whereIn('slug', ['admin', 'super-admin', 'site-owner', 'moderator'])->count();
    }

    public function isSuperadmin() {
        return (bool) $this->roles()->whereIn('slug', ['super-admin', 'site-owner'])->count();
    }

    public function isSiteOwner() {
        return $this->has_role('site-owner');
    }

    public function account_deactivated() {
        return $this->status->slug == 'deactivated';
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function today_posts_count() {
        return DB::select("SELECT COUNT(*) as today_posts FROM posts WHERE user_id=$this->id AND created_at >= '" . \Carbon\Carbon::today() . "' AND deleted_at IS NULL")[0]->today_posts;
    }

    public function posts_count() {
        $count = 0;
        foreach($this->threads as $thread) {
            $count += $thread->posts->count();
        }

        return $count;
    }

    /**
     * To get distinct notifications, we group all notifications by resource id, and then by action_type
     * and foreach group, we get the id of one of the group (ANY_VALUE() because we gonna need it in disabling process) 
     * and then we need data column which has similar attributes to the records of the group except action_user,
     * and then we get the last record created_at value by using MAX aggregate : MAX(created_at) to get last notifications 
     * date to print it
     * and then read_at we look for the greatest value of read_at column in group and if one of these rows has null we simply 
     * return null which means it's not read
     * and finally we extract users of each group by concatenate them using group_concat and we sort them to get the last user 
     * who take the last action (order by inside group_concat)
     */
    public function distinct_notifications($skip=0, $take=6) {
        $skip = intval($skip);
        $take = intval($take);

        $notifications = $this->notifications()
        ->select(\DB::raw(
            "ANY_VALUE(id) as id,
             ANY_VALUE(data) as data, 
             MAX(created_at) as created_at, 
             CASE WHEN MAX(read_at IS NULL)=0 THEN MAX(read_at) END as read_at, 
             group_concat(JSON_EXTRACT(data, '$.action_user') ORDER BY created_at DESC) as users")) // users alias here combine all users who perform the same action type on the same resource (common id/type)
        ->groupByRaw("JSON_EXTRACT(data, '$.resource_id'), JSON_EXTRACT(data, '$.action_type')")
        ->skip($skip)->take($take+1)->get();

        $hasmore = $notifications->count() > $take;

        if(count($notifications) == 0)
            return [
                'notifs'=>collect([]),
                'hasmore'=>false,
                'count'=>0
            ];

        $notifications = $notifications->take($take); // Because we deliberately took $take+1 to know whether it has more or not

        $result = collect([]);
        foreach($notifications as $notification) {
            $n = NotificationHelper::get_user_notification_fragments($notification, explode(',', $notification->users));
            $result->push($n);
        }

        return [
            'notifs'=>$result,
            'hasmore'=>$hasmore,
            'count'=>$result->count()
        ];
    }

    public function getUnreadnotificationscountAttribute() {
        $query = 
            "SELECT COUNT(DISTINCT JSON_EXTRACT(data, '$.action_type'), JSON_EXTRACT(data, '$.resource_id')) as unreadcount 
            FROM notifications 
            WHERE notifiable_type='App\\\Models\\\User' AND notifiable_id=$this->id AND read_at IS NULL";

        return \DB::select($query)[0]->unreadcount;
    }

    public function adminstatus() {
        $data = [];
        $status = cache('admin-status-for-user-'.$this->id);
        switch($status) {
            case 'away':
                $data['name'] = 'Away';
                $data['icon'] = '<path d="M100,3a97,97,0,1,0,97,97A97,97,0,0,0,100,3Z" style="fill:#f0ed0f"/>';
                break;
            case 'busy':
                $data['name'] = 'Busy';
                $data['icon'] = '<path d="M197,88.51c0-.36,0-.72-.05-1.08-.22-.76-.4-1.55-.55-2.35-1.75-4.22-2-8.88-3.37-13.23C179.36,28.49,135.38-.64,91.17,4.57c-47.5,5.6-84.28,43.56-87,89.79-2.77,47.09,28.11,89.29,73.34,100.48,2,.5,4.31.4,6.22,1.34.48.09.94.2,1.41.31a26.65,26.65,0,0,1,4.45.63c.88.07,1.75.16,2.6.31l.45,0a26.79,26.79,0,0,1,3.61.26h8.23a17.84,17.84,0,0,1,3-.26,19.87,19.87,0,0,1,3.17-.47,19.26,19.26,0,0,1,4.33-.75,14,14,0,0,1,4.36-.49,18.62,18.62,0,0,1,3-.44C160.51,185,184.75,161,195,122.66c.42-1.55.11-3.49.87-5a19.94,19.94,0,0,1,.83-7.4,20,20,0,0,1,.78-4.78v-14A27.7,27.7,0,0,1,197,88.51Zm-60.86,44.15c-7.73,8.59-21,15.65-32.81,15.65-13.09,0-24.26-3.87-34.27-12.14-9.76-8.06-14.46-20.57-15.65-32.81-1.15-11.79,4.34-25.61,12.14-34.27s21-15.65,32.81-15.65c13.09,0,24.26,3.87,34.27,12.14,9.76,8.06,14.46,20.57,15.65,32.81C149.46,110.18,144,124,136.17,132.66Z" style="fill:#ff6969;"/>';
                break;
            case 'appear-offline':
                $data['name'] = 'Appear offline';
                $data['icon'] = '<path d="M197,88.51c0-.36,0-.72-.05-1.08-.22-.76-.4-1.55-.55-2.35-1.75-4.22-2-8.88-3.37-13.23C179.36,28.49,135.38-.64,91.17,4.57c-47.5,5.6-84.28,43.56-87,89.79-2.77,47.09,28.11,89.29,73.34,100.48,2,.5,4.31.4,6.22,1.34.48.09.94.2,1.41.31a26.65,26.65,0,0,1,4.45.63c.88.07,1.75.16,2.6.31l.45,0a26.79,26.79,0,0,1,3.61.26h8.23a17.84,17.84,0,0,1,3-.26,19.87,19.87,0,0,1,3.17-.47,19.26,19.26,0,0,1,4.33-.75,14,14,0,0,1,4.36-.49,18.62,18.62,0,0,1,3-.44C160.51,185,184.75,161,195,122.66c.42-1.55.11-3.49.87-5a19.94,19.94,0,0,1,.83-7.4,20,20,0,0,1,.78-4.78v-14A27.7,27.7,0,0,1,197,88.51Zm-60.86,44.15c-7.73,8.59-21,15.65-32.81,15.65-13.09,0-24.26-3.87-34.27-12.14-9.76-8.06-14.46-20.57-15.65-32.81-1.15-11.79,4.34-25.61,12.14-34.27s21-15.65,32.81-15.65c13.09,0,24.26,3.87,34.27,12.14,9.76,8.06,14.46,20.57,15.65,32.81C149.46,110.18,144,124,136.17,132.66Z" style="fill:#aaa;"/>';
                break;
            default :
                $data['name'] = 'Online';
                $data['icon'] = '<path d="M100,3a97,97,0,1,0,97,97A97,97,0,0,0,100,3Z" style="fill:#44ee6e"/>';
                break;
        }

        return $data;
    }

    public function getLightusernameAttribute() {
        return strlen($this->username) > 14 ? substr($this->username, 0, 14) . '..' : $this->username;
    }

    public function getMinifiedNameAttribute() {
        return strlen($fullname=($this->firstname . ' ' . $this->lastname)) > 20
            ? strlen($username=$this->username) > 14 ? substr($fullname, 0, 19) . '..': $username
            : $fullname;
    }

    public function getFullnameAttribute() {
        return $this->firstname . " " . $this->lastname;
    }

    public function getProfilelinkAttribute() {
        return route('user.profile', ['user'=>$this->username]);
    }

    public function getAboutminAttribute() {
        return strlen($about=($this->about)) > 100 ? substr($about, 0, 100) . '..' : $about;
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'user.'.$this->id.'.notifications';
    }

    public function allowed_to_add_option_on_thread_poll($thread, $poll, $data=[]) {
        if($this->id == $thread->user_id) return true;
        /**
         * $data parameter is used to increase performence by checking if the optionscount was
         * already fetched so we use it instead of running query again to fetch options count
         */
        $optionscount = isset($data['optionscount']) 
            ? $data['optionscount']
            : $poll->options()->count();
        $useroptionscount = isset($data['useroptions']) 
            ? $data['useroptions'] 
            : $poll->options()->where('user_id', $this->id)->count();

        if($optionscount >= 30) return false;
        
        if($poll->allow_options_add)
            return $useroptionscount < $poll->options_add_limit;
        else
            return false;
    }

    public static function mixusersnames($users) {
        $mix = $users[0]->username;
        if(count($users) > 1)
            if(count($users) == 2)
                $mix .= ' ' . __('and') . ' ' . $users[1]->username;
            else {
                $others = count($users) - 2;
                $mix .= ', ' . $users[1]->username . ' ' . __('and') . ' ' . $others . ' ' . (($others > 1) ? __('others') : __('other'));
            }

        return $mix;
    }

    public static function defaultavatar($size, $quality="-h") {
        return asset("users/defaults/medias/avatars/" . $size . $quality . ".png");
    }
}

