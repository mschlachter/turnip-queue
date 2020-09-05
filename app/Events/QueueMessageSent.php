<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $turnipQueueToken;
    public $turnipQueueMessage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue, $turnipQueueMessage)
    {
        $this->turnipQueueToken = $turnipQueue->token;
        // Simplify to keyed array to avoid leaking Dodo code
        $this->turnipQueueMessage = [
            'id' => $turnipQueueMessage->id,
            'sent_at' => $turnipQueueMessage->sent_at,
            'message' => $turnipQueueMessage->message,
        ];
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
