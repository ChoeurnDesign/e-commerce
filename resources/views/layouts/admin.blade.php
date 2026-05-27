<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      :class="{ 'dark': dark }"
      x-init="$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'))">
<head>
    @include('layouts.head')
    @include('layouts.styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased transition-colors"
      x-data="{ sidebarOpen: false }"
      @resize.window.debounce.100ms="if (window.innerWidth >= 1024) sidebarOpen = false">

    {{-- ✅ Fixed top banner — same as customer layout --}}
    @include('layouts.flash-messages')

    <div class="flex h-screen w-screen overflow-hidden relative">

        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 lg:hidden"
             style="display:none;">
        </div>

        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden min-w-0 w-full">
            @include('admin.partials.header')

            <main class="flex-1 overflow-y-auto p-6 bg-gray-200 dark:bg-[#101624] transition-colors text-gray-900 dark:text-gray-100">
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