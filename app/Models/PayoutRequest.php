<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayoutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'amount',
        'bank_name',
        'account_name',
        'account_number',
        'phone',
        'seller_note',
        'status',
        'processed_by',
        'processed_at',
        'transaction_reference',
        'admin_note',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /* Status helpers */
    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isPaid(): bool      { return $this->status === 'paid'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'  => 'amber',
            'approved' => 'blue',
            'paid'     => 'emerald',
            'rejected' => 'rose',
            default    => 'gray',
        };
    }
}
