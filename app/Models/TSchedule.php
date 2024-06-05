<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TSchedule extends Model
{
    use HasFactory , SoftDeletes;

    public function times(){
        return $this->hasMany(TDSchedule::class,'t_booking_id');
    }
}
