<?php

namespace App\Http\Requests;


use App\Models\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintainanceUploadFile extends BaseRequest
{


    public function rules()
    {

        return [
            'type' =>[
                'required',
                Rule::in([
                    'file_first',
                    'file_second',
                    'file_third',
                ])
            ],
            'session_id' =>[
                'required',
                Rule::exists('sessions','id')
            ],
            "file" => "required|mimes:pdf|max:10000"
        ];
    }
}
