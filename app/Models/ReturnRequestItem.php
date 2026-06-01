<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequestItem extends Model
{
    protected $fillable = [
        'return_request_id', 'order_item_id', 'quantity', 'unit_refund', 'line_refund',
    ];

    protected $casts = [
        'unit_refund' => 'decimal:2',
        'line_refund' => 'decimal:2',
    ];

    public function returnRequest() { return $this->belongsTo(ReturnRequest::class); }
    public function orderItem()     { return $this->belongsTo(OrderItem::class); }
}
