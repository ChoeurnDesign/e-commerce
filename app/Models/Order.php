<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'tax_amount',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'payment_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'notes',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'tax_amount'   => 'decimal:2',
        'total_price'  => 'decimal:2',
        'shipped_at'   => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    /* ---------------- Relationships ---------------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // alias so $order->customer works (registered user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* ---------------- Accessors / Helpers ---------------- */

    // Adjusted: removed 'paid' (belongs to payment_status) and added 'confirmed' if you use it.
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending'    => 'yellow',
            'processing' => 'indigo',
            'confirmed'  => 'gray',      // choose color you like
            'shipped'    => 'purple',
            'delivered'  => 'green',
            'cancelled'  => 'red',
            'refunded'   => 'gray',
            default      => 'gray',
        };
    }

    public function getPaymentBadgeClassesAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300',
            'pending'  => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300',
            'failed'   => 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300',
            'refunded' => 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200',
            default    => 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200',
        };
    }

    public function getFullShippingAddressAttribute()
    {
        return "{$this->shipping_address}, {$this->shipping_city}, {$this->shipping_state} {$this->shipping_postal_code}, {$this->shipping_country}";
    }

    // Unified display name (registered user OR stored customer_name OR 'Guest')
    public function getDisplayNameAttribute(): string
    {
        return $this->user?->name
            ?? ($this->customer_name ?: 'Guest');
    }

    // Unified display email
    public function getDisplayEmailAttribute(): ?string
    {
        return $this->user?->email ?? $this->customer_email;
    }

    /* ---------------- Scopes ---------------- */

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Minimal search scope used by admin order listing.
     * Matches id (numeric), order_number, customer_name, customer_email, and related user name/email.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string)$term);
        if ($term === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            if (ctype_digit($term)) {
                $q->orWhere('id', (int)$term);
            }
            $q->orWhere('order_number', 'like', "%{$term}%")
                ->orWhere('customer_name', 'like', "%{$term}%")
                ->orWhere('customer_email', 'like', "%{$term}%")
                ->orWhereHas('user', function (Builder $u) use ($term) {
                    $u->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
        });
    }
}
