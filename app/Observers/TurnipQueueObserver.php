<?php

namespace App\Observers;

use App\TurnipQueue;
use App\Events\QueueClosed;
use App\Events\QueueExpiryChanged;
use App\Jobs\ExpireQueue;

class TurnipQueueObserver
{
    /**
     * Handle the turnip queue "created" event.
     *
     * @param  \App\TurnipQueue  $turnipQueue
     * @return void
     */
    public function created(TurnipQueue $turnipQueue)
    {
        // Set expiry job
        ExpireQueue::dispatch($turnipQueue)->delay($turnipQueue->expires_at);
    }

    /**
     * Handle the turnip queue "updated" event.
     *
     * @param  \App\TurnipQueue  $turnipQueue
     * @return void
     */
    public function updated(TurnipQueue $turnipQueue)
    {
        if($turnipQueue->isDirty('is_open') && !$turnipQueue->is_open) {
            QueueClosed::dispatch($turnipQueue);
        }

        if($turnipQueue->isDirty('expires_at')) {
            QueueExpiryChanged::dispatch($turnipQueue);

            // Set expiry job; no need to delete old job as it'll check whether job should expire before running
            ExpireQueue::dispatch($turnipQueue)->delay($turnipQueue->expires_at);
        }
    }

    /**
     * Handle the turnip queue "deleted" event.
     *
     * @param  \App\TurnipQueue  $turnipQueue
     * @return void
     */
    public function deleted(TurnipQueue $turnipQueue)
    {
        QueueClosed::dispatch($turnipQueue);
    }

    /**
     * Handle the turnip queue "restored" event.
     *
     * @param  \App\TurnipQueue  $turnipQueue
     * @return void
     */
    public function restored(TurnipQueue $turnipQueue)
    {
        //
    }

    /**
     * Handle the turnip queue "force deleted" event.
     *
     * @param  \App\TurnipQueue  $turnipQueue
     * @return void
     */
    public function forceDeleted(TurnipQueue $turnipQueue)
    {
        //
    }
}
