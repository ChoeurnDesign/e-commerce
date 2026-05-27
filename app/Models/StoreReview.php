<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class StoreReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_id',
        'rating',
        'comment',
        'is_approved',
    ];

    
    protected $attributes = [
        'is_approved' => false,
    ];

    
    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];

    
    protected static function booted()
    {
        static::creating(function (self $review) {
            if (! isset($review->is_approved) || is_null($review->is_approved)) {
                $review->is_approved = false;
            }
        });
    }

    // Relationships

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function seller()
    {
        $sellerClass = class_exists(\App\Models\Seller::class)
            ? \App\Models\Seller::class
            : \App\Models\User::class;

        return $this->belongsTo($sellerClass, 'seller_id');
    }

    
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    
    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    
    public function excerpt($length = 150)
    {
        return Str::limit($this->comment, $length);
    }
}