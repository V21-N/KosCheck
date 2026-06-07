<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa — KosCheck')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-text antialiased pb-24 lg:pb-0 overflow-x-hidden">
    @php($currentUser = auth()->user())

    {{-- SIDEBAR (Desktop only) --}}
    <aside class="owner-sidebar hidden lg:block">
        <div class="flex justify-end px-3 py-2 border-b border-border-light">
            <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-gray-200 transition-all duration-300" title="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <div class="pt-3 pb-10 flex justify-center">
            <div class="sidebar-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="KosCheck" class="h-25 object-contain">
                </a>
            </div>
        </div>
        <div class="px-4 mt-2 mb-2">
            <div class="bg-gray-100 rounded-xl p-4 flex items-center gap-3 border border-border-light shadow-sm">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Mahasiswa') }}&background=3B82F6&color=fff" class="rounded-full w-full h-full object-cover">
                </div>
                <div class="sidebar-user-text">
                    <h3 class="font-bold text-sm text-text leading-tight">{{ $currentUser?->name ?? 'Mahasiswa' }}</h3>
                    <p class="text-[0.65rem] text-blue-600 font-bold tracking-wide mt-0.5">MAHASISWA {{ strtoupper($currentUser?->university ?? 'USU') }}</p>
                </div>
            </div>
        </div>
        <nav class="px-4 flex-1">
            <a href="{{ route('student.dashboard') }}" class="owner-nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('student.kos') }}" class="owner-nav-item {{ request()->routeIs('student.kos', 'student.kos.show', 'student.dashboard', 'cari-kos', 'kos.show', 'detail-kos') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Cari Kos</span>
            </a>
            <a href="{{ route('student.booking') }}" class="owner-nav-item {{ request()->routeIs('student.booking') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Booking Saya</span>
            </a>
            <a href="{{ route('student.review') }}" class="owner-nav-item {{ request()->routeIs('student.review') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span>Review Saya</span>
            </a>
            <a href="{{ route('profil') }}" class="owner-nav-item {{ request()->routeIs('profil') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Profil & Pengaturan</span>
            </a>
        </nav>
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-border-light bg-bg">
            <a href="{{ route('logout.get') }}" class="owner-nav-item text-red-500 hover:text-red-600 hover:bg-red-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="owner-main">
        <header class="owner-topbar">
            <div class="flex items-center gap-4">
                <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                @yield('topbar_left')
            </div>
            <div class="flex items-center gap-5">
                @yield('topbar_right')
                <div class="flex items-center gap-3">
                    <button data-darkmode-toggle class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-text-muted hover:text-primary transition-all flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>
                    <div class="hidden sm:flex items-center gap-2 border-l border-border pl-5">
                        <span class="text-sm font-medium text-text">{{ $currentUser?->name ?? 'Mahasiswa' }}<br><span class="text-[0.65rem] text-text-muted font-normal block">Mahasiswa {{ $currentUser?->university ?? 'USU' }}</span></span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Mahasiswa') }}&background=3B82F6&color=fff&size=32" class="w-8 h-8 rounded-full border border-border">
                    </div>
                </div>
            </div>
        </header>
        <div class="p-6 md:p-8 flex-1 scroll-animate-container">
            @yield('content')
        </div>
        <footer class="p-6 border-t border-border-light text-center">
            <p class="text-xs text-text-muted">&copy; 2026 KosCheck Indonesia • Platform untuk Mahasiswa.</p>
        </footer>
    </main>

    <div id="menu-overlay" onclick="closeMobileMenu()"></div>
    <div id="mobile-menu" class="p-6">
        <div class="flex items-center justify-between mb-8">
            <x-site-logo :href="route('home')" variant="navbar" class="items-center" />
            <button onclick="closeMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-label="Tutup menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="mb-6 p-4 bg-gray-100 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Mahasiswa') }}&background=3B82F6&color=fff" class="rounded-full w-full h-full object-cover">
            </div>
            <div>
                <h3 class="font-bold text-sm text-text leading-tight">{{ $currentUser?->name ?? 'Mahasiswa' }}</h3>
                <p class="text-[0.65rem] text-blue-600 font-bold tracking-wide mt-0.5">MAHASISWA {{ strtoupper($currentUser?->university ?? 'USU') }}</p>
            </div>
        </div>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('student.dashboard') }}" class="owner-nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('student.kos') }}" class="owner-nav-item {{ request()->routeIs('student.kos', 'student.kos.show', 'cari-kos', 'kos.show', 'detail-kos') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Cari Kos</span>
            </a>
            <a href="{{ route('student.booking') }}" class="owner-nav-item {{ request()->routeIs('student.booking') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Booking Saya</span>
            </a>
            <a href="{{ route('student.review') }}" class="owner-nav-item {{ request()->routeIs('student.review') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span>Review Saya</span>
            </a>
            <a href="{{ route('profil') }}" class="owner-nav-item {{ request()->routeIs('profil') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Profil & Pengaturan</span>
            </a>
            <hr class="my-2 border-border">
            <a href="{{ route('logout.get') }}" class="owner-nav-item text-red-500 hover:text-red-600 hover:bg-red-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Keluar</span>
            </a>
        </nav>
    </div>

<x-mobile-bottom-nav />
    <style>[x-cloak] { display: none !important; }</style>
    <script>
    function toggleMobileMenu() {
        var m=document.getElementById('mobile-menu'),o=document.getElementById('menu-overlay');
        if(!m)return;var x=m.classList.toggle('mobile-menu-open');
        if(o)o.classList.toggle('overlay-visible',x);
        document.body.classList.toggle('overflow-hidden',x);
        document.body.classList.toggle('menu-open',x);
    }
    function closeMobileMenu() {
        var m=document.getElementById('mobile-menu'),o=document.getElementById('menu-overlay');
        if(m)m.classList.remove('mobile-menu-open');
        if(o)o.classList.remove('overlay-visible');
        document.body.classList.remove('overflow-hidden','menu-open');
    }
    function toggleSidebar() {
        var s=document.querySelector('.owner-sidebar'),n=document.querySelector('.owner-main');
        if(!s)return;
        var c=s.classList.toggle('sidebar-collapsed');
        if(n)n.classList.toggle('main-collapsed',c);
        try { localStorage.setItem('student_sidebar_collapsed',c); } catch(e){}
    }
    </script>
    @stack('scripts')
</body>
</html>
