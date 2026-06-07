@extends('layouts.owner')

@section('title', 'Notifikasi - KosCheck Owner')

@section('topbar_left')
    <div>
        <h1 class="text-2xl font-bold text-text">Notifikasi</h1>
        <p class="text-sm text-text-muted mt-0.5">Semua aktivitas dan pemberitahuan yang tersimpan di database.</p>
    </div>
@endsection

@section('content')
@php
    $notificationMeta = [
        'booking' => [
            'label' => 'Booking Baru',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
            'iconColor' => 'text-green-600',
            'badge' => 'bg-green-100 text-green-700',
        ],
        'new_lead' => [
            'label' => 'Lead Baru',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
            'iconColor' => 'text-emerald-600',
            'badge' => 'bg-emerald-100 text-emerald-700',
        ],
        'new_review' => [
            'label' => 'Review Baru',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
            'iconColor' => 'text-yellow-500',
            'badge' => 'bg-yellow-100 text-yellow-700',
        ],
        'booking_status' => [
            'label' => 'Status Booking',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
            'iconColor' => 'text-green-600',
            'badge' => 'bg-green-100 text-green-700',
        ],
        'review_reported' => [
            'label' => 'Review Dilaporkan',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
            'iconColor' => 'text-red-600',
            'badge' => 'bg-red-100 text-red-700',
        ],
        'system' => [
            'label' => 'Sistem',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            'iconColor' => 'text-blue-600',
            'badge' => 'bg-blue-100 text-blue-700',
        ],
    ];

    $filterLabels = ['all' => 'Semua', 'unread' => 'Belum Dibaca'] + collect($typeLabels)->toArray();
    $activeFilter = $filter ?? 'all';
@endphp

<div class="max-w-4xl">
    @if(session('success'))
        <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-sm text-text-muted">Notifikasi tersimpan: {{ $totalCount }} | Belum dibaca: {{ $unreadCount }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <form action="{{ route('dashboard.notifikasi.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-semibold border border-border-light rounded-xl hover:bg-gray-50">
                    Tandai Semua Dibaca
                </button>
            </form>
            <form action="{{ route('dashboard.notifikasi.clear-all') }}" method="POST" onsubmit="return confirm('Hapus semua notifikasi?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-xl border border-red-200">
                    Hapus Semua
                </button>
            </form>
        </div>
    </div>

    <div class="flex gap-2 mb-5 flex-wrap">
        @foreach($filterLabels as $key => $label)
            @php
                $count = $key === 'all'
                    ? $totalCount
                    : ($key === 'unread' ? $unreadCount : (int) ($typeCounts[$key] ?? 0));
            @endphp
            <a href="{{ route('dashboard.notifikasi', array_filter(['type' => $key === 'all' ? null : $key])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition border {{ $activeFilter === $key ? 'bg-primary text-white border-primary' : 'bg-white border-border-light text-text-muted' }}">
                {{ $label }}
                <span class="ml-1 text-[10px] opacity-80">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    <div class="space-y-3">
        @forelse($notifications as $notification)
            @php
                $meta = $notificationMeta[$notification->type] ?? [
                    'label' => \Illuminate\Support\Str::headline(str_replace('_', ' ', $notification->type)),
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'iconColor' => 'text-gray-600',
                    'badge' => 'bg-gray-100 text-gray-700',
                ];

                $kosName = data_get($notification->data, 'kos_name');
                $bookingId = data_get($notification->data, 'booking_id');
                $reviewId = data_get($notification->data, 'review_id');
            @endphp

            <div class="group bg-white border border-border-light rounded-2xl p-5 flex gap-4 hover:shadow-sm transition {{ $notification->is_read ? '' : 'border-primary/30 bg-primary/5' }}">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 bg-opacity-10 {{ $meta['iconColor'] === 'text-emerald-600' ? 'bg-emerald-100' : ($meta['iconColor'] === 'text-yellow-500' ? 'bg-yellow-100' : ($meta['iconColor'] === 'text-green-600' ? 'bg-green-100' : ($meta['iconColor'] === 'text-red-600' ? 'bg-red-100' : 'bg-blue-100'))) }} {{ $meta['iconColor'] }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $meta['icon'] !!}</svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start gap-3">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-text">{{ $notification->title }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $meta['badge'] }}">
                                    {{ $meta['label'] }}
                                </span>
                                @if(!$notification->is_read)
                                    <span class="text-[10px] bg-primary text-white px-2 py-px rounded-full">Baru</span>
                                @endif
                            </div>
                            <p class="text-sm text-text-muted mt-1 leading-relaxed">{{ $notification->message }}</p>
                            <div class="mt-2 flex flex-wrap gap-2 text-xs text-text-muted">
                                @if($kosName)
                                    <span>Kos: {{ $kosName }}</span>
                                @endif
                                @if($bookingId)
                                    <span>Booking ID: {{ $bookingId }}</span>
                                @endif
                                @if($reviewId)
                                    <span>Review ID: {{ $reviewId }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="text-xs text-text-muted whitespace-nowrap">{{ $notification->created_at?->diffForHumans() }}</span>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('dashboard.notifikasi.open', $notification) }}" class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">
                            Lihat Detail
                        </a>

                        @if(!$notification->is_read)
                            <form action="{{ route('dashboard.notifikasi.read', $notification) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs px-3 py-1 bg-primary text-white rounded-lg font-medium">
                                    Tandai Dibaca
                                </button>
                            </form>
                        @else
                            <span class="text-xs px-3 py-1 bg-green-50 text-green-700 rounded-lg font-medium">Sudah dibaca</span>
                        @endif

                        <form action="{{ route('dashboard.notifikasi.destroy', $notification) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1 text-red-500 hover:bg-red-50 rounded-lg font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-text-muted bg-white border border-dashed border-border-light rounded-2xl">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="font-medium">Tidak ada notifikasi</p>
                <p class="text-xs mt-1">Notifikasi baru akan muncul di sini dari data database.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
