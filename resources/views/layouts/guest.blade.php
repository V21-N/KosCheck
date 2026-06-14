<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KosCheck') }} — Platform Pencarian Kos untuk Mahasiswa</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            {{-- Top bar with dark mode toggle --}}
            <div class="absolute top-4 right-4 flex items-center gap-3">
                {{-- Dark Mode Toggle --}}
                <button
                    data-darkmode-toggle
                    class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-sm flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-primary transition-colors"
                    aria-label="Toggle dark mode"
                >
                    {{-- Sun icon (shown in dark mode) --}}
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    {{-- Moon icon (shown in light mode) --}}
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
            </div>

            <div class="sm:mx-auto">
                <a href="/">
                    <x-site-logo class="w-24 h-24" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            {{-- Footer links --}}
            <div class="mt-6 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('bantuan') }}" class="hover:text-primary transition-colors">Bantuan</a>
                <span>•</span>
                <a href="{{ route('privacy') }}" class="hover:text-primary transition-colors">Kebijakan Privasi</a>
                <span>•</span>
                <a href="{{ route('terms') }}" class="hover:text-primary transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </body>
</html>
