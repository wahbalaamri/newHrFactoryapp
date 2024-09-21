<?php

namespace App\Providers;

use App\Http\services\Calculate3hResults;
use App\Http\services\LandingService;
use App\Http\services\TempURLServices;
use App\Http\services\UserSubscriptionsService;
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
        // register Calculate3hResults Facade
        $this->app->singleton('Calculate3hResults', function () {
            return new Calculate3hResults();
        });
        // register UserSubscriptions Facade
        $this->app->singleton('UserSubscriptions', function () {
            return new UserSubscriptionsService();
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
