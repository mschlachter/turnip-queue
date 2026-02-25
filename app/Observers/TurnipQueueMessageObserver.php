<?php

namespace App\Observers;

use App\Events\QueueMessageDeleted;
use App\Events\QueueMessageSent;
use App\TurnipQueueMessage;

class TurnipQueueMessageObserver
{
    /**
     * Handle the turnip queue message "created" event.
     *
     * @return void
     */
    public function created(TurnipQueueMessage $turnipQueueMessage)
    {
        QueueMessageSent::broadcast($turnipQueueMessage->turnipQueue, $turnipQueueMessage);
    }

    /**
     * Handle the turnip queue message "updated" event.
     *
     * @return void
     */
    public function updated(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Handle the turnip queue message "deleted" event.
     *
     * @return void
     */
    public function deleted(TurnipQueueMessage $turnipQueueMessage)
    {
        QueueMessageDeleted::broadcast($turnipQueueMessage->turnipQueue, $turnipQueueMessage);
    }

    /**
     * Handle the turnip queue message "restored" event.
     *
     * @return void
     */
    public function restored(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }

    /**
     * Handle the turnip queue message "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(TurnipQueueMessage $turnipQueueMessage)
    {
        //
    }
}
