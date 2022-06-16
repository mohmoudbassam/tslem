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
