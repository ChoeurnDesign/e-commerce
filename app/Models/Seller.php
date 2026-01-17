<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // <-- Add this line

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'slug',
        'description',
        'business_document',
        'status',
        'admin_comment',
        'store_logo',
        'store_banner',
        'contact_email',
        'address',
        'phone',
        'website',
        'facebook',
        'instagram',
        'tiktok',
        'ships_worldwide',
        'returns_days',
        'shipping_summary',
        'response_time',
        'verified_at',
    ];

    // The accessor names are correct here
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

    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
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

    // Mutators (no changes needed here)
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

    // Accessors - optional fallback to user when seller value empty
    // (no changes needed here, they are fine)
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

    // Helpers (no changes needed here)
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

    /**
     * Get the URL for the store's logo.
     * Use this accessor to get the full URL to the logo file.
     * @return string|null
     */
    public function getStoreLogoUrlAttribute(): ?string
    {
        // Check if a logo path exists and the file is present on the 'public' disk.
        if ($this->store_logo && Storage::disk('public')->exists($this->store_logo)) {
            return Storage::disk('public')->url($this->store_logo);
        }
        
        // Return null or a default path if the logo doesn't exist.
        // Returning null allows the blade file to handle the placeholder logic.
        return null;
    }
    
    /**
     * Get the URL for the store's banner.
     * @return string|null
     */
    public function getStoreBannerUrlAttribute(): ?string
    {
        if ($this->store_banner && Storage::disk('public')->exists($this->store_banner)) {
            return Storage::disk('public')->url($this->store_banner);
        }

        return null;
    }
    
    /**
     * Get the URL for the business document.
     * @return string|null
     */
    public function getBusinessDocumentUrlAttribute(): ?string
    {
        if ($this->business_document && Storage::disk('public')->exists($this->business_document)) {
            return Storage::disk('public')->url($this->business_document);
        }

        return null;
    }

    public function hasBusinessDocument(): bool
    {
        return !empty($this->business_document);
    }
}