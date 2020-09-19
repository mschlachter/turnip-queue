<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Broadcasting\BroadcastController as BaseController;
use Auth;
use App\User;

class BroadcastController extends BaseController
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Illuminate\Http\Request  $request
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
                'id' => (int)str_replace('.', '', microtime(true))
            ]));
        }

        return Broadcast::auth($request);
    }
}
