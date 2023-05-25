<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        // https
        if (\App::environment(['production']) || \App::environment(['develop'])) {
            \URL::forceScheme('https');
        }

        // ページネーション2ページ目以降のhttps化
        $this->app['request']->server->set('HTTPS','on');
    }
}
