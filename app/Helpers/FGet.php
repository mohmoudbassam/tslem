<?php

if( !function_exists('getUserRaftCompanyBox') ) {
    function getUserRaftCompanyBox(?\Illuminate\Database\Eloquent\Model $user = null): ?\App\Models\RaftCompanyBox
    {
        $user = optional($user ?? currentUser());
        $where = ($license_number = $user->license_number) ?
            compact('license_number') : [
                'box' => $user->box_number,
                'camp' => $user->camp_number,
            ];

        return \App\Models\RaftCompanyBox::where($where)->first();
    }
}
