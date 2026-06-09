<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pemilik — KosCheck')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-text antialiased pb-24 lg:pb-0 overflow-x-hidden">
    @php
        $currentUser = auth()->user();
        $ownerNotificationItems = collect();

        if ($currentUser) {
            $notificationMeta = [
                'new_lead' => [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
                    'iconColor' => 'text-emerald-600',
                ],
                'booking' => [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'iconColor' => 'text-green-600',
                ],
                'new_review' => [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
                    'iconColor' => 'text-yellow-500',
                ],
                'booking_status' => [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'iconColor' => 'text-green-600',
                ],
                'review_reported' => [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
                    'iconColor' => 'text-red-600',
                ],
                'system' => [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                    'iconColor' => 'text-blue-600',
                ],
            ];

            $ownerNotificationItems = $currentUser->notifications()
                ->latest()
                ->limit(5)
                ->get()
                ->map(function ($notification) use ($notificationMeta) {
                    $meta = $notificationMeta[$notification->type] ?? [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'iconColor' => 'text-gray-600',
                    ];

                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'time' => $notification->created_at?->diffForHumans(),
                        'read' => (bool) $notification->is_read,
                        'icon' => $meta['icon'],
                        'iconColor' => $meta['iconColor'],
                        'url' => route('dashboard.notifikasi.open', $notification),
                    ];
                })
                ->values();
        }
    @endphp

    {{-- SIDEBAR (Desktop only) --}}
    <aside class="owner-sidebar hidden lg:block">
        <div class="flex h-full flex-col">
            <div class="flex justify-end px-3 py-2 border-b border-border-light">
                <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-gray-200 transition-all duration-300" title="Toggle Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            <div class="pt-1 pb-10 flex justify-center">
                <div class="sidebar-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="KosCheck" class="h-25 object-contain">
                    </a>
                </div>
            </div>
            <div class="px-4 mt-2 mb-2">
                <div class="bg-gray-100 rounded-xl p-4 flex items-center gap-3 border border-border-light shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Pemilik Kos') }}&background=F47C20&color=fff" class="rounded-full w-full h-full object-cover" alt="Owner avatar">
                    </div>
                    <div class="sidebar-user-text">
                        <h3 class="font-bold text-sm text-text leading-tight">{{ $currentUser?->name ?? 'Pemilik Kos' }}</h3>
                        <p id="owner-online-status" class="text-[0.65rem] font-bold tracking-wide mt-0.5 {{ auth()->user()?->is_online ? 'text-green-600' : 'text-gray-500' }}">
                            {{ auth()->user()?->is_online ? 'ONLINE' : 'OFFLINE' }}
                        </p>
                    </div>
                </div>
            </div>
            <nav class="px-4 flex-1 min-h-0 overflow-y-auto">
                <a href="{{ route('owner.dashboard') }}" class="owner-nav-item {{ request()->routeIs('owner.dashboard', 'dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.properti') }}" class="owner-nav-item {{ request()->routeIs('dashboard.properti', 'dashboard.kos.show') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Properti Saya</span>
                </a>
                <a href="{{ route('dashboard.booking') }}" class="owner-nav-item {{ request()->routeIs('dashboard.booking') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Booking</span>
                </a>
                <a href="{{ route('dashboard.kos.create') }}" class="owner-nav-item {{ request()->routeIs('dashboard.kos.create', 'dashboard.kos.edit', 'dashboard.tambah-properti') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Tambah Properti</span>
                </a>
                <a href="{{ route('dashboard.notifikasi') }}" class="owner-nav-item {{ request()->routeIs('dashboard.notifikasi') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span>Notifikasi</span>
                </a>
                <a href="{{ route('dashboard.pengaturan') }}" class="owner-nav-item {{ request()->routeIs('dashboard.pengaturan') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Pengaturan</span>
                </a>
            </nav>
            <div class="p-4 border-t border-border-light bg-bg">
                <a href="{{ route('logout.get') }}" class="owner-nav-item text-red-500 hover:text-red-600 hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Keluar</span>
                </a>
            </div>
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
                <div class="flex items-center gap-3" x-data="ownerNotifications()">
                    <div class="relative">
                        <button @click="open = !open" class="relative p-2 text-text-muted hover:text-primary transition-colors" data-hover="scale" aria-label="Notifikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span x-show="unreadCount > 0" class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full" x-text="unreadCount"></span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white border border-border-light rounded-2xl shadow-2xl z-[999] overflow-hidden" style="display: none;">
                            <div class="p-4 border-b flex items-center justify-between bg-gray-50">
                                <div><span class="font-bold">Notifikasi</span><span x-show="unreadCount > 0" class="ml-1 text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full" x-text="unreadCount + ' baru'"></span></div>
                                <button @click="markAllAsRead()" class="text-xs text-primary font-medium hover:underline">Tandai dibaca</button>
                            </div>
                            <div class="max-h-[320px] overflow-y-auto divide-y text-sm">
                                <template x-for="notif in notifications" :key="notif.id">
                                    <div @click="handleNotificationClick(notif)" class="px-4 py-3 hover:bg-gray-50 cursor-pointer flex gap-3 group" :class="{ 'bg-orange-50/50': !notif.read }">
                                        <div class="mt-0.5 flex-shrink-0" :class="notif.iconColor"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-html="notif.icon"></svg></div>
                                        <div><p class="font-semibold text-sm" x-text="notif.title"></p><p class="text-xs text-text-muted leading-snug mt-0.5" x-text="notif.message"></p><p class="text-[10px] text-text-muted mt-1" x-text="notif.time"></p></div>
                                    </div>
                                </template>
                            </div>
                            <div class="p-3 border-t bg-gray-50">
                                <a href="{{ route('dashboard.notifikasi') }}" class="block w-full text-center text-sm font-semibold text-primary hover:text-primary-dark">Lihat Semua Notifikasi →</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="text-text-muted hover:text-primary transition-colors p-2" data-hover="scale">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>
                <button data-darkmode-toggle class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-text-muted hover:text-primary transition-all flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>
                <div class="hidden sm:flex items-center gap-2 border-l border-border pl-5">
                    <span class="text-sm font-medium text-text">{{ $currentUser?->name ?? 'Pemilik Kos' }} <br><span class="text-[0.65rem] text-text-muted font-normal block">Owner</span></span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Pemilik Kos') }}&background=F47C20&color=fff&size=32" class="w-8 h-8 rounded-full border border-border">
                </div>
            </div>
        </header>
        <div class="p-6 md:p-8 flex-1 scroll-animate-container">
            @yield('content')
        </div>
        <footer class="p-6 border-t border-border-light text-center">
            <p class="text-xs text-text-muted">&copy; 2024 KosCheck Indonesia • Platform Terpercaya Untuk Pemilik Kos.</p>
        </footer>
    </main>

    <div id="menu-overlay" onclick="closeMobileMenu()"></div>
    <div id="mobile-menu" class="p-6 flex h-full flex-col">
        <div class="flex items-center justify-between mb-8">
            <x-site-logo :href="route('home')" variant="navbar" class="items-center" />
            <button onclick="closeMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-label="Tutup menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="mb-6 p-4 bg-gray-100 rounded-xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Pemilik Kos') }}&background=F47C20&color=fff" class="rounded-full w-full h-full object-cover">
            </div>
            <div>
                <h3 class="font-bold text-sm text-text leading-tight">{{ $currentUser?->name ?? 'Pemilik Kos' }}</h3>
                <p class="text-[0.65rem] text-green-600 font-bold tracking-wide mt-0.5">TERVERIFIKASI</p>
            </div>
        </div>
        <nav class="flex flex-col gap-2 flex-1 overflow-y-auto">
            <a href="{{ route('owner.dashboard') }}" class="owner-nav-item {{ request()->routeIs('owner.dashboard', 'dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dashboard.properti') }}" class="owner-nav-item {{ request()->routeIs('dashboard.properti', 'dashboard.kos.show') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>Properti Saya</span>
            </a>
            <a href="{{ route('dashboard.booking') }}" class="owner-nav-item {{ request()->routeIs('dashboard.booking') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Booking</span>
            </a>
            <a href="{{ route('dashboard.kos.create') }}" class="owner-nav-item {{ request()->routeIs('dashboard.kos.create', 'dashboard.kos.edit', 'dashboard.tambah-properti') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Tambah Properti</span>
            </a>
            <a href="{{ route('dashboard.notifikasi') }}" class="owner-nav-item {{ request()->routeIs('dashboard.notifikasi') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span>Notifikasi</span>
            </a>
            <a href="{{ route('dashboard.pengaturan') }}" class="owner-nav-item {{ request()->routeIs('dashboard.pengaturan') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Pengaturan</span>
            </a>
        </nav>
        <div class="pt-4 mt-4 border-t border-border">
            <a href="{{ route('logout.get') }}" class="owner-nav-item text-red-500 hover:text-red-600 hover:bg-red-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Keluar</span>
            </a>
        </div>
    </div>

