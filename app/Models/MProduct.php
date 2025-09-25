<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name_service',
        'description',
        'price_service',
        'stock',
        'image_path',
        'status',
    ];

    public function variants()
    {
        return $this->hasMany(MProductVariant::class, 'm_product_id');
    }
}
