<?php

use App\Models\BeneficiresCoulumns;
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

function get_user_column_file($type)
{
    $benef = BeneficiresCoulumns::query()->select('commercial_file',
        'rating_certificate',
        'address_file',
        'profession_license',
        'business_license',
        'social_insurance_certificate',
        'certificate_of_zakat',
        'saudization_certificate',
        'chamber_of_commerce_certificate',
        'tax_registration_certificate',
        'wage_protection_certificate',
        'memorandum_of_association')
        ->where('type', $type)->first();
    $column = $benef->getAttributes();
    return array_filter($column);

}
