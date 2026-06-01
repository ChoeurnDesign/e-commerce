<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Refund extends Model
{
    protected $fillable = [
        'reference', 'order_id', 'return_request_id',
        'amount', 'payment_method', 'refund_type',
        'status', 'gateway_refund_id', 'failure_reason',
        'processed_by', 'processed_at', 'notes',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($refund) {
            if (empty($refund->reference)) {
                $refund->reference = 'REF-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    public function order()         { return $this->belongsTo(Order::class); }
    public function returnRequest() { return $this->belongsTo(ReturnRequest::class); }
    public function admin()         { return $this->belongsTo(User::class, 'processed_by'); }
}
