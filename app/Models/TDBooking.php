<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TDBooking extends Model
{
    use HasFactory , SoftDeletes;


    public function master(){
        return $this->belongsTo(TBooking::class);
    }

    public function service(){
        return $this->belongsTo(MService::class,'m_service_id');
    }





}
