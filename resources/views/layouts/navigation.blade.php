<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="KosCheck" class="h-20 w-auto object-contain">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->is('/') ? 'text-green-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Beranda
                    </a>
                    <a href="{{ route('cari-kos') }}" class="text-sm font-medium {{ request()->is('cari-kos*') || request()->routeIs('kos.*') ? 'text-green-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Cari Kos
                    </a>
                    <a href="{{ route('bantuan') }}" class="text-sm font-medium {{ request()->is('bantuan*') ? 'text-green-500' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Bantuan
                    </a>
                </div>
            </div>

            <!-- Auth Buttons & Dark Mode -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                {{-- Dark Mode Toggle --}}
                <button
                    data-darkmode-toggle
                    class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-primary transition-colors"
                    aria-label="Toggle dark mode"
                >
                    {{-- Moon icon (shown in light mode) --}}
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    {{-- Sun icon (shown in dark mode) --}}
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                @auth
                <div class="relative">
                    <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white dark:bg-gray-800 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-100 dark:border-gray-700">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-green-600 border border-green-600 px-4 py-2 rounded-lg hover:bg-green-50 transition dark:border-green-500 dark:text-green-500 dark:hover:bg-green-900/20">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-green-600 px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Daftar
                </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->is('/') ? 'text-green-500 bg-green-50 dark:bg-green-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Beranda</a>
            <a href="{{ route('cari-kos') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->is('cari-kos*') || request()->routeIs('kos.*') ? 'text-green-500 bg-green-50 dark:bg-green-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Cari Kos</a>
            <a href="{{ route('bantuan') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->is('bantuan*') ? 'text-green-500 bg-green-50 dark:bg-green-900/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">Bantuan</a>
        </div>
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Logout</button>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-green-600 dark:text-green-500 hover:bg-gray-50 dark:hover:bg-gray-800">Masuk</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-white bg-green-600 dark:bg-green-600 hover:bg-green-700 dark:hover:bg-green-700">Daftar</a>
        </div>
        @endauth
    </div>
</nav>