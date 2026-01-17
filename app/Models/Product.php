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
        'user_id',
        'description',
        'short_description',
        'price',
        'compare_price',
        'sale_price',
        'on_sale',
        'sku',
        'stock_quantity',
        'image',
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
        return $this->hasMany(Review::class)->where('is_approved', true);
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Seller relationship.
     * Assumes the seller's user_id is the same as the product's user_id.
     * This is correct and will always fetch the right seller even if store_names repeat.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id', 'user_id');
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        // Use eager loaded value if present, otherwise calculate
        return $this->attributes['average_rating'] ?? $this->approvedReviews()->avg('rating');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        return 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($this->name ?? 'No Image');
    }

    public function getGalleryUrlsAttribute()
    {
        if (is_array($this->gallery) && count($this->gallery)) {
            return array_map(
                fn($img) => file_exists(public_path($img))
                    ? asset($img)
                    : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image',
                $this->gallery
            );
        }
        return [];
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (!$this->on_sale || !$this->sale_price || !$this->price || (float)$this->price == 0) return null;
        return (int) round(100 - ($this->sale_price / $this->price * 100));
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if (
            !isset($this->attributes['slug'])
            || empty($this->attributes['slug'])
            || $this->attributes['slug'] === Str::slug($this->getOriginal('name'))
        ) {
            $this->attributes['slug'] = self::generateUniqueSlug($value, $this->id ?? null);
        }
    }

    // Static Methods
    public static function generateUniqueSlug($base, $ignoreId = null)
    {
        $slug = Str::slug($base);
        $original = $slug;
        $count = 2;
        while (self::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }
        return $slug;
    }

    public static function generateUniqueSku($base, $ignoreId = null)
    {
        $sku = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $base));
        $original = $sku;
        do {
            $exists = self::where('sku', $sku)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
            if ($exists) {
                $sku = "{$original}-" . strtoupper(Str::random(4));
            }
        } while ($exists);
        return $sku;
    }
}