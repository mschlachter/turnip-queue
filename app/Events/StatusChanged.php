<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $turnipSeekerToken;
    public $position;
    public $dodoCode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($turnipQueue, $turnipSeeker, $position)
    {
        $this->turnipSeekerToken = $turnipSeeker->token;
        $this->position = $position;
        if ($position <= 0) {
            $this->dodoCode = $turnipQueue->dodo_code;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.TurnipSeeker.' . $this->turnipSeekerToken);
    }
}
