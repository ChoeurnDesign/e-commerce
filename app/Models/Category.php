<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Ensure slug is unique (optional, but recommended)
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

    // Recursive descendants (for nested structures)
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    // All products in this category and all descendants
    public function allProducts()
    {
        $ids = collect([$this->id]);
        $this->collectDescendantIds($ids);
        return Product::whereIn('category_id', $ids);
    }

    private function collectDescendantIds(&$ids): void
    {
        foreach ($this->children as $child) {
            $ids->push($child->id);
            $child->collectDescendantIds($ids);
        }
    }

    // Breadcrumb helper
    public function getBreadcrumb()
    {
        $breadcrumb = collect();
        $current = $this;
        while ($current) {
            $breadcrumb->prepend($current);
            $current = $current->parent;
        }
        return $breadcrumb;
    }

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Computed: total products including subcategories
    public function getTotalProductsCountAttribute(): int
    {
        return $this->allProducts()->active()->count();
    }

    /**
     * Get all categories for global search/filter dropdown.
     */
    public static function allCategoriesForDropdown()
    {
        return static::active()->orderBy('name')->get();
    }
}
