<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id ?? '',
            'raft_company_name'=> $this->RaftCompanyLocation->name ?? '',
            'box'=>optional($this->RaftCompanyBox)->box ?? '',
            'camp'=>optional($this->RaftCompanyBox)->camp ?? '',
            'phone'=>optional($this->RaftCompanyLocation)->user->phone ?? '',
            'start_at'=>$this->start_at ?? '',
        ];
    }
}
