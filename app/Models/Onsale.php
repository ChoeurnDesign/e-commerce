<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Onsale extends Product
{
    protected $table = 'products';

    protected static function booted(): void
    {
        static::addGlobalScope('on_sale', fn(Builder $q) => $q->where('on_sale', 1));
    }

    // Extra optional filters (do not conflict with existing scopes in traits)
    public function scopeWithMinDiscount(Builder $q, int $percent): Builder
    {
        $percent = max(0, min(100, $percent));
        return $q->whereRaw(
            '(price > 0 AND sale_price IS NOT NULL AND (100 - (sale_price / price * 100)) >= ?)',
            [$percent]
        );
    }

    public function scopeSalePriceBetween(Builder $q, ?float $min = null, ?float $max = null): Builder
    {
        if ($min !== null) $q->where('sale_price', '>=', $min);
        if ($max !== null) $q->where('sale_price', '<=', $max);
        return $q;
    }

    // Accessor already added in Product; keep only if Product does NOT have it.
    public function getDiscountPercentAttribute(): ?int
    {
        if (!$this->sale_price || !$this->price || (float)$this->price == 0) return null;
        return (int) round(100 - ($this->sale_price / $this->price * 100));
    }

    public function removeFromSale(): self
    {
        $this->on_sale = 0;
        $this->sale_price = null;
        $this->save();
        return $this;
    }
}
