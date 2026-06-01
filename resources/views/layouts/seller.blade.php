<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
    @include('layouts.styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <title>@yield('title', 'Seller Area')</title>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    {{-- ✅ Fixed top banner flash --}}
    @include('layouts.flash-messages')

    <div class="flex h-screen" x-data="{ sidebarOpen: false }">
        {{-- Mobile backdrop --}}
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-40 md:hidden"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak></div>

        @include('seller.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden min-w-0">
            @include('seller.partials.header')

            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 text-gray-900">
                {{-- Global inline validation-error banner (session toasts are in layouts/flash-messages.blade.php) --}}
                @include('seller.partials.flash')
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmDelete(event, btn) {
        event.preventDefault();
        const message = btn.getAttribute('data-confirm') || 'This action cannot be undone.';
        const isDark  = document.documentElement.classList.contains('dark');
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor:  '#6b7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText:  'Cancel',
            background: isDark ? '#1f2937' : '#ffffff',
            color:      isDark ? '#f9fafb' : '#111827',
        }).then(result => {
            if (result.isConfirmed) btn.closest('form').submit();
        });
    }
    </script>
    @stack('scripts')
</body>
</html>