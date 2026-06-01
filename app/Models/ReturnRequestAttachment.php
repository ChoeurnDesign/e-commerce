<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequestAttachment extends Model
{
    protected $fillable = [
        'return_request_id', 'path', 'original_name', 'type',
    ];

    public function returnRequest() { return $this->belongsTo(ReturnRequest::class); }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . ltrim($this->path, '/'));
    }
}
