<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cache;
use App\Models\AccountStatus;

class ExcludeDeactivatedUser implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $deactivated_account_status_id = Cache::rememberForever('deactivated_account_status_id', function () {
            return AccountStatus::where('slug', 'deactivated')->first()->id;
        });

        $builder->where('account_status', '<>', $deactivated_account_status_id);
    }
}