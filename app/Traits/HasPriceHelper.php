<?php

namespace App\Traits;

trait HasPriceHelper
{
    public function getCurrentPriceAttribute()
    {
        return $this->price;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) return 0;
        return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }

    public function getSavingsAttribute()
    {
        if (!$this->is_on_sale) return 0;
        return $this->compare_price - $this->price;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
