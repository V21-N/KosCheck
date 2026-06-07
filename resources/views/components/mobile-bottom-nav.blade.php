@php
    $accountUrl = request()->routeIs('profil') ? route('profil') : route('login');

    $items = [
        [
            'label' => 'Beranda',
            'href' => route('home'),
            'active' => request()->routeIs('home'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10.5 12 3l9 7.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.25 9.75V20a.75.75 0 0 0 .75.75h12a.75.75 0 0 0 .75-.75V9.75"/>',
        ],
        [
            'label' => 'Cari Kos',
            'href' => route('kos.index'),
            'active' => request()->routeIs('kos.index', 'cari-kos', 'kos.show', 'detail-kos', 'kos.review.create', 'booking'),
            'icon' => '<circle cx="11" cy="11" r="6" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m20 20-4.2-4.2"/>',
        ],
        [
            'label' => 'Galon',
            'href' => route('layanan-galon'),
            'active' => request()->routeIs('layanan-galon', 'pesan-galon', 'detail-partner'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3c3 3.2 5.5 6.8 5.5 10.2A5.5 5.5 0 1 1 6.5 13.2C6.5 9.8 9 6.2 12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.25 14.25c.7.95 1.62 1.43 2.75 1.43 1.13 0 2.05-.48 2.75-1.43"/>',
        ],
        [
            'label' => 'Bantuan',
            'href' => route('bantuan'),
            'active' => request()->routeIs('bantuan'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.1 9a3 3 0 1 1 5.8 1c-.25.67-.82 1.08-1.4 1.48-.7.48-1.5 1.03-1.5 2.02"/><circle cx="12" cy="17" r=".9" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r="9" stroke-width="1.8"/>',
        ],
        [
            'label' => 'Akun',
            'href' => $accountUrl,
            'active' => request()->routeIs('login', 'register', 'profil'),
            'icon' => '<circle cx="12" cy="8" r="3.25" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 19c1.75-2.25 4.08-3.38 7-3.38 2.92 0 5.25 1.13 7 3.38"/>',
        ],
    ];
@endphp

<nav class="mobile-bottom-nav md:hidden" aria-label="Navigasi utama mobile">
    <div class="mobile-bottom-nav__list">
        @foreach ($items as $item)
            <a
                href="{{ $item['href'] }}"
                class="mobile-bottom-nav__item {{ $item['active'] ? 'is-active' : '' }}"
                @if ($item['active']) aria-current="page" @endif
            >
                <svg class="mobile-bottom-nav__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    {!! $item['icon'] !!}
                </svg>
                <span class="mobile-bottom-nav__label">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
