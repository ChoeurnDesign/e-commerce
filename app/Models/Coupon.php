<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'funded_by',
        'min_order_amount',
        'max_uses',
        'used_count',
        'is_active',
        'expiry_date',
    ];

    protected $casts = [
        'discount_value'    => 'decimal:2',
        'min_order_amount'  => 'decimal:2',
        'is_active'         => 'boolean',
        'expiry_date'       => 'datetime',
        'max_uses'          => 'integer',
        'used_count'        => 'integer',
    ];

    public function isValid(float $subtotal): bool
    {
        if (!$this->is_active) return false;
        if ($this->expiry_date && $this->expiry_date->isPast()) return false;
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) return false;
        if ($subtotal < (float) $this->min_order_amount) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percentage') {
            return round($subtotal * ((float) $this->discount_value / 100), 2);
        }
        return min((float) $this->discount_value, $subtotal);
    }
}
