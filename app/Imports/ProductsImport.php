<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'] ?? '',
            'slug' => $row['slug'] ?? Str::slug($row['name'] ?? ''),
            'description' => $row['description'] ?? '',
            'short_description' => $row['short_description'] ?? '',
            'price' => $row['price'] ?? 0,
            'on_sale' => $row['on_sale'] ?? 0,
            'compare_price' => $row['compare_price'] ?? 0,
            'sale_price' => $row['sale_price'] ?? 0,
            'sku' => $row['sku'] ?? '',
            'stock_quantity' => $row['stock_quantity'] ?? 0,
            'image' => $row['image'] ?? '',
            'images' => $row['images'] ?? '',
            'specifications' => $row['specifications'] ?? '',
            'gallery' => $row['gallery'] ?? '',
            'is_featured' => $row['is_featured'] ?? 0,
            'is_active' => $row['is_active'] ?? 1,
            'category_id' => $row['category_id'] ?? 1,
            // Do NOT set created_at/updated_at
        ]);
    }
}
