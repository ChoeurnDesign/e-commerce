<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'store_name', 'slug', 'description', 'business_document',
        'status', 'admin_comment', 'store_logo', 'store_banner', 'contact_email',
        'address', 'phone', 'website', 'facebook', 'instagram', 'tiktok',
        'ships_worldwide', 'returns_days', 'shipping_summary', 'response_time', 'verified_at',
        'commission_rate', 'promo_until', 'stripe_account_id',
    ];

    protected $appends = ['store_logo_url', 'store_banner_url', 'business_document_url'];

    protected $casts = [
        'ships_worldwide' => 'boolean',
        'returns_days' => 'integer',
        'verified_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }

    public function orders()
    {
        // This connects the orders table to the seller for your dashboard
        return $this->hasMany(Order::class, 'seller_id', 'id');
    }

    public function vendorOrders()
    {
        return $this->hasMany(VendorOrder::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function storeReviews()
    {
        return $this->hasMany(StoreReview::class, 'seller_id');
    }

    public function receivedStoreReviews()
    {
        return $this->hasMany(StoreReview::class, 'seller_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'seller_followers', 'seller_id', 'user_id')
                    ->withTimestamps();
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'seller_id');
    }

    public function isFollowedBy(?\App\Models\User $user): bool
    {
        if (! $user) {
            return false;
        }

        if ($this->relationLoaded('followers')) {
            return $this->followers->contains($user->id);
        }

        return $this->followers()->where('user_id', $user->id)->exists();
    }

    public function averageRating()
    {
        return $this->storeReviews()->avg('rating') ?? 0;
    }

    public function reviewCount()
    {
        return $this->storeReviews()->count();
    }

    public function totalStoreReviews()
    {
        return $this->storeReviews()->count();
    }

    // --- Scopes for easier querying ---

    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    // --- Helper Methods for Approval Workflow ---

    /**
     * Check if the seller is currently pending approval.
     * Used for the Sidebar Badge logic.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

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

    // Mutators
    public function setContactEmailAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['contact_email'] = $value === '' ? null : $value;
    }

    public function setAddressAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['address'] = $value === '' ? null : $value;
    }

    public function setPhoneAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['phone'] = $value === '' ? null : $value;
    }

    public function setWebsiteAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['website'] = $value === '' ? null : $value;
    }

    public function setFacebookAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['facebook'] = $value === '' ? null : $value;
    }

    public function setInstagramAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['instagram'] = $value === '' ? null : $value;
    }

    public function setTiktokAttribute($value)
    {
        $value = is_null($value) ? null : trim((string) $value);
        $this->attributes['tiktok'] = $value === '' ? null : $value;
    }

    // Accessors
    public function getContactEmailAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->email ?? null;
        }

        return $this->user ? $this->user->email : null;
    }

    public function getAddressAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->address ?? null;
        }

        return $this->user ? $this->user->address : null;
    }

    public function getPhoneAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->phone ?? null;
        }

        return $this->user ? $this->user->phone : null;
    }

    public function getWebsiteAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->website ?? null;
        }

        return $this->user ? $this->user->website : null;
    }

    // Helpers
    public function hasOwnContactEmail(): bool
    {
        return !empty($this->getAttributes()['contact_email'] ?? null);
    }

    public function hasOwnAddress(): bool
    {
        return !empty($this->getAttributes()['address'] ?? null);
    }

    public function hasOwnPhone(): bool
    {
        return !empty($this->getAttributes()['phone'] ?? null);
    }

    public function hasOwnWebsite(): bool
    {
        return !empty($this->getAttributes()['website'] ?? null);
    }

    public function hasOwnSocials(): bool
    {
        $attrs = $this->getAttributes();
        return !empty($attrs['facebook'] ?? null) || !empty($attrs['instagram'] ?? null) || !empty($attrs['tiktok'] ?? null);
    }

    public function socialLinks(): array
    {
        $links = [];
        foreach (['website', 'facebook', 'instagram', 'tiktok'] as $key) {
            $val = $this->getAttributes()[$key] ?? null;
            if (!empty($val)) {
                $links[$key] = $val;
            }
        }
        return $links;
    }

    public function getStoreLogoUrlAttribute(): string
    {
        if ($this->store_logo) {
            if (filter_var($this->store_logo, FILTER_VALIDATE_URL)) {
                return $this->store_logo;
            }
            return asset('storage/' . ltrim($this->store_logo, '/'));
        }
        return asset('images/default-store.png');
    }
    
    public function getStoreBannerUrlAttribute(): string
    {
        if ($this->store_banner) {
            if (filter_var($this->store_banner, FILTER_VALIDATE_URL)) {
                return $this->store_banner;
            }
            return asset('storage/' . ltrim($this->store_banner, '/'));
        }
        return asset('images/default-banner.png');
    }
    
    public function getBusinessDocumentUrlAttribute(): ?string
    {
        if ($this->business_document) {
            return asset('storage/' . ltrim($this->business_document, '/'));
        }
        return null;
    }

    public function hasBusinessDocument(): bool
    {
        return !empty($this->business_document);
    }
}