<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class FollowersOnlyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        /**
         * 1. Exclude followers-only thyread for guest users
         * 2. For authenticated users, we have 2 conditions :
         *      2.1. Either exclude the followers-only threads from thread list if the user is a guest
         *      2.2. Or if the user is authenticated we get everything except followers-only threads, or we get
         *           followers-only thread if the thread owner is the same as authenticated user, OR if the current user
         *           is one of the thread owner followers.
         *           (we check the last condition by getting the current user followed users and search if the thread owner
         *            is there with the followed users; If so we show the thread otherwise the current user is not a follower
         *            for the thread owner so we don't have to show it.
         *            )
         */
        
        $followers_only_visibility_id = Cache::rememberForever('followers_only_visibility_id', function () {
            return DB::select("SELECT id FROM thread_visibility WHERE slug = 'followers-only'")[0]->id;
        });
        
        if(!Auth::check()) {
            $builder->where('visibility_id', '<>', $followers_only_visibility_id);
        } else {
            $builder->where('visibility_id', '<>', $followers_only_visibility_id)
            ->orWhere(function($query) {
                $query->where('threads.user_id', auth()->user()->id) // where the thread owner is the same as logged in user : this case the user could see the thread
                ->orWhereIn('threads.user_id', 
                    \DB::table('follows') // This query get followers ids
                    ->select('followable_id')
                    ->where('follower', auth()->user()->id)
                    ->pluck('followable_id')
                );
            });
        }
    }
}