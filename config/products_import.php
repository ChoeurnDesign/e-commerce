<?php

return [
    // Only sellers can import products, upsert by SKU is disabled.
    'upsert_by_sku' => false,

    // Allowed columns for product import.
    'allowed_columns' => [
        'name', 'slug', 'description', 'short_description',
        'price', 'on_sale', 'compare_price', 'sale_price', 'sku',
        'stock_quantity', 'image', 'specifications',
        'is_featured', 'is_active', 'category_id', 'category_name',
        'meta_title', 'meta_description',
    ],

    // Default category for products if none is provided.
    'default_category_id' => 1,

    // Only allow 1 image per product (main image only).
    'max_images' => 1,

    // Fallbacks and deduplication for images are disabled.
    'fallback_gallery_to_images' => false,
    'dedupe_images_gallery' => false,

    // Specification parsing options.
    'spec_line_separators' => [':', '=', '|'],

    // Skip invalid rows during import (do not stop the entire import).
    'skip_invalid_rows' => true,

    // Maximum number of errors allowed before stopping the import.
    'max_errors' => 100,
];