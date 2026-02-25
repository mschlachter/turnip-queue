<?php

namespace App\Providers;

use App\Http\Controllers\BroadcastController;
use Illuminate\Broadcasting\BroadcastController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        app()->bind(BaseController::class, BroadcastController::class);

        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
