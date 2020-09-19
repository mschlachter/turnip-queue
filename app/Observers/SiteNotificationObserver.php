<?php

namespace App\Observers;

use App\SiteNotification;
use App\Events\SiteNotificationAdded;
use App\Events\SiteNotificationRemoved;
use App\Events\SiteNotificationUpdated;

class SiteNotificationObserver
{
    /**
     * Handle the site notification "created" event.
     *
     * @param  \App\SiteNotification  $siteNotification
     * @return void
     */
    public function created(SiteNotification $siteNotification)
    {
        SiteNotificationAdded::broadcast($siteNotification);
    }

    /**
     * Handle the site notification "updated" event.
     *
     * @param  \App\SiteNotification  $siteNotification
     * @return void
     */
    public function updated(SiteNotification $siteNotification)
    {
        if ($siteNotification->isDirty('is_active') && $siteNotification->is_active) {
            SiteNotificationAdded::broadcast($siteNotification);
        } elseif ($siteNotification->isDirty('is_active') && !$siteNotification->is_active) {
            SiteNotificationRemoved::broadcast($siteNotification);
        } elseif ($siteNotification->is_active &&
            (
                $siteNotification->isDirty('message') ||
                $siteNotification->isDirty('type')
            )
        ) {
            SiteNotificationUpdated::broadcast($siteNotification);
        }
    }

    /**
     * Handle the site notification "deleted" event.
     *
     * @param  \App\SiteNotification  $siteNotification
     * @return void
     */
    public function deleted(SiteNotification $siteNotification)
    {
        SiteNotificationRemoved::broadcast($siteNotification);
    }

    /**
     * Handle the site notification "restored" event.
     *
     * @param  \App\SiteNotification  $siteNotification
     * @return void
     */
    public function restored(SiteNotification $siteNotification)
    {
        //
    }

    /**
     * Handle the site notification "force deleted" event.
     *
     * @param  \App\SiteNotification  $siteNotification
     * @return void
     */
    public function forceDeleted(SiteNotification $siteNotification)
    {
        //
    }
}
