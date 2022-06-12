<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RaftCompanyLocationResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'phone'=>$this->user->phone ??''
        ];
    }
//'box'=>RaftCompanyBoxResource::collection($this->box)?? ''
}
