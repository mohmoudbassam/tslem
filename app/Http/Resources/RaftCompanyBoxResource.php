<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RaftCompanyBoxResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'camp' => $this->camp ?? '',
            'box' => $this->box ?? '',
            'file_first' => $this->getFileStorageLink($this->file_first) ?? '',
            'file_second' => $this->getFileStorageLink($this->file_second)   ?? '',
            'file_third' => $this->getFileStorageLink($this->file_third) ?? '',
            'tasleem_notes' => $this->tasleem_notes ?? '',
        ];
    }

    private function getFileStorageLink($file){
        if(is_null($file)){
            return null;
        }
        return asset('storage/').'/'.$file;
    }
}
