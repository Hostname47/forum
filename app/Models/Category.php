<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ExcludeAnnouncementFromCategories;
use App\Models\{User, Forum, Thread, Post, Vote, Like, CategoryStatus};
use App\Scopes\ExcludeUnderReviewCategories;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $table = 'categories';
    protected $guarded = [];

    protected static function booted() {
        static::addGlobalScope(new ExcludeUnderReviewCategories);
    }

    public function forum() {
        return $this->belongsTo(Forum::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function posts() {
        return $this->hasManyThrough(Post::class, Thread::class);
    }

    public function threadsvotes() {
        return $this->hasManyThrough(
            Vote::class, 
            Thread::class,
            'category_id',
            'votable_id',
            'id',
            'id'
        );
    }

    public function postsvotes() {
        return $this->hasManyDeep(
            Vote::class,
            [Thread::class, Post::class],
            ['category_id', 'thread_id', 'votable_id']
        );
    }

    public function threadslikes() {
        return $this->hasManyThrough(
            Like::class, 
            Thread::class,
            'category_id',
            'likable_id',
            'id',
            'id'
        );
    }

    public function postslikes() {
        return $this->hasManyDeep(
            Like::class,
            [Thread::class, Post::class],
            ['category_id', 'thread_id', 'likable_id']
        );
    }

    public function getLinkAttribute() {
        return route('category.threads', ['forum'=>$this->forum->slug, 'category'=>$this->slug]);
    }

    public function status() {
        return $this->belongsTo(CategoryStatus::class, 'status_id');
    }

    public function getDescriptionsliceAttribute() {
        return strlen($this->description) > 140 ? substr($this->description, 0, 140) . '..' : $this->description;
    }

    /**
     * Here we have to exclude announcements from categories using local scopes due to interconnected links between threads
     * and categories. using local scopes require us to add the scope everytime we want to exclude announcements
     */
    public function scopeExcludeannouncements($query) {
        return $query->where('slug', '<>', 'announcements');
    }

    public function statistics($of) {
        switch($of) {
            case 'total-threads-count':
                return $this->threads()->withoutGlobalScopes()->count();
                break;
            case 'total-posts-count':
                return $this->posts()->withoutGlobalScopes()->count();
                break;
            case 'total-threads-votes-count':
                return $this->threadsvotes()->withoutGlobalScopes()->count();
                break;
            case 'total-posts-votes-count':
                return $this->postsvotes()->withoutGlobalScopes()->count();
                break;
        }
    }
}
