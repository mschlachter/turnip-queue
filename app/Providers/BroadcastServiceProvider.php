<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Auth;
use App\User;
use Route;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        // Give temporary guest account for authenticating to seeker private channel
        if(Auth::user() === null && request()->is('broadcasting/auth')) {
            Auth::login(factory(User::class)->make([
                'id' => (int)str_replace('.', '', microtime(true))
            ]));
        }

        require base_path('routes/channels.php');
    }

    private function ends_with($haystack,$needle,$case=true)
    {
        $expectedPosition = strlen($haystack) - strlen($needle);

        if ($case)
            return strrpos($haystack, $needle, 0) === $expectedPosition;

        return strripos($haystack, $needle, 0) === $expectedPosition;
    }
}
