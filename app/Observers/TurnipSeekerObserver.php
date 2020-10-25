<?php

namespace App\Observers;

use App\turnipQueue;
use App\TurnipSeeker;
use App\Events\QueueChanged;
use App\Events\StatusChanged;

class TurnipSeekerObserver
{
    /**
     * Handle the turnip seeker "created" event.
     *
     * @param  \App\TurnipSeeker  $turnipSeeker
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
     * @param  \App\TurnipSeeker  $turnipSeeker
     * @return void
     */
    public function updated(TurnipSeeker $turnipSeeker)
    {
        if ($turnipSeeker->isDirty('left_queue')) {
            $turnipQueue = TurnipQueue::where('id', $turnipSeeker->turnip_queue_id)->first();
            QueueChanged::dispatch($turnipQueue);

            $concurrentVisitors = $turnipQueue->concurrent_visitors;

            foreach ($turnipQueue->turnipSeekers()->inQueue()->get() as $index => $otherSeeker) {
                // Event to update their position in the queue...
                StatusChanged::broadcast(
                    $turnipQueue,
                    $otherSeeker,
                    $index - $concurrentVisitors + 1
                );
            }
        }
    }

    /**
     * Handle the turnip seeker "deleted" event.
     *
     * @param  \App\TurnipSeeker  $turnipSeeker
     * @return void
     */
    public function deleted(TurnipSeeker $turnipSeeker)
    {
        //
    }

    /**
     * Handle the turnip seeker "restored" event.
     *
     * @param  \App\TurnipSeeker  $turnipSeeker
     * @return void
     */
    public function restored(TurnipSeeker $turnipSeeker)
    {
        //
    }

    /**
     * Handle the turnip seeker "force deleted" event.
     *
     * @param  \App\TurnipSeeker  $turnipSeeker
     * @return void
     */
    public function forceDeleted(TurnipSeeker $turnipSeeker)
    {
        //
    }
}
