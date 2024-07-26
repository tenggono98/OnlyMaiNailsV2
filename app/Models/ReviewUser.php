<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewUser extends Model
{
    use HasFactory;

    public function booking(){
        return $this->belongsTo(TBooking::class,'t_booking_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    
}
