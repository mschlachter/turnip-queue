<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Broadcasting\BroadcastController as BaseController;
use App\Http\Controllers\BroadcastController;

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
