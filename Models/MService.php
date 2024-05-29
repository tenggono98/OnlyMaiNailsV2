<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MService extends Model
{
    use HasFactory , SoftDeletes;


    public function category(){
        return $this->belongsTo(MServiceCategory::class,'m_service_category_id');
    }

}
