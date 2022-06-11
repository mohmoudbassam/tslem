<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveNote extends BaseRequest
{

    public function rules()
    {
        return [
            'note' => [
                'required'
            ],
            'session_id' =>[
                'required',
                Rule::exists('sessions','id')
            ],
        ];
    }
}
