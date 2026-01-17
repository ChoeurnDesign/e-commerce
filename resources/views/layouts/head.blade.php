<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF token (needed for AJAX requests and to avoid "CSRF token not found" console errors) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add this line for chat functionality -->
    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
    @endauth

    <style>[x-cloak] { display: none !important; }</style>

    <title>{{ $settings['store_name'] ?? config('app.name', 'ShopExpress') }}</title>
    <meta name="description" content="@yield('description', 'Shop the best products online at ' . ($settings['store_name'] ?? 'ShopExpress'))">
    <meta name="keywords" content="@yield('keywords', 'shopping, online store, products')">

    <meta property="og:title" content="@yield('og_title', $settings['store_name'] ?? 'ShopExpress')">
    <meta property="og:description" content="@yield('og_description', 'Shop the best products online')">
    <meta property="og:image" content="@yield('og_image', asset($settings['store_logo'] ?? 'images/logo.png'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:type" content="website">

    {{-- Favicon --}}
    @if(!empty($settings['store_logo']))
        <link rel="icon" type="image/png" href="{{ asset($settings['store_logo']) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>