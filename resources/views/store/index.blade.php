<x-app-layout>
    <div class="py-8 bg-gray-200 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">All Stores</h1>
                <p class="text-gray-600 dark:text-gray-300">Browse all our featured stores and sellers</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($sellers as $seller)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition group relative overflow-hidden">
                        <div class="h-24 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            @if($seller->banner_image)
                                <img src="{{ asset('storage/'.$seller->banner_image) }}" alt="{{ $seller->store_name ?? $seller->name }} Banner" class="w-full h-full object-cover" />
                            @else
                                <span class="text-gray-400 dark:text-gray-500 text-xl">Store Banner</span>
                            @endif
                        </div>
                        <div class="flex justify-center -mt-8">
                            <img src="{{ $seller->profile_image ? asset('storage/'.$seller->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($seller->name).'&background=0D8ABC&color=fff' }}"
                                 alt="{{ $seller->store_name ?? $seller->name }}"
                                 class="w-16 h-16 rounded-full border-4 border-white dark:border-gray-800 shadow-lg bg-white dark:bg-gray-900 object-cover">
                        </div>
                        <div class="px-4 pb-4 pt-2 text-center">
                            <h2 class="text-lg font-semibold truncate mb-1 text-gray-900 dark:text-gray-100">{{ $seller->store_name ?? $seller->name }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mb-2">@ {{ $seller->slug }}</p>
                            <div class="flex justify-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <span>
                                    <i class="fas fa-box"></i>
                                    {{ $seller->products_count ?? $seller->products()->count() }} Products
                                </span>
                            </div>
                            <a href="{{ route('store.show', $seller) }}"
                               class="inline-block bg-sky-600 dark:bg-sky-700 text-white px-5 py-2 rounded-full font-semibold shadow hover:bg-sky-700 dark:hover:bg-sky-800 transition">
                                View Store
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500 dark:text-gray-400">No stores found.</div>
                @endforelse
            </div>
            <div class="mt-10 flex justify-center">
                {{ $sellers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
