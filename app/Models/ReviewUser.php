<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewUser extends Model
{
    use HasFactory;

    public function booking(){
        return $this->hasOne(TBooking::class,'booking_uuid','uuid');
    }
}
