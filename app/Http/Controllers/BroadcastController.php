<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Broadcasting\BroadcastController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class BroadcastController extends BaseController
{
    /**
     * Authenticate the request for channel access.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        // Give temporary guest account for authenticating to seeker private channel
        if ($request->user() === null) {
            Auth::login(factory(User::class)->make([
                'id' => (int) str_replace('.', '', microtime(true)),
            ]));
        }

        return Broadcast::auth($request);
    }
}
