<?php

namespace App\Http\Controllers;

use App\SiteNotification;

class SiteNotificationController extends Controller
{
    public function dismiss()
    {
        $id = request('id');
        $notif = SiteNotification::active()->findOrFail($id);
        session()->put('notif-dismissed|'.$id, true);
    }
}