<x-owner-mobile-bottom-nav />
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
        try { localStorage.setItem('owner_sidebar_collapsed',c); } catch(e){}
    }
    </script>
    <script>
    (function () {
        const pingUrl = @json(route('dashboard.presence.heartbeat'));
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!pingUrl || !token) return;

        const ping = () => {
            fetch(pingUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                keepalive: true,
            })
            .then((response) => response.json())
            .then((data) => {
                const statusEl = document.getElementById('owner-online-status');
                if (!statusEl) return;
                const isOnline = Boolean(data && data.is_online);
                statusEl.textContent = isOnline ? 'ONLINE' : 'OFFLINE';
                statusEl.classList.toggle('text-green-600', isOnline);
                statusEl.classList.toggle('text-gray-500', !isOnline);
            })
            .catch(() => {});
        };

        ping();
        setInterval(ping, 30000);
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') ping();
        });
    })();
    </script>
    <script>
    function ownerNotifications() {
        return {
            open: false,
            notifications: @json($ownerNotificationItems ?? []),
            get unreadCount() { return this.notifications.filter(function(n) { return !n.read; }).length; },
            markAllAsRead() {
                fetch('{{ route('dashboard.notifikasi.read-all') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                }).finally(() => {
                    this.notifications.forEach(function(n) { n.read = true; });
                });
            },
            handleNotificationClick(notif) {
                notif.read = true;
                this.open = false;
                window.location.href = notif.url || '{{ route("dashboard.notifikasi") }}';
            },
            init() {}
        }
    }
    </script>

</body>
</html>
