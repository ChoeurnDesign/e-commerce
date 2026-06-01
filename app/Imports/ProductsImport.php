<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    protected int   $userId;
    protected ?int  $sellerId;

    // Use distinct names to avoid any conflict with library traits
    protected array $importErrors  = [];
    protected array $importSummary = ['imported' => 0, 'skipped' => 0, 'rows' => 0];

    // Category lookup cache (avoid N+1 DB hits)
    protected array $categoryCache = [];

    // Seller image maps: filename → full stored path
    protected array $mainImageMap    = [];
    protected array $galleryImageMap = [];

    public function __construct(int $userId)
    {
        $this->userId   = $userId;
        $user           = User::find($userId);
        $this->sellerId = $user?->seller?->id;

        // Pre-load all seller images once
        $images = Image::where('user_id', $userId)->get();
        foreach ($images as $img) {
            $filename = basename($img->path);
            if ($img->type === 'main') {
                $this->mainImageMap[$filename] = $img->path;
            } else {
                $this->galleryImageMap[$filename] = $img->path;
            }
        }
    }

    public function model(array $row): ?Product
    {
        $this->importSummary['rows']++;

        $name = trim($row['name'] ?? '');

        // Skip blank rows silently (empty CSV trailing lines)
        if ($name === '') {
            return null;
        }

        // ── Per-row validation ────────────────────────────────────────────────
        $rowErrors = [];

        $price = $this->num($row['price'] ?? null);
        if ($price <= 0) {
            $rowErrors[] = "\"{$name}\": price must be a positive number (got: " . ($row['price'] ?? 'empty') . ").";
        }

        $categoryId = $this->resolveCategory($row);
        if (!$categoryId) {
            $rowErrors[] = "\"{$name}\": category not found — check category_id or category_name.";
        }

        if ($rowErrors) {
            foreach ($rowErrors as $e) {
                $this->importErrors[] = $e;
            }
            $this->importSummary['skipped']++;
            return null;
        }

        // ── Resolve images from gallery ──────────────────────────────────────
        $image   = $this->resolveMainImage($row['image'] ?? null);
        $gallery = $this->resolveGallery($row['gallery'] ?? null);

        // ── Pricing logic ────────────────────────────────────────────────────
        $onSale       = $this->bool($row['on_sale'] ?? false);
        $salePrice    = $this->num($row['sale_price'] ?? null);
        $comparePrice = $this->num($row['compare_price'] ?? null);

        // ── Create product ───────────────────────────────────────────────────
        try {
            $this->importSummary['imported']++;

            return new Product([
                'name'              => $name,
                'slug'              => $this->uniqueSlug($row['slug'] ?? Str::slug($name)),
                'description'       => trim($row['description'] ?? '') ?: 'No description provided',
                'short_description' => trim($row['short_description'] ?? ''),
                'price'             => $price,
                'on_sale'           => $onSale,
                'compare_price'     => ($comparePrice > $price) ? $comparePrice : null,
                'sale_price'        => ($onSale && $salePrice > 0 && $salePrice < $price) ? $salePrice : null,
                'sku'               => $this->uniqueSku($row['sku'] ?? $name),
                'stock_quantity'    => max(0, (int) ($row['stock_quantity'] ?? 0)),
                'image'             => $image,
                'gallery'           => $gallery,
                'specifications'    => $this->parseSpecifications($row['specifications'] ?? null),
                'is_featured'       => $this->bool($row['is_featured'] ?? false),
                'is_active'         => $this->bool($row['is_active'] ?? true),
                'category_id'       => $categoryId,
                'user_id'           => $this->userId,
                'seller_id'         => $this->sellerId,
            ]);
        } catch (\Throwable $e) {
            $this->importSummary['imported']--;
            $this->importSummary['skipped']++;
            $this->importErrors[] = "\"{$name}\": failed to save — " . $e->getMessage();
            return null;
        }
    }

    // ── Public accessors for controller ──────────────────────────────────────

    public function getErrors(): array  { return $this->importErrors; }
    public function getSummary(): array { return $this->importSummary; }

    // ── Helpers ───────────────────────────────────────────────────────────────

    protected function resolveCategory(array $row): ?int
    {
        // Try numeric ID first
        if (!empty($row['category_id']) && is_numeric($row['category_id'])) {
            $id = (int) $row['category_id'];
            if (!array_key_exists($id, $this->categoryCache)) {
                $this->categoryCache[$id] = Category::where('id', $id)->exists() ? $id : null;
            }
            if ($this->categoryCache[$id]) return $this->categoryCache[$id];
        }

        // Fall back to category_name
        if (!empty($row['category_name'])) {
            $cname = trim($row['category_name']);
            $key   = 'n:' . strtolower($cname);
            if (!array_key_exists($key, $this->categoryCache)) {
                $cat = Category::whereRaw('LOWER(name) = ?', [strtolower($cname)])->first();
                $this->categoryCache[$key] = $cat?->id;
            }
            return $this->categoryCache[$key];
        }

        return null;
    }

    /**
     * Resolve image column → full stored path.
     * Accepts: bare filename | storage/ path | https:// URL
     */
    protected function resolveMainImage(?string $raw): ?string
    {
        if (!$raw || !($raw = trim($raw))) return null;

        if (filter_var($raw, FILTER_VALIDATE_URL))    return $raw;
        if (str_starts_with($raw, 'storage/'))        return $raw;

        $filename = basename($raw);
        return $this->mainImageMap[$filename]
            ?? $this->galleryImageMap[$filename]
            ?? null;
    }

    /**
     * Resolve gallery column → array of full stored paths.
     * Accepts pipe (|) or comma (,) separated list.
     */
    protected function resolveGallery(?string $raw): array
    {
        if (!$raw) return [];

        $resolved = [];
        foreach (preg_split('/[|,]/', $raw) as $part) {
            $part = trim($part);
            if (!$part) continue;

            if (filter_var($part, FILTER_VALIDATE_URL)) { $resolved[] = $part; continue; }
            if (str_starts_with($part, 'storage/'))     { $resolved[] = $part; continue; }

            $filename = basename($part);
            $path = $this->galleryImageMap[$filename] ?? $this->mainImageMap[$filename] ?? null;
            if ($path) $resolved[] = $path;
        }

        return $resolved;
    }

    /**
     * Parse specifications: JSON string | "Key: Value" per line | "Key=Value" per line
     */
    protected function parseSpecifications(?string $raw): array
    {
        if (!$raw) return [];

        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return $decoded;

        $out = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            $line = trim($line);
            if (!$line) continue;
            if (str_contains($line, ':')) {
                [$k, $v] = explode(':', $line, 2);
                $out[trim($k)] = trim($v);
            } elseif (str_contains($line, '=')) {
                [$k, $v] = explode('=', $line, 2);
                $out[trim($k)] = trim($v);
            }
        }
        return $out;
    }

    protected function num(mixed $value): float
    {
        if ($value === null || $value === '') return 0.0;
        return is_numeric($value) ? (float) $value : 0.0;
    }

    protected function bool(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    protected function uniqueSlug(string $base): string
    {
        $root  = Str::slug($base) ?: 'product';
        $slug  = $root;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$root}-{$count}";
            $count++;
        }
        return $slug;
    }

    protected function uniqueSku(string $base): string
    {
        $root  = Str::limit(Str::slug($base), 90, '');
        $sku   = $root;
        $count = 1;
        while (Product::where('sku', $sku)->exists()) {
            $sku = "{$root}-{$count}";
            $count++;
        }
        return $sku;
    }
}
