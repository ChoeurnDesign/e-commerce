@props(['name', 'class' => ''])

@switch($name)
    @case('dashboard')
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 22 22">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5a2 2 0 012-2h0a2 2 0 012 2v0H8v0z"></path>
        </svg>
        @break

    @case('store')
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" stroke="currentColor" stroke-width="2" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 10-8 0v4M5 8h14l1 12a2 2 0 01-2 2H6a2 2 0 01-2-2l1-12z" />
        </svg>
        @break

    @case('about')
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none" />
        <path d="M4 20v-2a4 4 0 014-4h8a4 4 0 014 4v2" stroke="currentColor" stroke-width="2" fill="none" />
    </svg>
        @break

    @case('admin')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.4 15a1.65 1.65 0 01-2.33 2.33L15 16.4M4.6 9a1.65 1.65 0 012.33-2.33L9 7.6M9 16.4l-1.33 1.33A1.65 1.65 0 014.6 15M16.4 7.6l1.33-1.33A1.65 1.65 0 0119.4 9" />
        </svg>
        @break

    @case('cart')
        <svg class="inline w-6 h-6 text-gray-200 dark:text-gray-300" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" >
            <path strokeLinecap="round" strokeLinejoin="round" stroke-width="1" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>
        @break

    @case('categories')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="2" />
            <rect x="14" y="3" width="7" height="7" rx="2" />
            <rect x="14" y="14" width="7" height="7" rx="2" />
            <rect x="3" y="14" width="7" height="7" rx="2" />
        </svg>
        @break

    @case('contact')
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="2" fill="none" />
            <polyline points="3 7 12 13 21 7" stroke="currentColor" stroke-width="2" fill="none" />
        </svg>
        @break

    @case('dark-mode')
        <svg viewBox="0 0 48 48" fill="currentColor" class="h-4 w-4 mr-2 text-gray-300 dark:text-gray-500">
            <path d="M24 0A24 24 0 0 0 0 24c0 13.255 10.745 24 24 24 10.609 0 19.541-7.083 22.527-16.825C38.984 35.132 27.224 36.167 18.167 29.833 6.949 21.766 10.185 7.457 24 0z" />
        </svg>
        @break

    @case('home')
        <svg class="inline w-5 h-5 mr-1 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <polygon points="12,3 2,12 5,12 5,21 19,21 19,12 22,12 12,3" stroke="currentColor" fill="none" />
            <rect x="10" y="15" width="4" height="6" fill="none" stroke="currentColor" />
        </svg>
        @break

    @case('login')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5v14" />
        </svg>
        @break

    @case('orders')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <rect x="3" y="7" width="18" height="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4" />
        </svg>
        @break

    @case('products')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <rect width="20" height="8" x="2" y="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6" />
        </svg>
        @break

    @case('profile')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4" />
            <path d="M4 20c0-2.5 3.5-4.5 8-4.5s8 2 8 4.5" stroke-linecap="round" />
        </svg>
        @break

    @case('register')
        <svg class="inline w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 11c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-7v4m0 16v-4" />
        </svg>
        @break

    @case('signout')
        <svg class="w-5 h-5 mr-2 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 17l5-5m0 0l-5-5m5 5H9m4 5v1a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2h4a2 2 0 012 2v1" />
        </svg>
        @break

    @case('user')
       <svg class="w-10 h-10 text-gray-300 dark:text-gray-400" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="1.3" />
            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.3" />
            <path d="M7 17c1.5-2 7.5-2 9 0" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
        </svg>
        @break

    @case('wishlist')
        <svg class="inline w-6 h-6 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
            <path stroke-width="1" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        @break

    @case('wishlist-filled')
        <svg class="inline w-6 h-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
        @break

    @case('notification')
        <svg class="h-6 w-6 text-gray-300 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @break

    @case('info')
        <svg class="inline w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        @break

     @case('star-filled')
        <svg class="inline w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>
        @break

    @case('star-empty')
        <svg class="inline w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>
        @break

    @default
        {{-- Optional: Default icon SVG --}}
@endswitch
