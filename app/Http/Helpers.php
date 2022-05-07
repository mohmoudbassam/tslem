<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

function save_logs($order, $user_id, $data)
{
    $order->logs()->create([
        'data' => $data,
        'user_id' => $user_id
    ]);
}
