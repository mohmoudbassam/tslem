<?php

namespace App\Http\Requests\CP\OrderLogs;

use App\Helpers\Calendar;
use App\Models\OrderLogs;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderLogsRequest extends FormRequest
{
    public function rules()
    {
        return OrderLogs::$RULES;
    }

    public function validated()
    {
        $validated = parent::validated();
        foreach( ($model = OrderLogs::make())->getDates() as $column ) {
            if( isset($validated[ $column ]) ) {
                $validated[ $column ] = Calendar::getCarbon($model->getDateFormat(), $validated[ $column ]);
            }
        }
        return $validated;
    }
}
