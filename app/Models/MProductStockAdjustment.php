<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProductStockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_product_id',
        'm_product_variant_id',
        'delta',
        'reason',
        'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(MProduct::class, 'm_product_id');
    }

    public function variant()
    {
        return $this->belongsTo(MProductVariant::class, 'm_product_variant_id');
    }
}


