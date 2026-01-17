<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'image_alt',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Include image_url in arrays/JSON for easy use in views
    protected $appends = [
        'image_url',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Ensure slug uniqueness on save
        static::saving(function ($category) {
            $originalSlug = $category->slug;
            $counter = 2;
            while (static::where('slug', $category->slug)
                ->where('id', '!=', $category->id)
                ->exists()
            ) {
                $category->slug = $originalSlug . '-' . $counter++;
            }
        });

        // Delete stored image when category deleted (if not an external URL)
        static::deleting(function (Category $category) {
            if (!empty($category->image) && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                try {
                    $disk = config('filesystems.default', 'public');
                    if (Storage::disk($disk)->exists($category->image)) {
                        Storage::disk($disk)->delete($category->image);
                    }
                } catch (\Throwable $e) {
                    // ignore storage errors (do not block deletion)
                }
            }
        });
    }

    // Relationships
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function allProducts()
    {
        return Product::query()
            ->where(function ($query) {
                $query->where('category_id', $this->id) // Products for this category
                    ->orWhereIn('category_id', $this->children()->pluck('id')); // Products for subcategories
            });
    }

    // Return a usable image URL for this category (no parent fallback).
    // Priority: external URL -> storage key -> placeholder (seeded from top parent)
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image) && filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if (!empty($this->image)) {
            try {
                // Generate URL for image in public/storage/categories directory
                return asset('storage/' . $this->image);
            } catch (\Throwable $e) {
                // Fall through to placeholder
            }
        }

        return \App\Helpers\PlaceholderAvatar::svgDataUri($this->name ?? 'Category', 160, $this->name);
    }

    // Find the top-most parent name (used as color seed)
    public function topParentName(): ?string
    {
        $current = $this;
        // walk up until no parent (avoid endless loops if data is corrupt)
        $safety = 0;
        while ($current->parent && $safety++ < 50) {
            $current = $current->parent;
        }
        return $current->name ?? null;
    }

    // Returns image for this category or falls back recursively to parent; finally a placeholder.
    public function getImageUrlWithParentAttribute(): string
    {
        if (!empty($this->image) && filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if (!empty($this->image)) {
            try {
                // Generate URL for image in public/storage/categories directory
                return asset('storage/' . $this->image);
            } catch (\Throwable $e) {
                // ignore and continue
            }
        }

        if ($this->parent) {
            return $this->parent->image_url_with_parent;
        }

        // final fallback placeholder
        return \App\Helpers\PlaceholderAvatar::svgDataUri($this->name ?? 'Category');
    }
}