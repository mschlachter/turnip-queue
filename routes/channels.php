<?php

use Illuminate\Support\Facades\Broadcast;
use App\TurnipQueue;

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

	if($turnipQueue === null) {
		return false;
	}

    return (int) $user->id === (int) $turnipQueue->user_id;
});

Broadcast::channel('App.TurnipSeeker.{token}', function ($token) {
	// I guess the authorization here is... 'does the user have the token?'?
    return true;
});
