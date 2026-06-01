<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
    @include('layouts.styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <title>@yield('title', 'Admin') — {{ setting('store_name', 'ShopExpress') }}</title>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased"
      x-data="{ sidebarOpen: false }"
      @resize.window.debounce.100ms="if (window.innerWidth >= 1024) sidebarOpen = false">

    @include('layouts.flash-messages')

    <div class="flex h-screen w-screen overflow-hidden relative">

        {{-- Mobile backdrop --}}
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
             x-cloak></div>

        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden min-w-0 w-full">
            @include('admin.partials.header')

            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmDelete(event, btn) {
        event.preventDefault();
        const message = btn.getAttribute('data-confirm') || 'This action cannot be undone.';
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor:  '#6b7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText:  'Cancel',
        }).then(result => {
            if (result.isConfirmed) btn.closest('form').submit();
        });
    }
    </script>
    @stack('scripts')
</body>
</html>
