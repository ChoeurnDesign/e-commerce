<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $user_id
 * @property string $store_name
 * @property string $slug
 * @property string|null $description
 * @property string|null $business_document
 * @property string $status
 * @property string|null $admin_comment
 * @property string|null $store_logo
 * @property string|null $store_banner
 * @property string|null $contact_email
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $tiktok
 * @property bool $ships_worldwide
 * @property int|null $returns_days
 * @property string|null $shipping_summary
 * @property string|null $response_time
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $followers
 * @property-read string|null $business_document_url
 * @property-read string $store_banner_url
 * @property-read string $store_logo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreReview> $receivedStoreReviews
 * @property-read int|null $received_store_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreReview> $storeReviews
 * @property-read int|null $store_reviews_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VendorOrder> $vendorOrders
 * @property-read int|null $vendor_orders_count
 * @property-read \App\Models\Wallet|null $wallet
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereAdminComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereBusinessDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereResponseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereReturnsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereShippingSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereShipsWorldwide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStoreBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStoreLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereStoreName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereTiktok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Seller whereWebsite($value)
 * @mixin \Eloquent
 */
class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'store_name', 'slug', 'description', 'business_document',
        'status', 'admin_comment', 'store_logo', 'store_banner', 'contact_email',
        'address', 'phone', 'website', 'facebook', 'instagram', 'tiktok',
        'ships_worldwide', 'returns_days', 'shipping_summary', 'response_time', 'verified_at',
        'commission_rate', 'stripe_account_id',
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