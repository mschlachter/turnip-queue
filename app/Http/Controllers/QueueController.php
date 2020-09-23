<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TurnipQueue;
use App\TurnipSeeker;
use App\Events\SeekerBooted;
use Str;
use Auth;

class QueueController extends Controller
{
    /**
     * Show the queue search form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('queue.find');
    }

    /**
     * Search for a queue based on the token.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search()
    {
        request()->validate([
            'token' => 'required|exists:turnip_queues,token',
        ]);

        $turnipQueue = TurnipQueue::where('token', request('token'))->first();

        return redirect(route('queue.join', compact('turnipQueue')));
    }

    /**
     * Join a Turnip Queue
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function join(TurnipQueue $turnipQueue)
    {
        // Check whether the Queue is still open
        if (!$turnipQueue->is_open) {
            abort(404);
        }

        // Check whether they're already in the queue:
        $seekerToken = session('queue-' . $turnipQueue->token . '|seekerToken', null);

        if ($seekerToken !== null &&
            ($turnipSeeker = $turnipQueue->turnipSeekers()->where('token', $seekerToken)->first()) &&
            !$turnipSeeker->left_queue
        ) {
            // Token exists on request (and they're still active)

            // Update the ping time
            $turnipSeeker->update(['last_ping' => now()]);

            // Get their current position in the queue
            $position = $turnipQueue->turnipSeekers()
            ->where('left_queue', false)
            ->where('id', '<', $turnipSeeker->id)
            ->count()
                // Adjusts for the visitors already shown the code
            - $turnipQueue->concurrent_visitors + 1;

            // Show them their place in the queue
            return view('queue.status', compact('turnipQueue', 'turnipSeeker', 'position'));
        }

        return view('queue.join', compact('turnipQueue'));
    }

    public function getSeekerStatus(TurnipQueue $turnipQueue)
    {
        // Get their token from the session
        $seekerToken = session('queue-' . $turnipQueue->token . '|seekerToken', null);

        // Check whether the queue is open
        if ($seekerToken === null || !$turnipQueue->is_open) {
            return [
                'status' => 'closed',
            ];
        }

        // Check whether they're in the queue
        $turnipSeeker = $turnipQueue->turnipSeekers()->where('token', $seekerToken)->first();

        if ($turnipSeeker === null || $turnipSeeker->left_queue) {
            return [
                'status' => 'booted',
            ];
        }

        // Token exists on request (and they're still active)

        // Update the ping time
        $turnipSeeker->update(['last_ping' => now()]);

        // Get their current position in the queue
        $position = $turnipQueue->turnipSeekers()
        ->where('left_queue', false)
        ->where('id', '<', $turnipSeeker->id)
        ->count()
            // Adjusts for the visitors already shown the code
        - $turnipQueue->concurrent_visitors + 1;

        return [
            'status' => 'active',
            'position' => $position,
            'dodoCode' => $position > 0 ? null : $turnipQueue->dodo_code,
            'newExpiry' => $turnipQueue->expires_at->toISOString(),
            'messages' => $turnipQueue->turnipQueueMessages()
            ->orderByDesc('sent_at')
            ->get()
            ->map(function($message) {
                return [
                    'sent_at' => $message->sent_at->toISOString(),
                    'message' => $message->message,
                ];
            }),
        ];
    }

    public function ping(TurnipQueue $turnipQueue)
    {
        // Check whether they're already in the queue:
        $seekerToken = session('queue-' . $turnipQueue->token . '|seekerToken', null);

        if ($seekerToken !== null &&
            ($turnipSeeker = $turnipQueue->turnipSeekers()->where('token', $seekerToken)->first()) &&
            !$turnipSeeker->left_queue
        ) {
            // Token exists on request (and they're still active)
            // Update the ping time
            $turnipSeeker->update(['last_ping' => now()]);
            return ['success' => true];
        }
        return ['success' => false];
    }

    public function register(TurnipQueue $turnipQueue)
    {
        // Rules for reddit usernames come from
        // https://github.com/reddit-archive/reddit/blob/master/r2/r2/lib/validator/validator.py#L1567

        $validated = request()->validate([
            'reddit-username' => 'required|string|min:3|max:20|regex:/^[\w-]+$/',
            'in-game-username' => 'required|string|max:20',
            'island-name' => 'required|string|max:10',
            'custom-answer' => 'required|string|max:255',
        ]);

        // Generate a token
        do {
            $token = (string) Str::uuid();
        } while (TurnipQueue::where("token", "=", $token)->first() instanceof TurnipQueue);

        TurnipSeeker::create([
            'turnip_queue_id' => $turnipQueue->id,
            'reddit_username' => $validated['reddit-username'],
            'in_game_username' => $validated['in-game-username'],
            'island_name' => $validated['island-name'],
            'custom_answer' => $validated['custom-answer'],
            'token' => $token,
            'joined_queue' => now(),
            'last_ping' => now(),
            'left_queue' => false,
        ]);

        session()->put('queue-' . $turnipQueue->token . '|seekerToken', $token);

        return redirect(route('queue.join', compact('turnipQueue')));
    }

    public function leave(TurnipQueue $turnipQueue)
    {
        // Check whether they're already in the queue:
        $seekerToken = session('queue-' . $turnipQueue->token . '|seekerToken', null);

        if ($seekerToken !== null &&
            ($turnipSeeker = $turnipQueue->turnipSeekers()->where('token', $seekerToken)->first()) &&
            !$turnipSeeker->left_queue
        ) {
            // Token exists on request (and they're still active)
            // Update the ping time
            $turnipSeeker->update(['left_queue' => true]);
        }

        return redirect(route('queue.join', compact('turnipQueue')))->withStatus('You have left the Turnip Queue.');
    }

    /**
     * Show the create queue page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('queue.create');
    }

    /**
     * Save a new Queue.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store()
    {
        $validated = request()->validate([
            'dodo-code' => 'required|string|min:4|max:6|regex:/^[0-9A-HJ-NP-Y]+$/i',
            'duration' => 'required|integer|min:1|max:5',
            'visitors' => 'required|integer|min:1|max:10',
            'custom-question' => 'required|string|max:255',
        ], [], [
            'dodo-code' => 'Dodo Code',
            'duration' => 'time to keep open',
            'visitors' => 'visitors to allow at a time',
            'custom-question' => 'custom question',
        ]);

        // Close any open queues the user has
        Auth::user()->turnipQueues()->open()->get()->each(function ($queue) {
            $queue->update([
                'is_open' => false,
            ]);
        });

        // Generate a token
        do {
            $token = (string) Str::uuid();
        } while (TurnipQueue::where("token", "=", $token)->first() instanceof TurnipQueue);

        $turnipQueue = TurnipQueue::create([
            'user_id' => Auth::id(),
            'token' => $token,
            'dodo_code' => strtoupper($validated['dodo-code']),
            'expires_at' => now()->addHours($validated['duration']),
            'concurrent_visitors' => $validated['visitors'],
            'custom_question' => $validated['custom-question'],
        ]);

        return redirect(route('queue.admin', compact('turnipQueue')))
        ->withStatus('Your Turnip Queue has been created.');
    }

    /**
     * Administer a Turnip Queue.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin(TurnipQueue $turnipQueue)
    {
        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (!$turnipQueue->is_open) {
            abort(404);
        }

        $turnipQueue = $turnipQueue->load([
            'turnipSeekers' => function ($query) {
                return $query->inQueue();
            }
        ]);

        return view('queue.admin', compact('turnipQueue'));
    }

    /**
     * Update a Queue.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(TurnipQueue $turnipQueue)
    {
        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (!$turnipQueue->is_open) {
            abort(404);
        }

        $validated = request()->validate([
            'dodo-code' => 'required|string|min:4|max:6|regex:/^[0-9A-HJ-NP-Y]+$/i',
            'visitors' => 'required|integer|min:1|max:10',
            'custom-question' => 'required|string|max:255',
        ], [], [
            'dodo-code' => 'Dodo Code',
            'duration' => 'time to keep open',
            'visitors' => 'visitors to allow at a time',
            'custom-question' => 'custom question',
        ]);

        $turnipQueue->update([
            'dodo_code' => strtoupper($validated['dodo-code']),
            'concurrent_visitors' => $validated['visitors'],
            'custom_question' => $validated['custom-question'],
        ]);

        return redirect(route('queue.admin', compact('turnipQueue')))
        ->withStatus('Your Turnip Queue has been updated.');
    }

    /**
     * Close a Turnip Queue.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addHalfHour(TurnipQueue $turnipQueue)
    {
        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (!$turnipQueue->is_open) {
            abort(404);
        }

        $turnipQueue->update([
            'expires_at' => $turnipQueue->expires_at->addMinutes(30),
        ]);

        return back();
    }

    /**
     * Close a Turnip Queue.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close(TurnipQueue $turnipQueue)
    {
        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (!$turnipQueue->is_open) {
            abort(404);
        }

        // We have an observer to kick seekers out of the queue
        $turnipQueue->update([
            'is_open' => false,
        ]);

        return redirect(route('queue.create'))
        ->withStatus('Your Turnip Queue has been closed.');
    }

    public function bootSeeker()
    {
        $turnipQueue = TurnipQueue::where('token', request('queue-token'))->firstOrFail();
        $turnipSeeker = $turnipQueue->turnipSeekers()
        ->where('token', request('seeker-token'))
        ->firstOrFail();

        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (!$turnipQueue->is_open) {
            abort(404);
        }

        if (!$turnipSeeker->left_queue
        ) {
            // Remove them from the queue
            $turnipSeeker->update(['left_queue' => true]);

            // Let them know they've been booted
            SeekerBooted::dispatch($turnipSeeker);
        }

        return back();
    }
}
