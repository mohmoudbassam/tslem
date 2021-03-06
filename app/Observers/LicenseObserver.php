<?php

namespace App\Observers;

use App\Models\License;
use App\Models\Order;

class LicenseObserver
{
    /**
     * Handle the License "saving" event.
     *
     * @param \App\Models\License $license
     *
     * @return void
     */
    public function saving(License $license)
    {
        if( $license->exists ) {
            if( $license->type === License::EXECUTION_TYPE ) {
                $license->second_date = now();
            }

            if( $license->wasChanged('map_path') && $license->getOriginal('map_path') ) {
                $license->deleteMapPathFile();
            }
        }
    }

    /**
     * Handle the License "saved" event.
     *
     * @param \App\Models\License $license
     *
     * @return void
     */
    public function saved(License $license)
    {
        /** @var \App\Models\Order $order */
        $order = optional($license->order);
        if( $order->status >= Order::PENDING_OPERATION ) {
            $filename1 = null;
            $order->generateLicenseFile($filename1, License::ADDON_TYPE, true, true);
        }

        if( $order->status >= Order::FINAL_LICENSE_GENERATED ) {
            $filename2 = null;
            $order->generateLicenseFile($filename2, License::EXECUTION_TYPE, true, true);
        }
    }

    /**
     * Handle the License "deleted" event.
     *
     * @param \App\Models\License $license
     *
     * @return void
     */
    public function deleting(License $license)
    {
        $license->deleteMapPathFile();
    }
}
