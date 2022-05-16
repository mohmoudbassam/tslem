<?php

namespace App\Http\Requests\CP\User;

use App\Models\BeneficiresCoulumns;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{

    public function rules()
    {
        $secondary_rule = $this->secondary_rule();

        $main_rule = [
            'name' => [
                'required',
                Rule::unique('users', 'name'),
                'regex:/^[a-zA-Z]+$/u',
                'max:50'
            ],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'type' => [
                Rule::in([
                    'admin',
                    'service_provider',
                    'design_office',
                    'Sharer',
                    'consulting_office',
                    'contractor',
                    'Delivery',
                    'Kdana',
                ])
            ],
            'commercial_record' => [
                'sometimes',
                'numeric'
            ],
            'phone' => [
                'sometimes',
                'numeric',
                'digits:12'
            ],

        ];

        return array_merge($secondary_rule, $main_rule);
    }

    private function secondary_rule()
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
            ->where('type', request('type'))->first();
        $column = $benef->getAttributes();
        $array = [];
        foreach (array_filter($column) as $key => $value) {
            $array[$key] = 'required|mimes:png,jpg,jpeg,pdf';
        }
        return $array;

    }
}
