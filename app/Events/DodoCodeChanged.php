<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DodoCodeChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $turnipQueue;

    public $newDodoCode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue)
    {
        $this->turnipQueue = $turnipQueue;
        $this->newDodoCode = $turnipQueue->dodo_code;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $seekersToNotify = $this->turnipQueue
            ->turnipSeekers()
            ->inQueue()
            ->orderBy('id')
            ->limit($this->turnipQueue->concurrent_visitors)
            ->get();

        return $seekersToNotify->map(function ($turnipSeeker) {
            return new PrivateChannel('App.TurnipSeeker.'.$turnipSeeker->token);
        })->all();
    }
}
