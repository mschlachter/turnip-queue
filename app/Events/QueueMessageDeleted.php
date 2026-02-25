<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueMessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $turnipQueueToken;

    public $turnipQueueMessageId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue, $turnipQueueMessage)
    {
        $this->turnipQueueToken = $turnipQueue->token;
        $this->turnipQueueMessageId = $turnipQueueMessage->id;
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
