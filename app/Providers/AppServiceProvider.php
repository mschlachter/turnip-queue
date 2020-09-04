<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TurnipQueue;
use App\TurnipSeeker;
use App\Observers\TurnipQueueObserver;
use App\Observers\TurnipSeekerObserver;

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
    }
}
