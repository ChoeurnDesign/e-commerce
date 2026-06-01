<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerWallet extends Model
{
    protected $fillable = ['user_id', 'balance', 'lifetime_credit'];

    protected $casts = [
        'balance'         => 'decimal:2',
        'lifetime_credit' => 'decimal:2',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public static function forUser(int $userId): self
    {
        return static::firstOrCreate(['user_id' => $userId], ['balance' => 0, 'lifetime_credit' => 0]);
    }

    public function addCredit(float $amount): void
    {
        $this->increment('balance', $amount);
        $this->increment('lifetime_credit', $amount);
    }

    public function deductCredit(float $amount): bool
    {
        if ($this->balance < $amount) return false;
        $this->decrement('balance', $amount);
        return true;
    }
}
