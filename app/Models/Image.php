<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
        'path',
        'user_id',
        'type',
        'alt',
        'product_id',
        'original_filename',
    ];

    // Uploader relation
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Related product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}