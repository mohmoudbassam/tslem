<?php

namespace App\Http\Requests\CP\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('users', 'name'),
            ],
            'email' => [
                'email',
                Rule::unique('users', 'email'),
            ],
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

        ];
    }
}
