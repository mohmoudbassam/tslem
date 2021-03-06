<?php

namespace App\Http\Requests\CP\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function rules()
    {
        return [

            'email' => [
                'nullable',
                'email',
                'unique:users,email,'.auth()->user()->id
            ],

        ];
    }
}
