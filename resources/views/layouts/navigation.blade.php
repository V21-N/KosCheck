<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
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
                    <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->is('/') ? 'text-green-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Beranda
                    </a>
                    <a href="{{ route('cari-kos') }}" class="text-sm font-medium {{ request()->is('cari-kos*') || request()->routeIs('kos.*') ? 'text-green-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Cari Kos
                    </a>
                    <a href="{{ route('bantuan') }}" class="text-sm font-medium {{ request()->is('bantuan*') ? 'text-green-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Bantuan
                    </a>
                </div>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @auth
                <div class="relative">
                    <button onclick="document.getElementById('userDropdown').classList.toggle('hidden')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-green-600 border border-green-600 px-4 py-2 rounded-lg hover:bg-green-50 transition">
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
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->is('/') ? 'text-green-500 bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Beranda</a>
            <a href="{{ route('cari-kos') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->is('cari-kos*') || request()->routeIs('kos.*') ? 'text-green-500 bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Cari Kos</a>
            <a href="{{ route('bantuan') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->is('bantuan*') ? 'text-green-500 bg-green-50' : 'text-gray-700 hover:bg-gray-50' }}">Bantuan</a>
        </div>
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-3 border-t border-gray-200">
            <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-green-600 hover:bg-gray-50">Masuk</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-white bg-green-600 hover:bg-green-700">Daftar</a>
        </div>
        @endauth
    </div>
</nav>