<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Markdown;
use Carbon\Carbon;
use App\Models\{Thread, Vote, Like, User, Warning, Striken, PostStatus};
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ExcludeDeactivatedUserData;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function status() {
        return $this->belongsTo(PostStatus::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
    }

    public function votes() {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function likes() {
        return $this->morphMany(Like::class, 'likable');
    }

    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function warnings() {
        return $this->morphMany(Warning::class, 'resource');
    }

    public function strikes() {
        return $this->morphMany(Strike::class, 'resource');
    }

    public static function top_today_poster() {
        $topposter = \DB::table('posts')
        ->where('created_at', '>', today())
        ->select(\DB::raw('count(*) as posts, user_id'))
        ->groupBy('user_id')
        ->orderBy('posts', 'desc')
        ->first();

        if(!is_null($topposter))
            return User::find($topposter->user_id);

        return false;
    }

    public function liked_by($user) {
        return $this::likes()
                ->where('user_id', $user->id)
                ->count() > 0;
    }

    public function voted() {
        if($user=auth()->user()) {
            $vote = $this->votes()
                ->where('user_id', $user->id)
                ->first();
            
            if(!is_null($vote))
                return $vote->vote;
                
            return false;
        }
        return false;
    }

    public function getVotevalueAttribute() {
        return $this->votes()->sum('vote');
    }

    public function getIsUpdatedAttribute() {
        return $this->created_at != $this->updated_at;
    }

    public function getAlreadyReportedAttribute() {
        if($currentuser = auth()->user())
            return $currentuser->reportings()->where('reportable_id', $this->id)->where('reportable_type', 'App\Models\Post')->count() > 0;

        return false;
    }

    public function getLikedandlikescountAttribute() {
        if($currentuser=auth()->user())
            $query = "SELECT COUNT(*) as likescount, SUM(user_id = $currentuser->id) AS liked FROM likes WHERE likable_id=? AND likable_type=?";
        else
            $query = "SELECT COUNT(*) as likescount, 0 AS liked FROM likes WHERE likable_id=? AND likable_type=?";


        $result = \DB::select($query, [$this->id, 'App\Models\Post']);
        return [
            'liked'=>$result[0]->liked,
            'count'=>$result[0]->likescount
        ];
    }

    function getVotedandvotescountAttribute() {
        if($currentuser=auth()->user())
            $query = "SELECT COALESCE(SUM(vote),0) as votevalue, SUM(user_id = $currentuser->id) as voted, IF(user_id = $currentuser->id, vote, 0) as uservote
            FROM votes 
            WHERE votable_id=? AND votable_type=?";
        else
            $query = "SELECT COALESCE(SUM(vote),0) as votevalue, 0 as voted, 0 as uservote FROM votes WHERE votable_id=? AND votable_type=?";

        $result = \DB::select($query, [$this->id, 'App\Models\Post']);
        return [
            'votevalue'=>$result[0]->votevalue,
            'voted'=>$result[0]->voted,
            'uservote'=>$result[0]->uservote,
        ];
    }

    public function upvoted($uid) {
        return (bool) $this->votes()->where('user_id', $uid)->where('vote', 1)->count();
    }

    public function downvoted($uid) {
        return (bool) $this->votes()->where('user_id', $uid)->where('vote', -1)->count();
    }

    public function getSliceAttribute() {
        return strlen($this->content) > 30 ? substr($this->content, 0, 30) . '..' : $this->content;
    }

    public function getMediumcontentsliceAttribute() {
        return strlen($this->content) > 400 ? substr($this->content, 0, 400) . '..' : $this->content;
    }

    public function getContentsliceAttribute() {
        return strlen($this->content) > 100 ? substr($this->content, 0, 100) . '..' : $this->content;
    }

    public function getLinkAttribute() {
        return $this->thread->link . "#" . $this->id;
    }
    
    public function getParsedContentAttribute() {
        return Markdown::parse($this->content);
    }

    public function getPostedatAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getAthummansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getCreationDateHumansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getCreationDateAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public function getUpdateDateHumansAttribute() {
        return (new Carbon($this->updated_at))->diffForHumans();
    }

    public function getUpdateDateAttribute() {
        return (new Carbon($this->updated_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($post) {
            if($post->isForceDeleting()) {
                $post->votes()->delete();
                $post->likes()->delete();
                $post->reports()->delete();
            }
        });
    }

    protected static function booted() {
        static::addGlobalScope(new ExcludeDeactivatedUserData);
    }
}
