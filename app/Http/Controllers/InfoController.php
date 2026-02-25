<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Mail\FormMessage;
use Illuminate\Support\Facades\Mail;

class InfoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the FAQ page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function faq()
    {
        return view('info.faq');
    }

    /**
     * Show the contact form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('info.contact');
    }

    /**
     * Submit the contact form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sendMessage(SendMessageRequest $request)
    {
        $validated = $request->validated();

        Mail::to(config('mail.feedback_recipients'))->queue(new FormMessage($validated['email'], $validated['subject'], $validated['message']));

        return back()->withStatus('Your message has been sent.');
    }
}
