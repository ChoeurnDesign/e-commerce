<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    protected int $userId; // Seller ID

    public function __construct(int $userId)
    {
        $this->userId = $userId; // Assign user ID dynamically
    }

    public function model(array $row)
    {
        $name = trim($row['name'] ?? '');
        if ($name === '') return null; // Ensure name is not empty

        $price        = $this->num($row['price'] ?? 0);
        $comparePrice = $this->num($row['compare_price'] ?? 0);
        $onSale       = $this->bool($row['on_sale'] ?? 0);
        $salePrice    = $this->num($row['sale_price'] ?? 0);
        $stockQty     = (int)($row['stock_quantity'] ?? 0);
        $isFeatured   = $this->bool($row['is_featured'] ?? 0);
        $isActive     = $this->bool($row['is_active'] ?? 1);
        $categoryId   = (int)($row['category_id'] ?? 1);

        $folderMain   = "products/seller/seller_{$this->userId}/main";
        $folderGallery = "products/seller/seller_{$this->userId}/gallery";

        // Process main image path
        $imageCol = trim((string)($row['image'] ?? ''));
        $image = $this->normalizePath($imageCol, $folderMain);

        if (!$image) {
            $image = 'https://via.placeholder.com/800x800?text=' . urlencode($name);
        }

        // Process gallery images
        $galleryRaw = $row['gallery'] ?? '';
        $galleryArr = $this->parseList($galleryRaw);
        $gallery = array_values(array_filter(array_map(
            fn($g) => $this->normalizePath($g, $folderGallery),
            $galleryArr
        )));

        // Parse specifications
        $specifications = $this->parseSpecifications($row['specifications'] ?? '');

        return new Product([
            'name'              => $name,
            'slug'              => $this->uniqueSlug($row['slug'] ?? Str::slug($name)),
            'description'       => (string)($row['description'] ?? ''),
            'short_description' => (string)($row['short_description'] ?? ''),
            'price'             => $price,
            'on_sale'           => $onSale,
            'compare_price'     => $comparePrice,
            'sale_price'        => $salePrice,
            'sku'               => $this->uniqueSku($row['sku'] ?? $name),
            'stock_quantity'    => $stockQty,
            'image'             => $image,
            'specifications'    => $specifications,
            'gallery'           => $gallery,
            'is_featured'       => $isFeatured,
            'is_active'         => $isActive,
            'category_id'       => $categoryId,
            'user_id'           => $this->userId, // Assign to seller
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

    protected function normalizePath(string $path, string $folder): string
    {
        $path = trim($path);
        $normalizedPath = "{$folder}/" . ltrim($path, '/');
        $fullPath = public_path("storage/{$normalizedPath}");

        // Return the normalized path only if the file exists
        return file_exists($fullPath) ? "storage/{$normalizedPath}" : '';
    }

    protected function parseList(string $raw): array
    {
        return array_map('trim', preg_split('/[|,]/', $raw, -1, PREG_SPLIT_NO_EMPTY));
    }

    protected function parseSpecifications($raw): array
    {
        if (!$raw) return [];
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return $decoded;

        $lines = array_filter(array_map('trim', preg_split('/\r\n|\n|\r/', $raw)));
        $out = [];
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $out[trim($key)] = trim($value);
            }
        }
        return $out;
    }

    protected function uniqueSlug(string $slug): string
    {
        $baseSlug = Str::slug($slug);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    protected function uniqueSku(string $sku): string
    {
        $baseSku = Str::slug($sku);
        $sku = $baseSku;
        $counter = 1;

        while (Product::where('sku', $sku)->exists()) {
            $sku = "{$baseSku}-{$counter}";
            $counter++;
        }

        return $sku;
    }
}