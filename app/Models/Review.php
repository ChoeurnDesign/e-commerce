<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];

    /**
     * Get the user that wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being reviewed
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Get rating with stars
     */
    public function getRatingStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    public function scopeSearch($query, ?string $term)
    {
        $term = trim((string)$term);
        if ($term === '') return $query;

        return $query->where(function($q) use ($term) {
            if (ctype_digit($term)) {
                $q->orWhere('id', (int)$term)
                ->orWhere('rating', (int)$term);
            }
            $q->orWhere('comment','like',"%{$term}%")
            ->orWhereHas('product', function($p) use ($term){
                $p->where('name','like',"%{$term}%");
            })
            ->orWhereHas('user', function($u) use ($term){
                $u->where('name','like',"%{$term}%")
                    ->orWhere('email','like',"%{$term}%");
            });
        });
    }
}
