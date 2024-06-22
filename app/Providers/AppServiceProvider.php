<?php

namespace App\Providers;

use App\Http\services\LandingService;
use App\Http\services\TempURLServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register TempURLFacade
        $this->app->singleton('tempurl', function () {
            return new TempURLServices();
        });
        // register Landing Facade
        $this->app->singleton('Landing', function () {
            return new LandingService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
