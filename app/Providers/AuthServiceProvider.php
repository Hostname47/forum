<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Thread' => 'App\Policies\ThreadPolicy',
        'App\Models\Notification' => 'App\Policies\NotificationPolicy',
        'App\Models\Follow' => 'App\Policies\FollowPolicy',
        'App\Models\FAQ' => 'App\Policies\FaqsPolicy',
        'App\Models\Forum' => 'App\Policies\Admin\ForumPolicy',
        'App\Models\Category' => 'App\Policies\Admin\CategoryPolicy',
        'App\Models\Role' => 'App\Policies\Admin\RolePolicy',
        'App\Models\Permission' => 'App\Policies\Admin\PermissionPolicy',
        'App\Models\Warning' => 'App\Policies\Admin\WarningPolicy',
        'App\Models\Strike' => 'App\Policies\Admin\StrikePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
