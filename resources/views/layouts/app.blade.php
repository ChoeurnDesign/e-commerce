<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        // Apply theme BEFORE first paint to avoid white flash
        (function () {
            try {
                const theme = localStorage.getItem('theme'); // 'dark' | 'light' | null
                const prefersDark = window.matchMedia &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (theme === 'dark' || (theme === null && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    @include('layouts.head')
    @include('layouts.styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
    @include('layouts.navigation')
    @include('layouts.flash-messages')

    <main class="flex-1 bg-gray-100 dark:bg-gray-900">
        {{ $slot }}
        @yield('content')
    </main>

    @include('layouts.footer')
    <x-info-modal />
    @include('layouts.scripts')

    <script>
      window.toggleTheme = function () {
        const root = document.documentElement;
        const isDark = root.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
      };
    </script>

    <script src="{{ asset('js/shop-actions.js') }}"></script>
    @stack('scripts')
</body>
</html>