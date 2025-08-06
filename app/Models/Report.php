<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'product_id',
        'images',
        'is_read',
    ];

    protected $casts = [
        'images' => 'array',
        'is_read' => 'boolean',
    ];

    // Optional: relationship to Product if needed
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
