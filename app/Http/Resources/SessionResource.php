<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SessionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id ?? '',
            'raft_company_name'=> $this->RaftCompanyLocation->name ?? '',
            'box'=>optional($this->RaftCompanyBox)->box ?? '',
            'camp'=>optional($this->RaftCompanyBox)->camp ?? '',
            'phone'=>optional($this->RaftCompanyLocation)->user->phone ?? '',
            'start_at'=>$this->start_at ?? '',
            'first_file'=>is_null($this->RaftCompanyBox->file_first ?? null)?null: Storage::disk('public')->url($this->RaftCompanyBox->file_first) ?? '',
            'file_second'=>is_null($this->RaftCompanyBox->file_first)?null: Storage::disk('public')->url($this->RaftCompanyBox->file_second) ?? '',
            'file_third'=>is_null($this->RaftCompanyBox->file_first)?null: Storage::disk('public')->url($this->RaftCompanyBox->file_third) ?? '',
        ];
    }
}
