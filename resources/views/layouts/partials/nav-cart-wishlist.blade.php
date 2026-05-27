<!-- Chat -->
@auth
<a href="{{ route('chat.index') }}"
    class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
    title="Messages">
    <x-icon-dashboard name="chat" class="w-5 h-5" />
    @if(($unreadUserChats ?? 0) > 0)
    <span class="absolute -top-1 -right-1 bg-indigo-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold leading-none">
        {{ ($unreadUserChats ?? 0) > 9 ? '9+' : ($unreadUserChats ?? 0) }}
    </span>
    @endif
</a>
@endauth
<!-- Cart -->
<a href="{{ route('cart.index') }}"
    class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
    title="Cart">
    <x-icon-dashboard name="cart" class="w-5 h-5" />
    @auth
    @if(isset($cartCount) && $cartCount > 0)
    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold leading-none">{{ $cartCount }}</span>
    @endif
    @endauth
</a>
<!-- Wishlist -->
<a href="{{ route('wishlist.index') }}"
    class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
    title="Wishlist">
    <x-icon-dashboard name="wishlist" class="w-5 h-5" />
    @auth
    @if(isset($wishlistCount) && $wishlistCount > 0)
    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold leading-none">{{ $wishlistCount }}</span>
    @endif
    @endauth
</a>
