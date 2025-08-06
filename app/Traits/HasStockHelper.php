<?php

namespace App\Traits;

trait HasStockHelper
{
    public function getInStockAttribute()
    {
        return $this->stock_quantity > 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity > 10) return 'In Stock';
        if ($this->stock_quantity > 0) return 'Low Stock';
        return 'Out of Stock';
    }

    public function getStockStatusColorAttribute()
    {
        if ($this->stock_quantity > 10) return 'success';
        if ($this->stock_quantity > 0) return 'warning';
        return 'danger';
    }

    public function getHasImageAttribute()
    {
        if (!$this->image) return false;

        $paths = [
            'img/products/' . $this->image,
            'images/products/' . $this->image,
            'storage/products/' . $this->image,
        ];

        foreach ($paths as $path) {
            if (file_exists(public_path($path))) return true;
        }

        return false;
    }
}
