<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cache;
use App\Models\AccountStatus;

class ExcludeDeactivatedUserData implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $deactivated_account_status_id = Cache::rememberForever('deactivated_account_status_id', function () {
            return AccountStatus::where('slug', 'deactivated')->first()->id;
        });

        // Only show private threads owned by the current user
        $builder->whereHas('user', function ($query) use ($deactivated_account_status_id) {
            $query->where('account_status', '<>', $deactivated_account_status_id);
        });
    }
}