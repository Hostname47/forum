<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\ThreadVisibility;

class ExcludePrivateScope implements Scope
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
        $thread_private_status_id = Cache::rememberForever('thread_private_status_id', function () {
            return ThreadVisibility::where('slug', 'private')->first()->id;
        });

        // Only show private threads owned by the current user
        if(!Auth::check()) {
            $builder->where('visibility_id', '<>', $thread_private_status_id);
        } else {
            $builder->where(function($query) use ($thread_private_status_id) {
                $query->where('visibility_id', '<>', $thread_private_status_id)
                ->orWhere(function($query) use ($thread_private_status_id) {
                    $query->where('visibility_id', $thread_private_status_id)
                    ->where('threads.user_id', auth()->user()->id);
                });
            });
        }
    }
}