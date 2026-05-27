<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'image_alt', 'parent_id', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_url',
        'image_url_with_parent',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // THIS METHOD WAS MISSING, CAUSING YOUR 500 ERROR
    public static function allCategoriesForDropdown()
    {
        return self::all()->pluck('name', 'id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::saving(function ($category) {
            $originalSlug = $category->slug;
            $counter = 2;
            while (static::query()->where('slug', $category->slug)
                ->where('id', '!=', $category->id)
                ->exists()
            ) {
                $category->slug = $originalSlug . '-' . $counter++;
            }
        });

        static::deleting(function (Category $category) {
            if (!empty($category->image) && !filter_var($category->image, FILTER_VALIDATE_URL) && !str_starts_with($category->image, 'http')) {
                try {
                    $disk = config('filesystems.default', 'public');
                    if (Storage::disk($disk)->exists($category->image)) {
                        Storage::disk($disk)->delete($category->image);
                    }
                } catch (\Throwable $e) {
                    // ignore storage errors
                }
            }
        });
    }

    public function products(): HasMany { return $this->hasMany(Product::class); }
    public function parent(): BelongsTo { return $this->belongsTo(Category::class, 'parent_id'); }
    public function children(): HasMany { return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order', 'asc'); }

    public function scopeActive(Builder $query) { return $query->where('is_active', true); }

    public function allProducts()
    {
        return Product::query()->where(function ($query) {
            $query->where('category_id', $this->id)
                  ->orWhereIn('category_id', $this->children()->pluck('id'));
        });
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return \App\Helpers\PlaceholderAvatar::svgDataUri($this->name ?? 'Category', 160, $this->name);
        }

        $path = trim($this->image);
        if (str_starts_with($path, 'http') || filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . $path);
    }

    public function getImageUrlWithParentAttribute(): string
    {
        if (!empty($this->image)) {
            return $this->image_url;
        }

        if ($this->parent) {
            return $this->parent->image_url_with_parent;
        }

        return \App\Helpers\PlaceholderAvatar::svgDataUri($this->name ?? 'Category');
    }

    public function topParentName(): ?string
    {
        $current = $this;
        $safety = 0;
        while ($current->parent && $safety++ < 50) { $current = $current->parent; }
        return $current->name ?? null;
    }
}