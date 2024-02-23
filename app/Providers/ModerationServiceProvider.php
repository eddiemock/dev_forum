<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OpenAiModerationService;

class ModerationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OpenAiModerationService::class, function ($app) {
            return new OpenAiModerationService();
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


   
