<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
class RaftCompanyBox extends Model
{
    use HasFactory;

    protected $table = 'raft_company_box';
    protected $guarded=[];

    public function getFileFirstFullpathAttribute(){
        if($this->file_first){
            return Storage::disk('public')->url($this->file_first);
        }else {
            return null;
        }
    }

    public function getFileSecondFullpathAttribute(){
        if($this->file_second){
            return Storage::disk('public')->url($this->file_second);
        }else {
            return null;
        }
    }

    public function getFileThirdFullpathAttribute(){
        if($this->file_third){
            return Storage::disk('public')->url($this->file_third);
        }else {
            return null;
        }
    }
}
