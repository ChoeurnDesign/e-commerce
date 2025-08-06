<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
    @include('layouts.styles')
</head>
<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')
        @include('layouts.flash-messages')
        <main>
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </div>

    <x-info-modal />

    @include('layouts.scripts')
    <script src="{{ asset('js/shop-actions.js') }}"></script>
    @stack('scripts')
</body>
</html>
