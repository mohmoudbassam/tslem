<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxesResource extends JsonResource
{

    public function toArray($request)
    {

        return [
              'box'=>$this->box ??'',
              'camp'=>$this->camp ??''
        ];
    }
}
