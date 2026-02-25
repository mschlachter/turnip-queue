<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueClosed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $turnipQueueToken;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue)
    {
        $this->turnipQueueToken = $turnipQueue->token;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['App.TurnipQueue.'.$this->turnipQueueToken];
    }
}
