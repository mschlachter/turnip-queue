<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\TurnipQueue;

class ExpireQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $turnipQueueId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($turnipQueue)
    {
        $this->turnipQueueId = $turnipQueue->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $turnipQueue = TurnipQueue::find($this->turnipQueueId);
        if($turnipQueue->is_open) {
            $turnipQueue->update(['is_open' => false]);
        }
    }
}
