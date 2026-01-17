@props(['parentCategories' => null, 'title' => 'Categories'])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $categories = collect($parentCategories ?? [])->map(function($c){
        // Determine image URL: full URL, storage URL, or SVG placeholder
        $imageUrl = null;
        if (!empty($c->image) && filter_var($c->image, FILTER_VALIDATE_URL)) {
            $imageUrl = $c->image;
        } elseif (!empty($c->image)) {
            try {
                // Use asset() to generate URL for public/storage/categories
                $imageUrl = asset('storage/' . $c->image);
            } catch (\Throwable $e) {
                $imageUrl = null;
            }
        }

        if (!$imageUrl) {
            // Use placeholder helper
            $imageUrl = \App\Helpers\PlaceholderAvatar::svgDataUri($c->name ?? 'Category');
        }

        return (object)[
            'id' => $c->id ?? null,
            'name' => $c->name ?? 'Untitled Category',
            'slug' => $c->slug ?? null,
            'description' => $c->description ?? '',
            'image' => $imageUrl,
            'productsCount' => $c->total_products_count ?? $c->products_count ?? 0,
            'children' => $c->children ?? collect(),
        ];
    });
@endphp

<section class="my-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">{{ $title }}</h2>
        <a href="{{ route('categories.index') ?? route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">See all</a>
    </div>

    @if($categories->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <article class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-md transition overflow-hidden">
                    <a @if($category->slug) href="{{ route('category.show', $category->slug) }}" @endif class="block group">
                        <div class="w-full h-44 md:h-48 lg:h-52 overflow-hidden bg-gray-100 dark:bg-gray-800">
                            <img src="{{ $category->image }}"
                                 alt="{{ $category->name }}"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='{{ asset('img/default-category.png') }}';"
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>

                        <div class="p-4 md:p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $category->name }}</h3>
                                    @if($category->description)
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-300 line-clamp-2">{{ $category->description }}</p>
                                    @endif
                                </div>

                                <div class="flex-shrink-0 text-right">
                                    <div class="text-sm font-medium text-indigo-600 dark:text-indigo-300">
                                        {{ $category->productsCount }} {{ Str::plural('item', $category->productsCount) }}
                                    </div>
                                </div>
                            </div>

                            @if($category->children && $category->children->count() > 0)
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach($category->children->slice(0,4) as $sub)
                                        @php
                                            $sName = $sub->name ?? 'Sub';
                                            $sSlug = $sub->slug ?? null;
                                            $sCount = $sub->total_products_count ?? $sub->products_count ?? 0;
                                        @endphp

                                        @if($sSlug)
                                            <a href="{{ route('category.show', $sSlug) }}" class="inline-flex items-center gap-2 px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-xs text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                                <span class="truncate">{{ $sName }}</span>
                                                <span class="text-xs text-gray-400">· {{ $sCount }}</span>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-2 py-1 rounded-full bg-gray-50 dark:bg-gray-900 text-xs text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                                <span class="truncate">{{ $sName }}</span>
                                                <span class="text-xs text-gray-400">· {{ $sCount }}</span>
                                            </span>
                                        @endif
                                    @endforeach

                                    @if($category->children->count() > 4)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-50 dark:bg-gray-900 text-xs text-gray-500 dark:text-gray-400">
                                            +{{ $category->children->count() - 4 }} more
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-4 flex items-center justify-between gap-3">
                                <div>
                                    @if($category->slug)
                                        <a href="{{ route('category.show', $category->slug) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-full hover:bg-indigo-700 transition">
                                            View All
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-200 text-gray-600 text-sm rounded-full">Unavailable</span>
                                    @endif
                                </div>

                                <div class="text-xs text-gray-400">Updated recently</div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    @else
        <div class="py-20 text-center">
            <div class="mx-auto w-44 h-44 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500 text-6xl mb-6">📦</div>
            <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-100 mb-2">No categories yet</h3>
            <p class="text-gray-500 dark:text-gray-300 mb-6">When you add categories they will appear here.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-full transition">Browse products</a>
        </div>
    @endif
</section>