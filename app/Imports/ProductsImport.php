<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    protected int $userId;
    protected ?int $sellerId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $user = User::find($userId);
        // Ensure we retrieve the seller ID. If no seller exists, this remains null 
        // which will be caught in the model method if necessary.
        $this->sellerId = $user->seller?->id;
    }

    public function model(array $row)
    {
        $name = trim($row['name'] ?? '');
        
        // Skip empty rows
        if ($name === '') {
            return null;
        }

        // We explicitly define all fields. 
        // Using '??' with sensible defaults prevents SQL errors.
        return new Product([
            'name'              => $name,
            'slug'              => $this->uniqueSlug($row['slug'] ?? Str::slug($name)),
            'description'       => $row['description'] ?? 'No description provided',
            'short_description' => $row['short_description'] ?? '',
            'price'             => $this->num($row['price'] ?? 0),
            'on_sale'           => $this->bool($row['on_sale'] ?? false),
            'compare_price'     => $this->num($row['compare_price'] ?? 0),
            'sale_price'        => $this->num($row['sale_price'] ?? 0),
            'sku'               => $this->uniqueSku($row['sku'] ?? $name),
            'stock_quantity'    => (int)($row['stock_quantity'] ?? 0),
            'image'             => $row['image'] ?? null,
            'specifications'    => $row['specifications'] ?? [],
            'gallery'           => $row['gallery'] ?? null,
            'is_featured'       => $this->bool($row['is_featured'] ?? false),
            'is_active'         => $this->bool($row['is_active'] ?? true),
            'category_id'       => (int)($row['category_id'] ?? 1),
            'user_id'           => $this->userId,
            'seller_id'         => $this->sellerId,
        ]);
    }

    protected function num($value): float 
    { 
        return is_numeric($value) ? (float)$value : 0.0; 
    }

    protected function bool($value): bool 
    { 
        return filter_var($value, FILTER_VALIDATE_BOOLEAN); 
    }

    protected function uniqueSlug(string $slug): string
    {
        $base = Str::slug($slug);
        $slug = $base; 
        $count = 1;
        while (Product::where('slug', $slug)->exists()) { 
            $slug = "{$base}-{$count}"; 
            $count++; 
        }
        return $slug;
    }

    protected function uniqueSku(string $sku): string
    {
        $base = Str::slug($sku);
        // Limit SKU length to avoid database overflow if name is too long
        $base = Str::limit($base, 90, ''); 
        $sku = $base; 
        $count = 1;
        while (Product::where('sku', $sku)->exists()) { 
            $sku = "{$base}-{$count}"; 
            $count++; 
        }
        return $sku;
    }
}