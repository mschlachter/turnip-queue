<?php

namespace App\Observers;

use App\Events\QueueChanged;
use App\turnipQueue;
use App\TurnipSeeker;

class TurnipSeekerObserver
{
    /**
     * Handle the turnip seeker "created" event.
     *
     * @return void
     */
    public function created(TurnipSeeker $turnipSeeker)
    {
        $turnipQueue = turnipQueue::where('id', $turnipSeeker->turnip_queue_id)->first();
        QueueChanged::dispatch($turnipQueue);
    }

    /**
     * Handle the turnip seeker "updated" event.
     *
     * @return void
     */
    public function updated(TurnipSeeker $turnipSeeker)
    {
        if ($turnipSeeker->isDirty('left_queue') || $turnipSeeker->isDirty('received_code')) {
            $turnipQueue = TurnipQueue::where('id', $turnipSeeker->turnip_queue_id)->first();
            QueueChanged::dispatch($turnipQueue);
        }
    }

    /**
     * Handle the turnip seeker "deleted" event.
     *
     * @return void
     */
    public function deleted(TurnipSeeker $turnipSeeker)
    {
        //
    }

    /**
     * Handle the turnip seeker "restored" event.
     *
     * @return void
     */
    public function restored(TurnipSeeker $turnipSeeker)
    {
        //
    }

    /**
     * Handle the turnip seeker "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(TurnipSeeker $turnipSeeker)
    {
        //
    }
}
