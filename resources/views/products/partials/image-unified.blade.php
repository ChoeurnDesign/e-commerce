@php
    $image = $product->image ?? null;
    // Remove accidental 'public/' prefix if present (shouldn't be stored, but just in case)
    if ($image && str_starts_with($image, 'public/')) {
        $image = substr($image, 7);
    }
    $isStorage = $image && (str_starts_with($image, '/storage') || str_starts_with($image, 'storage/'));
    $isHttp = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));

    if ($isHttp) {
        $src = $image;
    } elseif ($isStorage) {
        $src = $image;
    } elseif ($image) {
        $src = asset($image);
    } else {
        $src = 'https://via.placeholder.com/80x80?text=' . urlencode($product->name ?? 'Product');
    }
@endphp

<img
    src="{{ $src }}"
    alt="{{ $product->name }}"
    class="h-10 w-10 rounded-lg object-cover border border-gray-100 dark:border-[#23263a]"
    loading="lazy"
/>
