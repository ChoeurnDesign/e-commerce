<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasImageHelper;
use App\Traits\HasStockHelper;
use App\Traits\HasPriceHelper;
use App\Traits\HasProductScopes;

class Product extends Model
{
    use HasFactory, HasImageHelper, HasStockHelper, HasPriceHelper, HasProductScopes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'sale_price',
        'on_sale',
        'sku',
        'stock_quantity',
        'image',
        'images',
        'specifications',
        'gallery',
        'is_featured',
        'is_active',
        'category_id',
        'meta_title',
        'meta_description',
        'page_views'
    ];

    protected $casts = [
        'images' => 'array',
        'gallery' => 'array',
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'page_views' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(\App\Models\Review::class)->where('is_approved', true);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->attributes['average_rating'] ?? $this->approvedReviews()->avg('rating');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (!isset($this->attributes['slug']) || $this->attributes['slug'] !== Str::slug($value)) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}
