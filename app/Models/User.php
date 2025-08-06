<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $profile_image
 * @property string $role
 * @property string|null $preferred_currency
 * @property string|null $preferred_language
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property-read int $wishlist_count
 * @property-read int $cart_count
 */
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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Products in the user's wishlist.
     */
    public function wishlistProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id');
    }

    /**
     * Wishlist items (pivot records) for the user.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Count of wishlist items.
     */
    public function getWishlistCountAttribute(): int
    {
        return $this->wishlistItems()->count();
    }

    /**
     * Cart items for the user.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Count of cart items.
     */
    public function getCartCountAttribute(): int
    {
        return $this->cartItems()->count();
    }

    /**
     * Reviews by the user.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if a product is in the user's wishlist.
     */
    public function hasInWishlist($productId): bool
    {
        return $this->wishlistItems()->where('product_id', $productId)->exists();
    }

    /**
     * Add a product to the user's wishlist.
     */
    public function addToWishlist($productId)
    {
        return $this->wishlistItems()->firstOrCreate(['product_id' => $productId]);
    }

    /**
     * Remove a product from the user's wishlist.
     */
    public function removeFromWishlist($productId)
    {
        return $this->wishlistItems()->where('product_id', $productId)->delete();
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
