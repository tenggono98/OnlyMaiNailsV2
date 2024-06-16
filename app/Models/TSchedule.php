<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TSchedule extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 't_schedules';

    public function times(){
        return $this->hasMany(TDSchedule::class,'t_schedule_id','id');
    }
}
