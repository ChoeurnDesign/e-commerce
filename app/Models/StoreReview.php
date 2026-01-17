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

    /**
     * Default attribute values.
     * Ensures new reviews default to unapproved at the model level.
     */
    protected $attributes = [
        'is_approved' => false,
    ];

    /**
     * Casts
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Boot the model.
     * Only set is_approved to false when it is not explicitly provided.
     */
    protected static function booted()
    {
        static::creating(function (self $review) {
            if (! isset($review->is_approved) || is_null($review->is_approved)) {
                $review->is_approved = false;
            }
        });
    }

    // Relationships

    /**
     * The user who wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Seller relationship.
     *
     * This method attempts to support both common application shapes:
     * - If you have an App\Models\Seller model, store_reviews.seller_id may reference that table.
     * - If sellers are stored in the users table, seller_id may reference App\Models\User.
     *
     * We detect which class exists at runtime and use it so the relationship works in either setup.
     */
    public function seller()
    {
        $sellerClass = class_exists(\App\Models\Seller::class)
            ? \App\Models\Seller::class
            : \App\Models\User::class;

        return $this->belongsTo($sellerClass, 'seller_id');
    }

    /**
     * Scope to easily filter only approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to filter reviews for a specific seller id.
     */
    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    /**
     * Helper: return short excerpt of the comment
     */
    public function excerpt($length = 150)
    {
        return Str::limit($this->comment, $length);
    }
}