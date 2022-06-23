<?php

namespace App\Http\Requests\CP\User;

use App\Models\BeneficiresCoulumns;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadFilesRequest extends FormRequest
{

    public function rules(){
return [];
//        $benef = BeneficiresCoulumns::query()->select('commercial_file',
//            'rating_certificate',
//            'address_file',
//            'profession_license',
//            'business_license',
//            'social_insurance_certificate',
//            'certificate_of_zakat',
//            'saudization_certificate',
//            'chamber_of_commerce_certificate',
//            'tax_registration_certificate',
//            'wage_protection_certificate',
//            'memorandum_of_association')
//            ->where('type', auth()->user()->type)->first();
//        $column = $benef->getAttributes();
//        $array = [];
//        foreach (array_filter($column) as $key => $value) {
//            $array[$key] = 'required|mimes:pdf';
//        }
//        return $array;
    }

}
