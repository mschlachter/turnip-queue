<?php

namespace App\Observers;

use App\TurnipQueueMessage;
use App\Events\QueueMessageSent;
use App\Events\QueueMessageDeleted;

class TurnipQueueMessageObserver
{
    /**
     * Handle the turnip queue message "created" event.
     *
     * @param  \App\TurnipQueueMessage  $turnipQueueMessage
     * @return void
     */
    public function created(TurnipQueueMessage $turnipQueueMessage)
    {
        QueueMessageSent::broadcast($turnipQueueMessage->turnipQueue, $turnipQueueMessage);
    }

    /**
     * Handle the turnip queue message "updated" event.
     *
     * @param  \App\TurnipQueueMessage  $turnipQueueMessage
     * @return void
     */
    public function updated(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Handle the turnip queue message "deleted" event.
     *
     * @param  \App\TurnipQueueMessage  $turnipQueueMessage
     * @return void
     */
    public function deleted(TurnipQueueMessage $turnipQueueMessage)
    {
        QueueMessageDeleted::broadcast($turnipQueueMessage->turnipQueue, $turnipQueueMessage);
    }

    /**
     * Handle the turnip queue message "restored" event.
     *
     * @param  \App\TurnipQueueMessage  $turnipQueueMessage
     * @return void
     */
    public function restored(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Handle the turnip queue message "force deleted" event.
     *
     * @param  \App\TurnipQueueMessage  $turnipQueueMessage
     * @return void
     */
    public function forceDeleted(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }
}
