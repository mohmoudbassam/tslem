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

        ];

        return array_merge($secondary_rule,$main_rule);
    }

    private function secondary_rule()
    {
        $benef = BeneficiresCoulumns::query()->where('type', request('type'))->first();
        $column = $benef->getAttributes();
        unset($column['type']);
        unset($column['id']);
        $array = [];
        foreach (array_filter($column) as $key => $value) {
            $array[$key] = 'required';
        }
        return $array;

    }
}
