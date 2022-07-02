<?php

namespace App\Observers;

use App\Models\License;
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
        if( $order->isDirty('status') && !$order->originalIsEquivalent('status') ) {
            if( in_array($order->status,[
                Order::FINAL_REPORT_ATTACHED,
                Order::FINAL_REPORT_APPROVED,
                Order::FINAL_LICENSE_GENERATED,
            ]) )
            {
                $order->notifyChanges($order->order_status);
            }
        }

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
        /** @var \App\Models\Order $order */
        if( $order->status >= Order::PENDING_OPERATION ) {
            $order->generateLicenseFile($filename1, License::ADDON_TYPE, true, true);
        }

        if( $order->status >= Order::FINAL_LICENSE_GENERATED ) {
            $order->generateLicenseFile($filename2, License::EXECUTION_TYPE, true, true);
        }
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
