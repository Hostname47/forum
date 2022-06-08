<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Models\Category;

class ExcludeAnnouncements implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('category', function ($query) {
            $query->where('slug', '<>', 'announcements');
        });
    }
}