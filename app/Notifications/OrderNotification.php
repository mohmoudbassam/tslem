<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    public  $data;
    public  $notifer_id;
    public  $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data,$notifer_id,$type=null)
    {
        $this->data = $data;
        $this->notifer_id = $notifer_id;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {

        return [
            'data'=>$this->data,
            'user_id'=>$this->notifer_id,
            'type'=>$this->type
        ];
    }
}
