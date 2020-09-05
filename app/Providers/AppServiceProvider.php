<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TurnipQueue;
use App\TurnipSeeker;
use App\TurnipQueueMessage;
use App\Observers\TurnipQueueObserver;
use App\Observers\TurnipSeekerObserver;
use App\Observers\TurnipQueueMessageObserver;

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
    }
}
