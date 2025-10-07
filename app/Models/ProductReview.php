<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_product_id',
        'user_id',
        'rating',
        'review_text',
        'is_approved',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(MProduct::class, 'm_product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
