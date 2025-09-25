<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProductVariantImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_product_variant_id',
        'image_path',
        'sort_order',
    ];

    public function variant()
    {
        return $this->belongsTo(MProductVariant::class, 'm_product_variant_id');
    }
}
