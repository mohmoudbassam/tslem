<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\OrderNotification;

class OrderObserver
{
    /**
     * Handle the Order "saving" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function saving(Order $order)
    {
        // todo: https://trello.com/c/iuKT8Uhh/14-add-modal-for-tslem-3
        // if( !$order->originalIsEquivalent('contractor_id') || !$order->originalIsEquivalent('consulting_office_id') ) {
        //     if( $order->contractor_id && $order->consulting_office_id ) {
        //         optional($order->service_provider)->notify(new OrderNotification('تم تعيين استشاري ومقاول', currentUser()->id));
            // }
        // }
    }

    /**
     * Handle the Order "saved" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function saved(Order $order)
    {

    }

    /**
     * Handle the Order "created" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
