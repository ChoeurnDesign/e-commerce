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
        // Helper for parsing array fields from CSV/Excel
        $parseArray = function ($value) {
            if (empty($value)) return [];
            // Try decode JSON, fallback to explode by comma
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            if (is_string($value) && strpos($value, ',') !== false) {
                return array_map('trim', explode(',', $value));
            }
            return [$value];
        };

        // Specifications: can be JSON, key:value lines, or comma-separated
        $parseSpecifications = function ($value) {
            if (empty($value)) return [];
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            // Try key:value lines
            $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value)));
            $arr = [];
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    [$key, $val] = explode(':', $line, 2);
                    $arr[trim($key)] = trim($val);
                }
            }
            if (!empty($arr)) return $arr;
            // Fallback: comma-separated
            if (strpos($value, ',') !== false) {
                return array_map('trim', explode(',', $value));
            }
            return [$value];
        };

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
            'images' => $parseArray($row['images'] ?? ''),
            'specifications' => $parseSpecifications($row['specifications'] ?? ''),
            'gallery' => $parseArray($row['gallery'] ?? ''),
            'is_featured' => $row['is_featured'] ?? 0,
            'is_active' => $row['is_active'] ?? 1,
            'category_id' => $row['category_id'] ?? 1,
            // Do NOT set created_at/updated_at
        ]);
    }
}
