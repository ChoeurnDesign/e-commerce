<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        @include('layouts.styles')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-300">
            <div class="w-full sm:max-w-md mt-4 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
