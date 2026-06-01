<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\PlatformWallet;
use App\Models\Seller;
use App\Models\Wallet;

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
        'coupon_code',
        'discount_amount',
        'shipped_at',
        'delivered_at',
        'payout_released',
        'payment_proof',
        'payment_reference',
        'payment_verified_by',
        'payment_verified_at',
        'payment_verification_note',
        'payment_fee_amount',
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'total_price'     => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipped_at'      => 'datetime',
        'delivered_at'    => 'datetime',
        'payout_released' => 'boolean',
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

    /**
     * Credit seller wallets with their earnings from this order.
     *
     * IMPORTANT: Vendor orders are created at checkout time by createVendorOrdersFromItems().
     * This method ONLY handles the wallet credit step — it does NOT create/overwrite vendor orders.
     * It runs when an order transitions to "completed" (customer confirms receipt, auto-confirm cron, or admin).
     *
     * The payout_released flag is idempotent — ensures we never double-pay.
     */
    public function distributeVendorEarnings(): void
    {
        // Safety guard: if funds are already released, stop immediately
        if ($this->payout_released) {
            return;
        }

        DB::transaction(function () {
            // SELF-HEAL: For COD orders, ensure platform received the payment BEFORE
            // we pay out the seller. Otherwise platform balance goes negative.
            if ($this->payment_method === 'cash_on_delivery' && $this->payment_status !== 'paid') {
                $this->update(['payment_status' => 'paid']);
                PlatformWallet::getInstance()
                    ->receiveOrderPayment($this, (float) $this->total_price);
                $this->refresh();
            }

            // Load vendor orders for this order (created at checkout)
            $vendorOrders = $this->vendorOrders()->get();

            if ($vendorOrders->isEmpty()) {
                // Fallback: create vendor orders if they don't exist yet (e.g. legacy orders)
                $itemsBySeller = $this->orderItems->groupBy('seller_id');

                foreach ($itemsBySeller as $sellerId => $items) {
                    $subtotal         = round($items->sum('total'), 2);
                    $seller           = Seller::find($sellerId);
                    $commissionRate   = $seller->commission_rate ?? 10.00;
                    $commissionAmount = round($subtotal * ($commissionRate / 100), 2);
                    $sellerEarnings   = round($subtotal - $commissionAmount, 2);

                    $vo = $this->vendorOrders()->create([
                        'seller_id'         => $sellerId,
                        'subtotal'          => $subtotal,
                        'commission_rate'   => $commissionRate,
                        'commission_amount' => $commissionAmount,
                        'seller_earnings'   => $sellerEarnings,
                        'status'            => 'completed',
                        'payout_status'     => 'pending',
                    ]);

                    $vendorOrders->push($vo);
                }
            }

            // Credit each seller's wallet + debit from platform
            $platformWallet = PlatformWallet::getInstance();

            foreach ($vendorOrders as $vendorOrder) {
                if ($vendorOrder->seller_earnings <= 0) continue;

                $seller = Seller::find($vendorOrder->seller_id);
                if ($seller && $seller->user) {
                    // Credit seller wallet (seller_id FK references sellers.id)
                    Wallet::firstOrCreate(
                        ['seller_id' => $seller->id],
                        ['balance' => 0]
                    )->increment('balance', $vendorOrder->seller_earnings);

                    // Debit platform wallet (platform keeps commission)
                    $platformWallet->payoutToSeller(
                        $vendorOrder,
                        (float) $vendorOrder->seller_earnings,
                        (float) $vendorOrder->commission_amount
                    );
                }
            }

            // Flag so we never double-pay
            $this->update(['payout_released' => true]);
        });
    }

    /**
     * Restore stock quantities when an order is cancelled.
     * Each order item's quantity is added back to the product's stock.
     */
    public function restoreStock(): void
    {
        foreach ($this->orderItems as $item) {
            if ($item->product) {
                $item->product->increment('stock_quantity', $item->quantity);
            }
        }
    }

    /**
     * Reverse seller wallet credits when a previously-paid order is cancelled.
     * Only runs if earnings were already distributed (payout_released = true).
     * Deducts seller_earnings from each seller's wallet and marks vendor orders cancelled.
     */
    public function reverseEarnings(): void
    {
        if (!$this->payout_released) {
            return; // Nothing to reverse — earnings were never distributed
        }

        DB::transaction(function () {
            $platformWallet = PlatformWallet::getInstance();

            foreach ($this->vendorOrders as $vendorOrder) {
                // Deduct from seller wallet
                $wallet = Wallet::where('seller_id', $vendorOrder->seller_id)->first();
                if ($wallet && $wallet->balance >= $vendorOrder->seller_earnings) {
                    $wallet->decrement('balance', $vendorOrder->seller_earnings);
                } elseif ($wallet) {
                    $wallet->update(['balance' => 0]);
                }

                // Return money to platform balance (seller payout reversed)
                $platformWallet->increment('balance', $vendorOrder->seller_earnings);
                $platformWallet->decrement('total_paid_out', $vendorOrder->seller_earnings);
                $platformWallet->decrement('total_commission', $vendorOrder->commission_amount);

                // Mark vendor order as cancelled
                $vendorOrder->update(['status' => 'cancelled']);
            }

            // Reset the payout flag
            $this->update(['payout_released' => false]);
        });
    }

    /**
     * Valid order status transitions.
     * Returns the allowed "next" statuses from the current status.
     */
    public static function allowedTransitions(string $currentStatus): array
    {
        return match ($currentStatus) {
            'pending'    => ['processing', 'confirmed', 'cancelled'],
            'processing' => ['confirmed', 'shipped', 'cancelled'],
            'confirmed'  => ['shipped', 'cancelled'],
            'shipped'    => ['delivered', 'cancelled'],
            'delivered'  => ['completed', 'cancelled'],
            'completed'  => [],          // Final state — no transitions allowed
            'cancelled'  => [],          // Final state
            default      => [],
        };
    }

    /**
     * Check if a transition to the given status is valid.
     */
    public function canTransitionTo(string $newStatus): bool
    {
        return in_array($newStatus, static::allowedTransitions($this->status), true);
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

    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'paid'     => 'green',
            'pending'  => 'yellow',
            'failed'   => 'red',
            'refunded' => 'gray',
            default    => 'gray',
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