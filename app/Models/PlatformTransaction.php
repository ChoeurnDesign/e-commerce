<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformTransaction extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'balance_after',
        'description',
        'order_id',
        'seller_id',
        'payout_request_id',
        'admin_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
