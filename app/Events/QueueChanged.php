<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $turnipQueueToken;
    public $newQueue;
    public $concurrentVisitors;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue)
    {
        $this->turnipQueueToken = $turnipQueue->token;
        $this->newQueue = $turnipQueue->turnipSeekers()->inQueue()->get();
        $this->concurrentVisitors = $turnipQueue->concurrent_visitors;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.TurnipQueue.' . $this->turnipQueueToken);
    }
}
