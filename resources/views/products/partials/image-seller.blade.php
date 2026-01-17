@props(['product' => null, 'image' => null, 'class' => '', 'alt' => null, 'id' => null])

@php
    use Illuminate\Support\Str;
    $raw = $image ?? ($product->image ?? null);
    $name = $product->name ?? 'Product';
    $placeholder = 'https://via.placeholder.com/800x800?text=' . urlencode(Str::limit($name, 12, ''));
    $src = $placeholder;

    if (is_string($raw) && trim($raw) !== '') {
        $p = trim($raw, "\"' \t\n\r\0\x0B");
        $p = str_replace('\\', '/', $p);
        $p = ltrim($p, './');
        if (preg_match('#^https?://#i', $p)) {
            $src = $p; // remote image
        } elseif (str_starts_with($p, 'storage/')) {
            $relative = Str::after($p, 'storage/');
            // ✅ Accept either the public disk (storage/app/public) OR the public symlink (public/storage)
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relative) || file_exists(public_path($p))) {
                $src = asset($p);
            }
        } else {
            if (file_exists(public_path($p))) {
                $src = asset($p);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($p)) {
                $src = asset('storage/'.$p);
            }
        }
    }
@endphp

<img
    @if($id) id="{{ $id }}" @endif
    src="{{ $src }}"
    alt="{{ $alt ?? $name }}"
    class="{{ $class ?: 'h-10 w-10 rounded-lg object-cover border border-gray-100 dark:border-[#23263a]' }}"
    loading="lazy"
    onerror="this.onerror=null;this.src='{{ $placeholder }}';"
/>
