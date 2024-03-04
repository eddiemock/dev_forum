<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class IBMWatsonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
{
    $this->app->singleton(\App\Services\IBMWatsonNLUService::class, function ($app) {
        return new \App\Services\IBMWatsonNLUService();
    });
}


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
