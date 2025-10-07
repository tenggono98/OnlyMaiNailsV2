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
        'slug',
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

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'm_product_id');
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class, 'm_product_id')->where('is_approved', true);
    }

    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Generate a unique slug from SKU and name
     */
    public static function generateSlug($sku, $name)
    {
        $baseSlug = strtolower($sku . '-' . $name);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $baseSlug);
        $slug = trim($slug, '-');
        
        $originalSlug = $slug;
        $counter = 1;
        
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
