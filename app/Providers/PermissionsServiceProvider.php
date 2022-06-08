<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Registering gates
        Gate::define('update.permissions', function (User $user) {
            return $user->has_role('admin');
        });

        Gate::define('role.permission.attach', function (User $user) {
            return $user->has_role('admin');
        });

        Gate::define('role.permission.detach', function (User $user) {
            return $user->has_role('admin');
        });

        Gate::define('add.category', function (User $user) {
            return $user->has_role('admin');
        });

        Gate::define('update.category', function (User $user) {
            return $user->has_role('admin');
        });

        Gate::define('delete.category', function (User $user) {
            return $user->has_role('admin');
        });
    }
}
