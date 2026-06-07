@php
    $items = [
        [
            'label' => 'Dashboard',
            'href' => route('admin'),
            'active' => request()->routeIs('admin'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 5.75h6.5v5.5h-6.5zM12.75 5.75h6.5v8h-6.5zM4.75 13.75h6.5v4.5h-6.5zM12.75 16.25h6.5v2h-6.5z"/>',
        ],
        [
            'label' => 'Verifikasi',
            'href' => route('admin.verifikasi'),
            'active' => request()->routeIs('admin.verifikasi'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.5 12.5 9.5 16l9-9"/><circle cx="12" cy="12" r="8.25" stroke-width="1.8"/>',
        ],
        [
            'label' => 'Review',
            'href' => route('admin.moderasi'),
            'active' => request()->routeIs('admin.moderasi'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8.75h10M7 12h7M7 15.25h5"/><rect x="4.75" y="4.75" width="14.5" height="14.5" rx="2" stroke-width="1.8"/>',
        ],
        [
            'label' => 'Iklan',
            'href' => route('admin.iklan'),
            'active' => request()->routeIs('admin.iklan'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 18.25V7.75a1.5 1.5 0 0 1 1.5-1.5h7.75L19 3.75v12.5L14.25 13.75H6.5A1.5 1.5 0 0 1 5 12.25Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 13.75v4.5"/>',
        ],
        [
            'label' => 'User',
            'href' => route('admin.users'),
            'active' => request()->routeIs('admin.users'),
            'icon' => '<circle cx="9" cy="8" r="2.75" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 18c.95-2.12 2.78-3.18 5.5-3.18 2.72 0 4.55 1.06 5.5 3.18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 9.25a2.5 2.5 0 1 0 0 5M18.25 18c-.44-1.2-1.3-2.03-2.6-2.5"/>',
        ],
    ];
@endphp

<nav class="mobile-bottom-nav lg:hidden" aria-label="Navigasi admin mobile">
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
