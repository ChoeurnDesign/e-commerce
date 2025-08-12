<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'exchange_rates';

    protected $fillable = [
        'code',   // Example: 'USD', 'EUR'
        'rate',   // Example: 1.00, 0.92, etc.
    ];

    public $timestamps = true;
}
