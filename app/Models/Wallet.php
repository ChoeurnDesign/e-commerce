<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'seller_id', // MUST be here
        'balance',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}