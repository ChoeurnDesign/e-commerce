{{-- Dashboard welcome hero --}}
<div class="bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-500 rounded-2xl shadow-lg p-6 sm:p-8 text-white relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/10 rounded-full"></div>

    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <p class="text-indigo-200 text-sm font-medium mb-1">{{ now()->format('l, F j, Y') }}</p>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Welcome back, {{ auth()->user()->name }}!
            </h1>
            <p class="text-indigo-100 text-sm mt-1.5 max-w-md">
                Here's an overview of your store's performance.
            </p>
        </div>
        <div class="flex gap-2 shrink-0">
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center gap-2 bg-white text-indigo-600 hover:bg-indigo-50 font-bold px-5 py-2.5 rounded-xl shadow-sm transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Manage Orders
            </a>
            <a href="{{ route('admin.sellers.index') }}"
               class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Sellers
            </a>
        </div>
    </div>
</div>
