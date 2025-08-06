<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>[x-cloak] { display: none !important; }</style>

<title>@yield('title', config('app.name', 'ShopExpress'))</title>
<meta name="description" content="@yield('description', 'Shop the best products online at ShopExpress')">
<meta name="keywords" content="@yield('keywords', 'shopping, online store, products')">

<meta property="og:title" content="@yield('og_title', 'ShopExpress')">
<meta property="og:description" content="@yield('og_description', 'Shop the best products online')">
<meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
<meta property="og:url" content="@yield('og_url', url()->current())">
<meta property="og:type" content="website">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
