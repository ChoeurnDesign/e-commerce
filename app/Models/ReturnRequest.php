<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReturnRequest extends Model
{
    protected $fillable = [
        'reference', 'order_id', 'vendor_order_id', 'user_id', 'seller_id',
        'reason_code', 'reason_description',
        'refund_method', 'refund_amount', 'return_items_required',
        'status',
        'seller_response', 'seller_responded_at',
        'admin_id', 'admin_notes', 'resolved_at',
        'return_tracking_number', 'return_carrier',
        'refund_transaction_id', 'refund_processed_at',
    ];

    protected $casts = [
        'refund_amount'         => 'decimal:2',
        'return_items_required' => 'boolean',
        'seller_responded_at'   => 'datetime',
        'resolved_at'           => 'datetime',
        'refund_processed_at'   => 'datetime',
    ];

    public const REASON_LABELS = [
        'damaged'          => 'Item arrived damaged',
        'wrong_item'       => 'Wrong item received',
        'not_as_described' => 'Not as described',
        'defective'        => 'Defective / not working',
        'changed_mind'     => 'Changed my mind',
        'never_received'   => 'Never received',
        'other'            => 'Other (see description)',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($return) {
            if (empty($return->reference)) {
                $return->reference = 'RTN-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    // ── Relations ────────────────────────────────────────────────────────────

    public function order()        { return $this->belongsTo(Order::class); }
    public function vendorOrder()  { return $this->belongsTo(VendorOrder::class); }
    public function customer()     { return $this->belongsTo(User::class, 'user_id'); }
    public function seller()       { return $this->belongsTo(Seller::class); }
    public function items()        { return $this->hasMany(ReturnRequestItem::class); }
    public function attachments()  { return $this->hasMany(ReturnRequestAttachment::class); }
    public function refund()       { return $this->hasOne(Refund::class); }

    // ── State helpers ────────────────────────────────────────────────────────

    public function isPending(): bool   { return $this->status === 'pending_seller_review'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }
    public function isRefunded(): bool  { return in_array($this->status, ['refunded', 'completed']); }
    public function isClosed(): bool    { return in_array($this->status, ['completed', 'rejected', 'cancelled']); }

    public function reasonLabel(): string
    {
        return self::REASON_LABELS[$this->reason_code] ?? ucfirst($this->reason_code);
    }

    /**
     * Valid status transitions
     */
    public static function allowedTransitions(string $current): array
    {
        return match ($current) {
            'pending_seller_review' => ['approved', 'rejected', 'cancelled'],
            'approved'              => ['in_transit', 'refunded', 'disputed', 'cancelled'],
            'in_transit'            => ['received', 'disputed'],
            'received'              => ['refunded', 'disputed'],
            'refunded'              => ['completed'],
            'rejected'              => ['disputed'],
            'disputed'              => ['approved', 'rejected', 'refunded'],
            default                 => [],
        };
    }

    public function canTransitionTo(string $newStatus): bool
    {
        return in_array($newStatus, static::allowedTransitions($this->status), true);
    }
}
