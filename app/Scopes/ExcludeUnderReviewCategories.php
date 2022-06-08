<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cache;
use App\Models\CategoryStatus;

class ExcludeUnderReviewCategories implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $under_review_category_status_id = Cache::rememberForever('under_review_category_status_id', function () {
            return CategoryStatus::where('slug', 'under-review')->first()->id;
        });

        $builder->where('status_id', '<>', $under_review_category_status_id);
    }
}