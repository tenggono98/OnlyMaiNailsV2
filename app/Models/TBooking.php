<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TBooking extends Model
{
    use HasFactory , SoftDeletes;



    public function client(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function detailService(){
        return $this->hasMany(TDBooking::class,'t_booking_id');
    }

    public function scheduleDateBook(){
        return $this->belongsTo(TSchedule::class,'t_schedule_id');
    }

    public function scheduleTimeBook(){
        return $this->belongsTo(TDSchedule::class,'t_d_schedule_id');
    }

    public function admin_created(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function admin_updated(){
        return $this->belongsTo(User::class,'updated_by');
    }

    public function review(){
        return $this->hasOne(ReviewUser::class);
    }


}
