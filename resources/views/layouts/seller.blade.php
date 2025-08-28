<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      :class="{ 'dark': dark }"
      x-init="$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'))">
<head>
    @include('layouts.head')
    @include('layouts.styles')
    <title>@yield('title', 'Seller Area')</title>
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased transition-colors">
    <div class="flex h-screen">
        @include('seller.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('seller.partials.header')

            <main class="flex-1 overflow-y-auto p-6 bg-gray-300 dark:bg-[#101624] transition-colors text-gray-900 dark:text-gray-100">
                @include('seller.partials.flash')
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>