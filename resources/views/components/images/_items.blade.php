{{-- Partial: renders only the .group items (used by AJAX load) --}}
@php use Illuminate\Support\Str; @endphp
@foreach($images as $img)
    @php
        $url = asset($img->path);
        $filename = Str::afterLast($img->path, '/');
        $isMain = ($img->type ?? '') === 'main';
        $badgeText = $isMain ? 'Main' : 'Gallery';
        $badgeColor = $isMain ? 'bg-blue-600 text-white' : 'bg-purple-100 text-purple-700';
    @endphp

    <div class="group relative border rounded-2xl overflow-hidden shadow-md bg-white">
        <div class="w-full bg-gray-100">
            <div class="aspect-[4/3] overflow-hidden">
                <img src="{{ $url }}" alt="{{ $filename }}"
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
            </div>
        </div>

        <div class="p-4 space-y-3">
            <div class="flex items-center justify-between">
                <span class="inline-flex px-2.5 py-0.5 text-[11px] font-semibold rounded-full {{ $badgeColor }}">{{ $badgeText }}</span>
                <div class="flex items-center gap-2 opacity-80 group-hover:opacity-100 transition">
                    <button type="button" class="text-xs px-2.5 py-1 rounded bg-gray-100 hover:bg-gray-100" data-copy="{{ $filename }}" title="Copy filename">Copy name</button>
                    <button type="button" class="text-xs px-2.5 py-1 rounded bg-gray-100 hover:bg-gray-100" data-copy="{{ $url }}" title="Copy full URL">Copy URL</button>
                </div>
            </div>

            <div class="text-sm font-mono text-gray-800 truncate" title="{{ $filename }}">{{ $filename }}</div>

            @if(!empty($img->created_at))
                <div class="text-[11px] text-gray-500">{{ $img->created_at->format('Y-m-d H:i') }}</div>
            @endif

            <div class="pt-1 flex items-center justify-between">
                <a href="{{ $url }}" target="_blank" class="text-sm text-pink-600 hover:text-pink-800">Open</a>

                {{-- Delete route is not available inside this partial; when used via AJAX append to existing component DOM, delete forms will work because the form action was present originally. If you need delete forms in AJAX output, include route param and render forms. --}}
            </div>
        </div>

        <div class="pointer-events-none absolute inset-0 ring-0 group-hover:ring-2 group-hover:ring-pink-400/40 rounded-2xl transition"></div>
    </div>
@endforeach