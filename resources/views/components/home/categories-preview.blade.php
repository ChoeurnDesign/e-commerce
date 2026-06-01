{{-- Top Categories — horizontal scroll, card style with images --}}
@props(['categories' => collect()])

@if($categories && $categories->count() > 0)
@php
    $gradients = [
        ['a' => '#F97316', 'b' => '#FB923C'],
        ['a' => '#3B82F6', 'b' => '#60A5FA'],
        ['a' => '#10B981', 'b' => '#34D399'],
        ['a' => '#8B5CF6', 'b' => '#A78BFA'],
        ['a' => '#EC4899', 'b' => '#F472B6'],
        ['a' => '#F59E0B', 'b' => '#FCD34D'],
        ['a' => '#14B8A6', 'b' => '#2DD4BF'],
        ['a' => '#EF4444', 'b' => '#F87171'],
        ['a' => '#6366F1', 'b' => '#818CF8'],
        ['a' => '#84CC16', 'b' => '#A3E635'],
    ];
@endphp
<div>
    {{-- Section header --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base sm:text-lg font-extrabold text-gray-900">
            {{ __('Top Categories') }}
        </h2>
        <a href="{{ route('categories.index') }}"
           class="inline-flex items-center gap-1 text-sm font-semibold
                  text-orange-500 hover:text-orange-600 transition-colors">
            {{ __('View All') }}
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Horizontal scroll row --}}
    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($categories->take(12) as $idx => $category)
        @php
            $grad = $gradients[$idx % count($gradients)];
            $initial = strtoupper(substr($category->name, 0, 1));
        @endphp
        <a href="{{ route('category.show', $category->slug) }}"
           class="group flex flex-col flex-shrink-0 w-28 rounded-xl overflow-hidden
                  bg-white border border-rose-100
                  hover:border-pink-300
                  hover:shadow-md transition-all duration-200">

            {{-- Image area --}}
            @php
                // Resolve image: full URL → use as-is; bare path → storage/; else none
                $catImg = null;
                if (!empty($category->image)) {
                    $catImg = filter_var($category->image, FILTER_VALIDATE_URL)
                        ? $category->image
                        : asset('storage/' . ltrim($category->image, '/'));
                }
            @endphp
            <div class="relative w-full h-24 overflow-hidden">
                {{-- Gradient-initial fallback (always present, behind the image) --}}
                <div class="absolute inset-0 flex items-center justify-center text-white text-2xl font-extrabold"
                     style="background: linear-gradient(135deg, {{ $grad['a'] }}, {{ $grad['b'] }})">
                    {{ $initial }}
                </div>
                @if($catImg)
                    <img src="{{ $catImg }}"
                         alt="{{ $category->name }}"
                         class="relative w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy"
                         onerror="this.style.display='none'">
                @endif
            </div>

            {{-- Name & count --}}
            <div class="px-2 py-2 text-center">
                <p class="text-[11px] font-semibold text-gray-700 truncate
                           group-hover:text-pink-500 transition-colors leading-tight">
                    {{ $category->name }}
                </p>
                @if(($category->products_count ?? 0) > 0)
                <p class="text-[10px] text-gray-400 mt-0.5">
                    {{ number_format($category->products_count) }} {{ __('items') }}
                </p>
                @endif
            </div>

        </a>
        @endforeach
    </div>
</div>
@endif
