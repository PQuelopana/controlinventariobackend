<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

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
        Config::set('global.dataErrorRequest.message', trans('validation.requestFailed'));
        Config::set('global.dataErrorAuth.message', trans('auth.failed'));
        Config::set('global.dataErrorNotFound.message', trans('messages.notFound'));
    }
}
