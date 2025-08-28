<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seller extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'slug',
        'description',
        'business_document',
        'status',
        'admin_comment',
        'store_logo',
    ];

    // Route model binding uses slug
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /*
     |------------------------------------------------------------
     | Relationships
     |------------------------------------------------------------
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // NOTE: Intentionally mapping by user_id (document this to avoid "fixes")
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /*
     |------------------------------------------------------------
     | Scopes
     |------------------------------------------------------------
     */
    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }

    /*
     |------------------------------------------------------------
     | Slug Generation
     |------------------------------------------------------------
     */
    protected static function booted()
    {
        static::creating(function (self $seller) {
            if (blank($seller->slug)) {
                $seller->slug = static::uniqueSlug(
                    $seller->store_name ?: 'seller-' . uniqid()
                );
            }
        });
    }

    protected static function uniqueSlug(string $baseValue): string
    {
        $base = Str::slug($baseValue);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /*
     |------------------------------------------------------------
     | Accessors (NO disk exists checks to avoid extra I/O)
     |------------------------------------------------------------
     */
    public function getStoreLogoUrlAttribute(): ?string
    {
        if (!$this->store_logo) return null;
        $path = ltrim($this->store_logo, '/');
        $path = preg_replace('#^(public/|storage/)#', '', $path);
        return asset('storage/' . $path);
    }

    public function getBusinessDocumentUrlAttribute(): ?string
    {
        if (!$this->business_document) return null;
        $path = ltrim($this->business_document, '/');
        $path = preg_replace('#^(public/|storage/)#', '', $path);
        return asset('storage/' . $path);
    }

    public function hasBusinessDocument(): bool
    {
        return !empty($this->business_document);
    }
}