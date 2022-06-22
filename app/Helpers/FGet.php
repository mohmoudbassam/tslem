<?php

use App\Helpers\Calendar;

if( !function_exists('getUserRaftCompanyBox') ) {
    function getUserRaftCompanyBox(?\Illuminate\Database\Eloquent\Model $user = null, $default = null): ?\App\Models\RaftCompanyBox
    {
        $user = optional($user ?? currentUser());
        $where = ($license_number = $user->license_number) ?
            compact('license_number') : [
                'box' => $user->box_number,
                'camp' => $user->camp_number,
            ];

        return \App\Models\RaftCompanyBox::where($where)->first() ?: value($default);
    }
}

if( !function_exists('hijriDateTime') ) {
    function hijriDateTime($timestamp = null, $format = 'Y/m/d H:i:s')
    {
        return Calendar::make($format ?? 'Y/m/d H:i:s')->hijriDate($timestamp ?? now());
    }
}

if( !function_exists('hijriDate') ) {
    function hijriDate($timestamp = null, $format = 'Y/m/d')
    {
        return Calendar::make($format ?? 'Y/m/d')->hijriDate($timestamp ?? now());
    }
}

if( !function_exists('downloadFileFrom') ) {
    /**
     * @param $model
     * @param $id
     * @param $attribute
     *
     * @return string
     * @throws \Throwable
     */
    function downloadFileFrom($model, $id, $attribute = null)
    {
        if( is_null($attribute) ) {
            $class = is_object($model) ? get_class($model) : $model;
            throw_unless(isModel($model), "The given object [{$class}] is not Model!");

            $attribute = $id;
            $id = $model->id;
        }

        $model = isModel($model) ? str_after(get_class($model), 'App\\Models\\') : $model;

        return route('download_file', compact('model', 'id', 'attribute'));
    }
}
