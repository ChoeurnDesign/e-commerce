<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB; // Required for transactions

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'seller_id',
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
        'delivered_at',
        'payout_released' // Added for security
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'tax_amount'   => 'decimal:2',
        'total_price'  => 'decimal:2',
        'shipped_at'   => 'datetime',
        'delivered_at' => 'datetime',
        'payout_released' => 'boolean', // Added for security
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

    public function user() { return $this->belongsTo(User::class); }
    public function customer() { return $this->belongsTo(User::class, 'user_id'); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function vendorOrders() { return $this->hasMany(VendorOrder::class); }

    // WARNING: This is problematic for multi-vendor orders. 
    // It is safer to use orderItems()->seller_id instead.
    public function seller() { return $this->belongsTo(Seller::class); }

    /* ---------------- Logic ---------------- */

    public function distributeVendorEarnings()
    {
        // 1. SAFETY GUARD: If funds are already released, stop immediately!
        if ($this->payout_released) {
            return; 
        }

        // 2. TRANSACTION: Ensures all or nothing is processed
        DB::transaction(function () {
            $itemsBySeller = $this->orderItems->groupBy('seller_id');

            foreach ($itemsBySeller as $sellerId => $items) {
                $subtotal = $items->sum('total'); 
                $commissionRate = 10.00; 
                $commissionAmount = ($subtotal * $commissionRate) / 100;
                $sellerEarnings = $subtotal - $commissionAmount;

                $this->vendorOrders()->updateOrCreate(
                    ['seller_id' => $sellerId],
                    [
                        'subtotal'          => $subtotal,
                        'commission_rate'   => $commissionRate,
                        'commission_amount' => $commissionAmount,
                        'seller_earnings'   => $sellerEarnings,
                        'status'            => 'pending',
                        'payout_status'     => 'pending',
                        'stripe_account_id' => $items->first()->product->seller->stripe_account_id ?? null,
                    ]
                );

                $seller = \App\Models\Seller::find($sellerId);
                if ($seller && $seller->user) {
                    \App\Models\Wallet::firstOrCreate(['seller_id' => $seller->user->id])
                        ->increment('balance', $sellerEarnings);
                }
            }

            // 3. Update the flag to TRUE so it can never run again for this order
            $this->update(['payout_released' => true]);
        });
    }

    /* ---------------- Helpers & Scopes ---------------- */

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending'    => 'yellow',
            'processing' => 'indigo',
            'confirmed'  => 'gray',
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

    public function getDisplayNameAttribute(): string
    {
        return $this->user?->name ?? ($this->customer_name ?: 'Guest');
    }

    public function getDisplayEmailAttribute(): ?string
    {
        return $this->user?->email ?? $this->customer_email;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string)$term);
        if ($term === '') {
            return $query;
        }

        // If the term starts with # (e.g., "#3"), remove the # to get just the ID (3)
        $cleanTerm = str_starts_with($term, '#') ? substr($term, 1) : $term;

        return $query->where(function (Builder $q) use ($term, $cleanTerm) {
            // Now check if $cleanTerm is numeric (works for "3" or "#3")
            if (is_numeric($cleanTerm)) {
                $q->orWhere('id', (int)$cleanTerm);
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