<?php

namespace App\Observers;

use App\Models\FinalReport;

class FinalReportObserver
{
    /**
     * Handle the FinalReport "saving" event.
     *
     * @param \App\Models\FinalReport $final_report
     *
     * @return void
     */
    public function saving(FinalReport $final_report)
    {
        if( $final_report->exists ) {
            $data = array_only($final_report->getOriginal(), array_keys($final_report->getDirty()));
            $meta = array_merge(
                $final_report->meta ?: [],
                array_filter($data, function($val) {
                    return !is_null($val) && $val !== "";
                })
            );

            $final_report->meta = $meta;
        }
    }
}
