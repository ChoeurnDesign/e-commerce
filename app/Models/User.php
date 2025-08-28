<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'role',
        'preferred_currency',
        'preferred_language',
        'slug', // Make sure slug is fillable
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function wishlistProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id');
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getWishlistCountAttribute(): int
    {
        return $this->wishlistItems()->count();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getCartCountAttribute(): int
    {
        return $this->cartItems()->count();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function hasInWishlist($productId): bool
    {
        return $this->wishlistItems()->where('product_id', $productId)->exists();
    }

    public function addToWishlist($productId)
    {
        return $this->wishlistItems()->firstOrCreate(['product_id' => $productId]);
    }

    public function removeFromWishlist($productId)
    {
        return $this->wishlistItems()->where('product_id', $productId)->delete();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function seller()
    {
        return $this->hasOne(\App\Models\Seller::class);
    }

    // Seller's products (for multi-vendor)
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
