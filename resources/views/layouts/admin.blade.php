<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel — KosCheck')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-text antialiased pb-24 lg:pb-0 overflow-x-hidden">

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
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name=Admin+KosCheck&background=1A6B3C&color=fff" class="rounded-full w-full h-full object-cover" alt="Admin">
                </div>
                <div class="sidebar-user-text">
                    <h3 class="font-bold text-sm text-text leading-tight">Admin KosCheck</h3>
                    <p class="text-[0.65rem] text-primary font-bold tracking-wide mt-0.5">PANEL MODERASI</p>
                </div>
            </div>
        </div>
        <nav class="px-4 flex-1">
            <a href="{{ route('admin') }}" class="owner-nav-item {{ request()->routeIs('admin') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h7v5H4zM13 6h7v8h-7zM4 13h7v5H4zM13 17h7v1h-7z"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.verifikasi') }}" class="owner-nav-item {{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l4 4L19 6"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21c4.97-1.278 8-5.596 8-11V5l-8-2-8 2v5c0 5.404 3.03 9.722 8 11z"/></svg>
                <span>Verifikasi Kos</span>
            </a>
            <a href="{{ route('admin.moderasi') }}" class="owner-nav-item {{ request()->routeIs('admin.moderasi') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span>Moderasi Review</span>
            </a>
            <a href="#" class="owner-nav-item opacity-60 cursor-not-allowed" onclick="event.preventDefault();">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5 6 9H3v6h3l5 4V5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9.5a4.5 4.5 0 0 1 0 5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 7a8 8 0 0 1 0 10"/></svg>
                <div class="flex-1 flex justify-between items-center">
                    <span>Iklan Lokal</span>
                    <span class="text-[0.6rem] font-bold px-1.5 py-0.5 rounded-md bg-gray-200 text-gray-500 uppercase tracking-wider">Coming Soon</span>
                </div>
            </a>
            <a href="{{ route('admin.users') }}" class="owner-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20a5 5 0 0 0-10 0"/><circle cx="12" cy="8" r="4" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 20a4 4 0 0 0-3-3.87M18 4.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Manajemen User</span>
            </a>
        </nav>
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-border-light bg-bg">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="owner-nav-item text-red-500 hover:text-red-600 hover:bg-red-50 w-full text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/></svg>
                    <span>Keluar</span>
                </button>
            </form>
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
                        <span class="text-sm font-medium text-text">Tim Moderasi<br><span class="text-[0.65rem] text-text-muted font-normal block">Admin</span></span>
                        <img src="https://ui-avatars.com/api/?name=Admin+KosCheck&background=1A6B3C&color=fff&size=32" class="w-8 h-8 rounded-full border border-border" alt="Admin">
                    </div>
                </div>
            </div>
        </header>
        <div class="p-6 md:p-8 flex-1 scroll-animate-container">
            @yield('content')
        </div>
        <footer class="p-6 border-t border-border-light text-center">
            <p class="text-xs text-text-muted">&copy; 2026 KosCheck Indonesia • Panel admin frontend preview.</p>
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
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name=Admin+KosCheck&background=1A6B3C&color=fff" class="rounded-full w-full h-full object-cover" alt="Admin">
            </div>
            <div>
                <h3 class="font-bold text-sm text-text leading-tight">Admin KosCheck</h3>
                <p class="text-[0.65rem] text-primary font-bold tracking-wide mt-0.5">PANEL MODERASI</p>
            </div>
        </div>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin') }}" class="owner-nav-item {{ request()->routeIs('admin') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h7v5H4zM13 6h7v8h-7zM4 13h7v5H4zM13 17h7v1h-7z"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.verifikasi') }}" class="owner-nav-item {{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l4 4L19 6"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21c4.97-1.278 8-5.596 8-11V5l-8-2-8 2v5c0 5.404 3.03 9.722 8 11z"/></svg>
                <span>Verifikasi Kos</span>
            </a>
            <a href="{{ route('admin.moderasi') }}" class="owner-nav-item {{ request()->routeIs('admin.moderasi') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                <span>Moderasi Review</span>
            </a>
            <a href="#" class="owner-nav-item opacity-60 cursor-not-allowed" onclick="event.preventDefault();">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5 6 9H3v6h3l5 4V5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9.5a4.5 4.5 0 0 1 0 5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 7a8 8 0 0 1 0 10"/></svg>
                <div class="flex-1 flex justify-between items-center">
                    <span>Iklan Lokal</span>
                    <span class="text-[0.6rem] font-bold px-1.5 py-0.5 rounded-md bg-gray-200 text-gray-500 uppercase tracking-wider">Coming Soon</span>
                </div>
            </a>
            <a href="{{ route('admin.users') }}" class="owner-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20a5 5 0 0 0-10 0"/><circle cx="12" cy="8" r="4" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 20a4 4 0 0 0-3-3.87M18 4.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Manajemen User</span>
            </a>
            <hr class="my-2 border-border">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="owner-nav-item text-red-500 hover:text-red-600 hover:bg-red-50 w-full text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/></svg>
                    <span>Keluar</span>
                </button>
            </form>
        </nav>
    </div>

<x-admin-mobile-bottom-nav />
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
        try { localStorage.setItem('admin_sidebar_collapsed',c); } catch(e){}
    }
    </script>
</body>
</html>
