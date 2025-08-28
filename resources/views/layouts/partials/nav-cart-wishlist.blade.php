<!-- Cart -->
<a href="{{ route('cart.index') }}"
    class="relative p-2 mx-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-600 dark:hover:bg-[#2e1065] transition-colors">
    <x-icon-nav name="cart" class="w-8 h-8" />
    @auth
    @if(isset($cartCount) && $cartCount > 0)
    <span
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none">{{ $cartCount }}</span>
    @endif
    @endauth
</a>
<!-- Wishlist -->
<a href="{{ route('wishlist.index') }}"
    class="relative p-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-600 dark:hover:bg-[#2e1065] transition-colors">
    <x-icon-nav name="wishlist-filled" class="w-8 h-8" />
    @auth
    @if(isset($wishlistCount) && $wishlistCount > 0)
    <span
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none">{{ $wishlistCount }}</span>
    @endif
    @endauth
</a>
