<?php

namespace App\Http\Controllers;

use App\TurnipQueue;
use App\TurnipQueueMessage;
use Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $turnipQueue = TurnipQueue::where('token', request('queue-token'))->firstOrFail();

        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (! $turnipQueue->is_open) {
            abort(404);
        }

        $validated = request()->validate([
            'message' => 'required|string|max:255',
        ]);

        $turnipQueueMessage = TurnipQueueMessage::create([
            'turnip_queue_id' => $turnipQueue->id,
            'sent_at' => now(),
            'message' => $validated['message'],
        ]);

        if (request()->ajax()) {
            return $turnipQueueMessage;
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TurnipQueueMessage $turnipQueueMessage)
    {
        $turnipQueue = $turnipQueueMessage->turnipQueue;

        if ($turnipQueue->user_id !== Auth::id()) {
            abort(404);
        }
        if (! $turnipQueue->is_open) {
            abort(404);
        }

        $turnipQueueMessage->delete();

        if (request()->ajax()) {
            return [
                'success' => true,
            ];
        }

        return back();
    }
}
