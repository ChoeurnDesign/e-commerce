@props([
    'title'           => 'Images',
    'images'          => null,
    'deleteRoute'     => null,
    'deleteRouteName' => null,
    'cols'            => 4,
    'infinite'        => false,
])

@php
    use Illuminate\Support\Str;
    $images      = $images ?? collect();
    $deleteRoute = $deleteRoute ?? $deleteRouteName;
    $gridLgCols  = [1=>'lg:grid-cols-1',2=>'lg:grid-cols-2',3=>'lg:grid-cols-3',4=>'lg:grid-cols-4'][$cols] ?? 'lg:grid-cols-4';
    $isPaginated = method_exists($images, 'links');
@endphp

<div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-gray-900">{{ $title }}</h2>
        <span class="text-xs text-gray-400 bg-pink-50 px-2 py-1 rounded-full">
            {{ $images->count() }} image{{ $images->count() !== 1 ? 's' : '' }}
        </span>
    </div>

    @if($images->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 {{ $gridLgCols }} gap-4 images-items"
             data-infinite="{{ $infinite ? '1' : '0' }}"
             data-type="{{ $images->first()->type ?? '' }}">
            @foreach($images as $img)
            @php
                $url      = asset($img->path);
                $filename = basename($img->path);
                $isMain   = ($img->type ?? '') === 'main';
            @endphp

            <div class="group relative bg-white border border-pink-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:border-pink-300 transition-all duration-200">

                {{-- Thumbnail --}}
                <div class="aspect-square overflow-hidden bg-gray-50">
                    <img src="{{ $url }}" alt="{{ $filename }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='https://placehold.co/200x200/fce7f3/db2777?text=?'">
                </div>

                {{-- Badge --}}
                <div class="absolute top-2 left-2">
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $isMain ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                        {{ $isMain ? 'Main' : 'Gallery' }}
                    </span>
                </div>

                {{-- Info panel --}}
                <div class="p-3 space-y-2">
                    {{-- Filename --}}
                    <p class="text-xs font-mono text-gray-700 truncate" title="{{ $filename }}">{{ $filename }}</p>

                    @if(!empty($img->created_at))
                        <p class="text-[10px] text-gray-400">{{ $img->created_at->format('d M Y, H:i') }}</p>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-1.5 pt-1">
                        {{-- Copy filename --}}
                        <button type="button"
                                data-copy="{{ $filename }}"
                                class="flex-1 text-[11px] font-medium px-2 py-1 rounded-lg bg-pink-50 text-pink-700 hover:bg-pink-100 transition text-center">
                            Copy Name
                        </button>

                        {{-- Open --}}
                        <a href="{{ $url }}" target="_blank"
                           class="px-2 py-1 rounded-lg bg-gray-50 hover:bg-gray-100 transition"
                           title="Open full image">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                        {{-- Delete --}}
                        @if($deleteRoute)
                        <form action="{{ route($deleteRoute) }}" method="POST" class="inline"
                              onsubmit="return confirmDeleteImage(event, this)">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $img->id }}">
                            <button type="submit"
                                    class="px-2 py-1 rounded-lg bg-red-50 hover:bg-red-100 transition"
                                    title="Delete image">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                {{-- Hover ring --}}
                <div class="pointer-events-none absolute inset-0 ring-0 group-hover:ring-2 group-hover:ring-pink-400/40 rounded-xl transition"></div>
            </div>
            @endforeach
        </div>

        @if($isPaginated && !$infinite)
            <div class="mt-6">{{ $images->withQueryString()->links() }}</div>
        @endif
    @else
        <div class="text-center py-12 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">No images uploaded yet.</p>
        </div>
    @endif
</div>

@once
@push('scripts')
<script>
(function () {
    // ── Copy button ──────────────────────────────────────────────────────────
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-copy]');
        if (!btn) return;
        const text = btn.dataset.copy;
        const fallback = () => {
            const ta = document.createElement('textarea');
            ta.value = text; document.body.appendChild(ta); ta.select();
            try { document.execCommand('copy'); } catch(err) {}
            document.body.removeChild(ta);
        };
        navigator.clipboard ? navigator.clipboard.writeText(text).catch(fallback) : fallback();
        const orig = btn.textContent;
        btn.textContent = '✓ Copied!';
        btn.classList.add('bg-green-100', 'text-green-700');
        setTimeout(() => {
            btn.textContent = orig;
            btn.classList.remove('bg-green-100', 'text-green-700');
        }, 1200);
    });

    // ── Infinite scroll ──────────────────────────────────────────────────────
    async function fetchNextPage(container, page) {
        const type = container.dataset.type || '';
        const url  = new URL("{{ url('seller/images/load') }}", window.location.origin);
        url.searchParams.set('type', type);
        url.searchParams.set('page', page);
        try {
            const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            return res.ok ? res.text() : null;
        } catch (e) { return null; }
    }

    function setupInfiniteFor(container) {
        if (!container || container.dataset.infinite !== '1') return;
        let nextPage = 2;
        const observer = new IntersectionObserver(async (entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;
                const html = await fetchNextPage(container, nextPage);
                if (!html) { observer.disconnect(); return; }
                const tmp = document.createElement('div');
                tmp.innerHTML = html;
                const items = tmp.querySelectorAll('.group');
                if (!items.length) { observer.disconnect(); return; }
                items.forEach(i => container.appendChild(i));
                nextPage++;
            }
        }, { rootMargin: '300px' });

        const watch = () => { const last = container.lastElementChild; if (last) observer.observe(last); };
        watch();
        new MutationObserver(watch).observe(container, { childList: true });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.images-items').forEach(setupInfiniteFor);
    });
})();

// ── Delete confirmation (SweetAlert2) ────────────────────────────────────────
function confirmDeleteImage(event, form) {
    event.preventDefault();
    if (typeof Swal === 'undefined') { form.submit(); return false; }
    Swal.fire({
        title: 'Delete image?',
        text: 'This cannot be undone. If this image is used by a product, it will no longer display.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
    }).then(result => { if (result.isConfirmed) form.submit(); });
    return false;
}
</script>
@endpush
@endonce
