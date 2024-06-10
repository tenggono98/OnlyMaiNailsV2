<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TDSchedule extends Model
{
    use HasFactory ;

    public function date(){
        return $this->belongsTo(TSchedule::class,'t_schedule_id');
    }
}
