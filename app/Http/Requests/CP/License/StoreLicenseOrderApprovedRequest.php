<?php

namespace App\Http\Requests\CP\License;

use App\Helpers\Calendar;
use App\Models\License;
use Illuminate\Foundation\Http\FormRequest;

class StoreLicenseOrderApprovedRequest extends FormRequest
{
    public function rules()
    {
        return License::$ORDER_APPROVED_RULES;
    }

    public function validated()
    {
        $validated = parent::validated();
        foreach( ($model = License::make())->getDates() as $column ) {
            if( isset($validated[ $column ]) ) {
                $validated[ $column ] = Calendar::getCarbon($model->getDateFormat(), $validated[ $column ]);
            }
        }
        return $validated;
    }
}
