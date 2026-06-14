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
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-8">
                <div class="container-custom">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('images/logo.png') }}" alt="KosCheck" class="h-8 w-auto">
                            <span class="text-sm text-gray-500 dark:text-gray-400">&copy; 2026 KosCheck Indonesia</span>
                        </div>
                        <div class="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ route('bantuan') }}" class="hover:text-primary dark:hover:text-primary">Bantuan</a>
                            <a href="{{ route('privacy') }}" class="hover:text-primary dark:hover:text-primary">Kebijakan Privasi</a>
                            <a href="{{ route('terms') }}" class="hover:text-primary dark:hover:text-primary">Syarat & Ketentuan</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
