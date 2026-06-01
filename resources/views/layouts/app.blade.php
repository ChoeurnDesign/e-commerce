<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
    @include('layouts.styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="text-gray-800 min-h-screen flex flex-col bg-white sm:bg-[#FFF8FB]" style="background: linear-gradient(180deg, #FFDCE8 0px, #FFE8F0 80px, #FFF0F6 200px, #FFF8FB 400px, #FFFFFF 700px); background-repeat: no-repeat; background-color: #FFFFFF;">
    @include('layouts.navigation')
    @include('layouts.flash-messages')

    <main class="flex-1">
        {{ $slot }}
        @yield('content')
    </main>

    @unless(request()->routeIs('chat.*'))
        @include('layouts.footer')
    @endunless
    <x-info-modal />
    @include('layouts.scripts')

    <script src="{{ asset('js/shop-actions.js') }}"></script>
    @stack('scripts')

    {{-- Quick View Modal --}}
    @include('components.products.quick-view-modal')
</body>
</html>
