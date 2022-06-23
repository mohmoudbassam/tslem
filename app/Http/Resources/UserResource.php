<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user_name' => $this->name,
            'type' => $this->type,
            'token' => $this->access_token,
        ];
    }
}
