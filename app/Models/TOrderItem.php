<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        't_order_id',
        'm_product_id',
        'm_product_variant_id',
        'name',
        'price',
        'qty',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(TOrder::class, 't_order_id');
    }

    public function product()
    {
        return $this->belongsTo(MProduct::class, 'm_product_id');
    }

    public function variant()
    {
        return $this->belongsTo(MProductVariant::class, 'm_product_variant_id');
    }
}


