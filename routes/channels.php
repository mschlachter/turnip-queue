<?php

use Illuminate\Support\Facades\Broadcast;
use App\TurnipQueue;
use App\TurnipSeeker;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.TurnipQueue.{token}', function ($user, $token) {
    $turnipQueue = TurnipQueue::where('token', $token)->first();

    if ($turnipQueue === null) {
        return false;
    }

    return (int) $user->id === (int) $turnipQueue->user_id;
});

Broadcast::channel('App.TurnipSeeker.{token}', function ($user, $token) {
    $turnipSeeker = TurnipSeeker::where('token', $token)->first();
    if ($turnipSeeker === null || $turnipSeeker->left_queue) {
        return false;
    }

    // Authentication scheme is: does request token match session token?
    $seekerToken = session('queue-' . $turnipSeeker->turnipQueue->token . '|seekerToken', null);
    return $seekerToken === $token;
});
