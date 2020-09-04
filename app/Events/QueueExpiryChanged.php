<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueExpiryChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $turnipQueueToken;
    public $newExpiry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue)
    {
        $this->turnipQueueToken = $turnipQueue->token;
        $this->newExpiry = $turnipQueue->expires_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['App.TurnipQueue.' . $this->turnipQueueToken];
    }
}
