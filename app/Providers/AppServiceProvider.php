<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\{EmojiFeedback, Feedback, Vote};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Model::preventLazyLoading(! app()->isProduction());

        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.simple-default');
        Blade::if('canemoji', function () {
            $ip = request()->ip();
            if(Auth::check()) {
                return EmojiFeedback::where('user_id', Auth::id())->where('created_at', '>', today())->count() == 0;
            } else {
                return EmojiFeedback::where('ip', $ip)->where('created_at', '>', today())->count() == 0;
            }
        });
        Blade::if('cansendfeedback', function () {
            $ip = request()->ip();
            if(Auth::check()) {
                return Feedback::today()->where('user_id', Auth::id())->count() < 2;
            } else {
                return Feedback::today()->where('ip', $ip)->count() < 2;
            }
        });
        Blade::if('upvoted', function ($resource, $type) {
            if($user=auth()->user()) {
                return $resource->votes()
                        ->where('vote', '1')
                        ->where('user_id', $user->id)
                        ->count() > 0;
            } else {
                return false;
            }
        });
        Blade::if('downvoted', function ($resource, $type) {
            if($user=auth()->user()) {
                return $resource->votes()
                    ->where('vote', '-1')
                    ->where('user_id', $user->id)
                    ->count() > 0;
            } else {
                return false;
            }
        });

        if (($lang = Cookie::get('lang')) !== null) {
            App::setLocale($lang);
        }
        setlocale(LC_TIME, $lang.'.utf8');

        Schema::defaultStringLength(191);
    }
}
