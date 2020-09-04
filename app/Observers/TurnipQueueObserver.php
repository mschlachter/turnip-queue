<?php

namespace App\Observers;

use App\TurnipQueue;
use App\Events\QueueClosed;

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
        //
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
