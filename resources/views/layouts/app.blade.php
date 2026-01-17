<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      :class="{ 'dark': dark }"
      x-init="$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'))">
<head>
    @include('layouts.head')
    @include('layouts.styles')
</head>
<body class="bg-[#181f31] text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex-col">
    <!-- Navigation (navbar) -->
    @include('layouts.navigation')
    @include('layouts.flash-messages')
    <!-- Main content, vertically centered -->
    <main class="flex-1 bg-gray-300">
        {{ $slot }}
        @yield('content')
    </main>
    @include('layouts.footer')
    <x-info-modal />
    @include('layouts.scripts')
    <!-- Shop JS for cart/wishlist -->
    <script src="{{ asset('js/shop-actions.js') }}"></script>
    @stack('scripts')
</body>
</html>
