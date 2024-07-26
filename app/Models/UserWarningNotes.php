<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWarningNotes extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class,'note_for');
    }

    public function account(){
        return $this->belongsTo(User::class,'created_by');
    }
}
