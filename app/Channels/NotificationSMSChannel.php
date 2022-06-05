<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class NotificationSMSChannel
{
    public $title;
    public $body;

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    public function setBody($body){
        $this->body = $body;
        return $this;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        

    }
}