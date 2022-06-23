<?php

namespace App\Observers;

use App\Models\License;

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
        if( $license->exists && $license->wasChanged('map_path') && $license->getOriginal('map_path') ) {
            $license->deleteMapPathFile();
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
