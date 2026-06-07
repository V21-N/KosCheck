@php
    $items = [
        [
            'label' => 'Dashboard',
            'href' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 5.75h6.5v5.5h-6.5zM12.75 5.75h6.5v8h-6.5zM4.75 13.75h6.5v4.5h-6.5zM12.75 16.25h6.5v2h-6.5z"/>',
        ],
        [
            'label' => 'Properti',
            'href' => route('dashboard.properti'),
            'active' => request()->routeIs('dashboard.properti'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 20.25h15"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 20.25V6.75a1.5 1.5 0 0 1 1.5-1.5h7.5a1.5 1.5 0 0 1 1.5 1.5v13.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 9.25h.01M14 9.25h.01M10 12.75h.01M14 12.75h.01M11 20.25v-3.5h2v3.5"/>',
        ],
        [
            'label' => 'Booking',
            'href' => route('dashboard.booking'),
            'active' => request()->routeIs('dashboard.booking'),
            'icon' => '<rect x="4.75" y="6.25" width="14.5" height="13" rx="2" ry="2" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4.75v3M16 4.75v3M4.75 10.25h14.5"/>',
        ],
        [
            'label' => 'Tambah',
            'href' => route('dashboard.kos.create'),
            'active' => request()->routeIs('dashboard.kos.create', 'dashboard.kos.edit', 'dashboard.tambah-properti'),
            'icon' => '<circle cx="12" cy="12" r="7.25" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8.5v7M8.5 12h7"/>',
        ],
        [
            'label' => 'Akun',
            'href' => route('dashboard.pengaturan'),
            'active' => request()->routeIs('dashboard.pengaturan'),
            'icon' => '<circle cx="12" cy="8" r="3.25" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 19c1.75-2.25 4.08-3.38 7-3.38 2.92 0 5.25 1.13 7 3.38"/>',
        ],
    ];
@endphp

<nav class="mobile-bottom-nav lg:hidden" aria-label="Navigasi owner mobile">
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
