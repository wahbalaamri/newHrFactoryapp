<?php

namespace App\Console;

use App\Http\Facades\UserSubscriptionsFacade;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        //everyday at 00:00 check if subscriptions are expired
        $schedule->call(function () {
            $expired=UserSubscriptionsFacade::checkSubscriptions();
            //if $expired is not empty
            if(!empty($expired)){
                // UserSubscriptionsFacade::sendExpiredEmails($expired);
                //deactivate subscriptions
                UserSubscriptionsFacade::deactivateSubscriptions($expired);
            }
        })->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
