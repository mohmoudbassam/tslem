<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteSessionRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'session_id'=> [
                'required',
                Rule::exists('sessions','id')->where('support_id', auth('users')->user()->id)
            ]

        ];
    }
}
