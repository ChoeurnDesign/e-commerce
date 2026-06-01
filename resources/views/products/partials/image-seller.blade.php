@props(['product' => null, 'image' => null, 'class' => '', 'alt' => null, 'id' => null])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $raw = $image ?? ($product->image ?? null);
    $name = $product->name ?? 'Product';
    
    // Define your default placeholder image
    $placeholder = asset('images/default-product.png');
    $src = $placeholder;

    if ($raw && is_string($raw) && trim($raw) !== '') {
        $path = trim($raw);

        // 1. If it's a full URL (e.g., from an API or remote source)
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $src = $path;
        } 
        // 2. Check Storage/Public paths
        else {
            // Remove 'storage/' prefix if present to check the disk correctly
            $cleanPath = Str::startsWith($path, 'storage/') ? Str::after($path, 'storage/') : $path;

            if (Storage::disk('public')->exists($cleanPath)) {
                $src = asset('storage/' . $cleanPath);
            } elseif (file_exists(public_path($path))) {
                $src = asset($path);
            }
        }
    }
@endphp

<img
    @if($id) id="{{ $id }}" @endif
    src="{{ $src }}"
    alt="{{ $alt ?? $name }}"
    class="{{ $class ?: 'h-10 w-10 rounded-lg object-cover border border-pink-100' }}"
    loading="lazy"
    onerror="this.onerror=null; this.src='{{ $placeholder }}';"
/>