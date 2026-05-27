<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'seller_id',
        'subtotal',
        'commission_rate',
        'commission_amount',
        'seller_earnings',
        'status',
        'payout_status',
        'stripe_account_id',
        'stripe_transfer_id',
        'paid_out_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'seller_earnings' => 'decimal:2',
        'paid_out_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id')
                ->where('seller_id', $this->seller_id);
    }
    
    public function canBePaidOut(): bool
    {
        return $this->payout_status === 'pending' && 
               !empty($this->stripe_account_id) && 
               is_null($this->stripe_transfer_id);
    }
}