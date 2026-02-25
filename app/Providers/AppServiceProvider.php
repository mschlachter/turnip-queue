<?php

namespace App\Providers;

use App\Observers\SiteNotificationObserver;
use App\Observers\TurnipQueueMessageObserver;
use App\Observers\TurnipQueueObserver;
use App\Observers\TurnipSeekerObserver;
use App\SiteNotification;
use App\TurnipQueue;
use App\TurnipQueueMessage;
use App\TurnipSeeker;
use Illuminate\Support\ServiceProvider;

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
        TurnipQueue::observe(TurnipQueueObserver::class);
        TurnipSeeker::observe(TurnipSeekerObserver::class);
        TurnipQueueMessage::observe(TurnipQueueMessageObserver::class);
        SiteNotification::observe(SiteNotificationObserver::class);
    }
}
