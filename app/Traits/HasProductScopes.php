<?php

namespace App\Traits;

trait HasProductScopes
{
    public function scopeActive($query)
    {
        return $query->where('products.is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('products.is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('products.stock_quantity', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('products.compare_price')
            ->whereColumn('products.compare_price', '>', 'products.price');
    }

    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }

        // Create a cleaned version for ID checking (removes '#' if present)
        $cleanTerm = ltrim($term, '#');

        return $query->where(function ($q) use ($term, $cleanTerm) {
            // Search text fields using the full term (including # if user typed it)
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhere('slug', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");

            // Search by ID only if the cleaned term is numeric
            if (is_numeric($cleanTerm)) {
                $q->orWhere('id', (int)$cleanTerm);
            }
        });
    }
}