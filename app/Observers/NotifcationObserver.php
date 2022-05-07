<?php

namespace App\Observers;

class NotifcationObserver
{
    public function creating($notification)
    {

        $notification->user_id = $notification->data['user_id'] ?? 0;
    }
}
