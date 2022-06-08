<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Scopes\{ExcludePrivateScope, FollowersOnlyScope, ExcludeDeactivatedUserData, ExcludeAnnouncements};
use App\Models\{User, Post, Category, Forum, Vote, ThreadStatus, ThreadVisibility, Like, 
    Report, Notification, NotificationDisable, SavedThread, Poll, ThreadClose, Warning, Strike};

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $with = ['category.forum', 'visibility', 'status', 'user.status'];

    public static function boot() {
        parent::boot();

        /**
         * Before deleting the thread, we need to clear everything related to this thread
         */
        static::deleting(function($thread) {
            if($thread->isForceDeleting()) {
                // Delete associated votes & likes
                $thread->votes()->delete();
                $thread->likes()->delete();
                
                // saved threads : handled (on delete cascade)
                // poll, options and optionsvotes : in case the thread is poll; handled (on delete cascade)
                // threadcloses : handled (on delete cascade)
                // posts (replies) : handled (on delete cascade)
                
                /**
                 * Notice that when posts get deleted (by cascading), it will not delete their related models (non-direct related relationships)
                 * we have to delete all their relationships manually
                 */
                \DB::statement(
                    "DELETE votes FROM votes INNER JOIN posts
                    ON votes.votable_id=posts.id
                    WHERE `votable_type`='App\\\Models\\\Post' AND posts.thread_id=$thread->id"
                );
                \DB::statement(
                    "DELETE likes FROM likes INNER JOIN posts
                    ON likes.likable_id=posts.id
                    WHERE `likable_type`='App\\\Models\\\Post' AND posts.thread_id=$thread->id"
                );
                \DB::statement(
                    "DELETE reports FROM reports INNER JOIN posts
                    ON reports.reportable_id=posts.id
                    WHERE `reportable_type`='App\\\Models\\\Post' AND posts.thread_id=$thread->id"
                );

                /**
                 * Notice that the following resources are not directly related to thread (morph relationship)
                 * so they cannot be deleted using cascading; we have to delete them manually
                 * 
                 * We will not remove related warnings and strikes
                 */
                $thread->reports()->delete();
                // $thread->warnings()->delete();
                // $thread->strikes()->delete();

                // Delete all the notifications for this thread - Every event that has a relation to that thread, should has source_type and source_id (e.g 'thread', 200)
                Notification::where('data->options->source_type', 'thread')->where('data->options->source_id', $thread->id)->delete();
                
                // Delete thread disables related to this thread
                NotificationDisable::where('source_id', $thread->id)->where('source_type', 'App\\Models\\Thread')->delete();
                
                // Delete thread medias directory along with all medias if exists
                $mediasdirectory = storage_path("app/public/users/$thread->user_id/threads/$thread->id/medias");
                (new \Illuminate\Filesystem\Filesystem)->cleanDirectory($mediasdirectory);
            }
        });
    }

    protected static function booted() {
        static::addGlobalScope(new ExcludePrivateScope);
        static::addGlobalScope(new FollowersOnlyScope);
        static::addGlobalScope(new ExcludeDeactivatedUserData);
        static::addGlobalScope(new ExcludeAnnouncements);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class)->withoutGlobalScopes();
    }

    public function getForumAttribute() {
        return $this->category->forum;
    }

    public function threadclose() {
        return $this->hasOne(ThreadClose::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function users_who_save() {
        return $this->belongsToMany(User::class, 'saved_threads', 'thread_id', 'user_id');
    }

    public function status() {
        return $this->belongsTo(ThreadStatus::class);
    }

    public function visibility() {
        return $this->belongsTo(ThreadVisibility::class);
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

    public function warnings() {
        return $this->morphMany(Warning::class, 'resource');
    }

    public function strikes() {
        return $this->morphMany(Strike::class, 'resource');
    }

    public function poll() {
        return $this->hasOne(Poll::class);
    }

    public function getAlreadyReportedAttribute() {
        if($currentuser = auth()->user())
            return $currentuser->reportings()->where('reportable_id', $this->id)->where('reportable_type', 'App\Models\Thread')->count() > 0;

        return false;
    }

    public function getLikedAttribute() {
        if($current_user = auth()->user()) {
            return $this->likes()
                ->where('user_id', $current_user->id)
                ->count();
        }
        return false;
    }

    public function foo() {
        $thread_likes = 
        \DB::table('likes')
            ->where('likable_id', $this->id)->where('likable_type', 'App\Models\Thread')
            ->where('user_id', auth()->user()->id)
            ->count();
        return $thread_likes;
    }

    public function getLikedandlikescountAttribute() {
        /**
         * I was getting likes count as well as whether the current user liked or not by running query
         * to fetch all users who liked the thread; Then use the result array to get count (by getting array length)
         * and whether user liked it or not by searching in the array. AND THIS IS RIDICULOUS
         * 
         * The following query does all the above tasks (in one single query)
         */
        if($currentuser=auth()->user())
            $query = "SELECT COUNT(*) as likescount, SUM(user_id = $currentuser->id) AS liked FROM likes WHERE likable_id=? AND likable_type=?";
        else
            $query = "SELECT COUNT(*) as likescount, 0 AS liked FROM likes WHERE likable_id=? AND likable_type=?";


        $result = \DB::select($query, [$this->id, 'App\Models\Thread']);
        return [
            'liked'=>$result[0]->liked,
            'count'=>$result[0]->likescount
        ];
    }

    public function getVotedandvotescountAttribute() {
        if($currentuser=auth()->user())
            $query = "SELECT COALESCE(SUM(vote),0) as votevalue, SUM(user_id = $currentuser->id) as voted, IF(user_id = $currentuser->id, vote, 0) as uservote
            FROM votes 
            WHERE votable_id=? AND votable_type=?";
        else
            $query = "SELECT COALESCE(SUM(vote),0) as votevalue, 0 as voted, 0 as uservote FROM votes WHERE votable_id=? AND votable_type=?";

        $result = \DB::select($query, [$this->id, 'App\Models\Thread']);
        return [
            'votevalue'=>$result[0]->votevalue,
            'voted'=>$result[0]->voted,
            'uservote'=>$result[0]->uservote,
        ];
    }

    public function liked_by($user) {
            return $this::likes()
                    ->where('user_id', $user->id)
                    ->count() > 0;
    }

    public function voted_by($user, $vote) {
        $vote = ($vote == 'up') ? 1 : -1;
        return Vote::where('vote', $vote)
                ->where('user_id', $user->id)
                ->where('votable_id', $this->id)
                ->where('votable_type', 'App\Models\Thread')
                ->count();
    }

    public function voted() {
        if($user=auth()->user()) {
            $vote = $this->votes()->where('user_id', $user->id)->first();
            if(!is_null($vote))
                return $vote->vote;

            return false;
        }
        return false;
    }

    public function getUpvotesAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '-1')
            $count -= 1;
        }

        return $count;
    }

    public function getDownvotesAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '1')
            $count += 1;
        }

        return $count;
    }

    public function getVotevalueAttribute() {
        return $this->votes()->sum('vote');
    }

    public function getVoteCountAttribute() {
        return $this->votes->count();
    }

    public function getUpvoteCountAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '1')
            $count += 1;
        }

        return $count;
    }

    public function getDownvoteCountAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '-1')
            $count += 1;
        }

        return $count;
    }

    public function upvoted($uid) {
        return (bool) $this->votes()->where('user_id', $uid)->where('vote', 1)->count();
    }

    public function downvoted($uid) {
        return (bool) $this->votes()->where('user_id', $uid)->where('vote', -1)->count();
    }

    public function getIsSavedAttribute() {
        if(!auth()->user()) return false;
        return (bool) SavedThread::where('thread_id', $this->id)->where('user_id', auth()->user()->id)->count() > 0;
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function scopeTicked($builder) {
        return $builder->whereHas('posts', function(Builder $post) {
            return $post->where('ticked', 1);
        });
    }

    public function isClosed() {
        return $this->status->slug == 'closed';
    }

    public function tickedPost() {
        return $this->posts()->where('ticked', 1)->first();
    }

    public function isticked() {
        return (bool) \DB::select("SELECT COUNT(*) as ticked FROM posts WHERE thread_id=$this->id AND ticked=1")[0]->ticked;
    }

    public function getHasmediasAttribute() {
        return !empty(\Storage::disk('public')->files('users/' . $this->user_id . '/threads/' . $this->id . '/medias'));
    }

    public function getHasmediatrashAttribute() {
        return !empty(\Storage::disk('public')->files('users/' . $this->user_id . '/threads/' . $this->id . '/trash'));
    }

    public function getPostsandlikescountAttribute() {
        return $this->posts()->withoutGlobalScope(ExcludeDeactivatedUserData::class)->count() + $this->likes()->count();
    }

    public function getSliceAttribute() {
        return strlen($this->subject) > 50 ? substr($this->subject, 0, 50) . '..' : $this->subject;
    }

    public function getMediumsliceAttribute() {
        return strlen($this->subject) > 110 ? substr($this->subject, 0, 110) . '..' : $this->subject;
    }

    public function getContentsliceAttribute() {
        return strlen($this->content) > 80 ? substr($this->content, 0, 80) . '..' : $this->content;
    }

    public function getMediumcontentsliceAttribute() {
        return strlen($this->content) > 400 ? substr($this->content, 0, 400) . '..' : $this->content;
    }

    public function getLinkAttribute() {
        $category = is_null($this->category) 
            ? \DB::select('SELECT * FROM categories WHERE id = ' . $this->category_id)
            : $this->category;
        $forum = is_null($category->forum) 
            ? \DB::select('SELECT * FROM forums WHERE id = ' . $category->forums_id)
            : $category->forum;

        return route('thread.show', ['forum'=>$forum->slug, 'category'=>$category->slug, 'thread'=>$this->id]);
    }

    public function getAnnouncementLinkAttribute() {
        return route('announcement.show', ['forum'=>$this->category->forum->slug, 'announcement'=>$this->id]);
    }

    public function getAthummansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getPostedatAttribute() {
        return (new Carbon($this->created_at))->isoFormat("dddd D MMM YYYY - H:mm A");
    }
}
