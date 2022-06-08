<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ForumStatus, Category, Thread, Post, Vote, Like};
use App\Scopes\ExcludeUnderReviewForums;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected static function booted() {
        static::addGlobalScope(new ExcludeUnderReviewForums);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function threads() {
        return $this->hasManyThrough(Thread::class, Category::class)->withoutGlobalScopes();
    }

    public function posts() {
        return $this->hasManyDeep(Post::class, [Category::class, Thread::class])->withoutGlobalScopes();
    }

    public function status() {
        return $this->belongsTo(ForumStatus::class);
    }

    public function threadsvotes() {
        return $this->hasManyDeep(
            Vote::class, 
            [Category::class, Thread::class], 
            ['forum_id', 'category_id', 'votable_id']
        );
    }

    public function threadslikes() {
        return $this->hasManyDeep(
            Like::class, 
            [Category::class, Thread::class], 
            ['forum_id', 'category_id', 'likable_id']
        );
    }

    public function postsvotes() {
        return $this->hasManyDeep(
            Vote::class, 
            [Category::class, Thread::class, Post::class], 
            ['forum_id', 'category_id', 'thread_id', 'votable_id']
        );
    }

    public function postslikes() {
        return $this->hasManyDeep(
            Like::class, 
            [Category::class, Thread::class, Post::class], 
            ['forum_id', 'category_id', 'thread_id', 'likable_id']
        );
    }

    public function getDescriptionmediumsliceAttribute() {
        return strlen($this->description) > 350 ? substr($this->description, 0, 350) . '..' : $this->description;
    }

    public function getDescriptionSliceAttribute() {
        return strlen($this->description) > 160 ? substr($this->description, 0, 160) . '..' : $this->description;
    }

    public function getHasAnnouncementsCategoryAttribute() {
        return $this->categories()->withoutGlobalScopes()->where('slug', 'announcements')->count() > 0;
    }

    public function getHasAtLeastOneCategoryAttribute() { // At least one category other than announcements category
        return (bool) $this->categories()->withoutGlobalScopes()->excludeannouncements()->count();
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

    // Local Scopes
    public function scopeExcludearchived($builder) {
        return $builder->where('status_id', '<>', ForumStatus::where('slug', 'archived')->first()->id);
    }

    public function scopeExcludeunderreview($builder) {
        return $builder->where('status_id', '<>', ForumStatus::where('slug', 'under-review')->first()->id);
    }
}
