<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_product_id',
        'sku',
        'name',
        'price',
        'stock',
        'image_path',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(MProduct::class, 'm_product_id');
    }

    public function images()
    {
        return $this->hasMany(MProductVariantImage::class, 'm_product_variant_id')->orderBy('sort_order');
    }
}


