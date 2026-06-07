@extends('layouts.owner')
@section('title', 'Properti Saya - KosCheck')

@section('topbar_left')
<div class="input-with-icon w-64 hidden md:block">
    <span class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></span>
    <input type="text" placeholder="Cari properti..." class="input-field py-2 text-sm bg-gray-50 border-none rounded-full">
</div>
@endsection

@section('content')
@php
    $totalBookings = $kosList->sum('bookings_count');
    $totalReviews = $kosList->sum('reviews_count');
    $activeKos = $kosList->where('status', 'active')->count();
    $premiumKos = $kosList->where('is_premium', true)->count();
@endphp

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-text mb-1">Properti Saya</h1>
        <p class="text-sm text-text-muted">Semua data di halaman ini diambil langsung dari properti yang sudah kamu publish.</p>
    </div>
    <a href="{{ route('dashboard.kos.create') }}" class="btn btn-primary px-6 shadow-sm inline-flex items-center gap-2" data-hover="lift">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Properti Baru
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-4 gap-5 mb-8">
    <div class="card p-5 border border-border-light shadow-sm flex items-center gap-4 bg-white rounded-2xl" data-hover="lift" data-reveal>
        <div class="w-14 h-14 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
            <p class="text-[0.65rem] font-bold text-text-muted uppercase tracking-wider mb-0.5">Total Properti</p>
            <p class="text-xl font-bold text-text">{{ $kosList->count() }}</p>
        </div>
    </div>
    <div class="card p-5 border border-border-light shadow-sm flex items-center gap-4 bg-white rounded-2xl" data-hover="lift" data-reveal>
        <div class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        </div>
        <div>
            <p class="text-[0.65rem] font-bold text-text-muted uppercase tracking-wider mb-0.5">Properti Aktif</p>
            <p class="text-xl font-bold text-text">{{ $activeKos }}</p>
        </div>
    </div>
    <div class="card p-5 border border-border-light shadow-sm flex items-center gap-4 bg-white rounded-2xl" data-hover="lift" data-reveal>
        <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        </div>
        <div>
            <p class="text-[0.65rem] font-bold text-text-muted uppercase tracking-wider mb-0.5">Booking Terkait</p>
            <p class="text-xl font-bold text-text">{{ $totalBookings }}</p>
        </div>
    </div>
    <div class="card p-5 border border-border-light shadow-sm flex items-center gap-4 bg-white rounded-2xl" data-hover="lift" data-reveal>
        <div class="w-14 h-14 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <div>
            <p class="text-[0.65rem] font-bold text-text-muted uppercase tracking-wider mb-0.5">Total Ulasan</p>
            <p class="text-xl font-bold text-text">{{ $totalReviews }}</p>
        </div>
    </div>
</div>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-bold text-text">Daftar Properti Aktif</h2>
    <div class="flex gap-1 bg-gray-100 p-1 rounded-lg">
        <button class="p-1.5 bg-white shadow-sm rounded-md text-text"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg></button>
        <button class="p-1.5 text-text-muted hover:text-text"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg></button>
    </div>
</div>

<div class="space-y-5">
    @forelse($kosList as $kos)
        @php
            $photo = $kos->photos->first();
            $photoUrl = $photo?->url ? asset('storage/' . ltrim($photo->url, '/')) : asset('images/kos-bedroom.png');
            $price = number_format((int) $kos->price, 0, ',', '.');
            $rating = $kos->reviews_count > 0 ? number_format((float) ($kos->avg_rating ?? 0), 1) : '-';
            $statusClass = $kos->status === 'active'
                ? 'bg-green-700 border-green-800'
                : ($kos->status === 'pending' ? 'bg-orange-700 border-orange-800' : 'bg-gray-700 border-gray-800');
        @endphp
        <div class="card bg-white shadow-sm border border-border-light overflow-hidden flex flex-col md:flex-row rounded-3xl relative pr-6" data-hover="lift" data-reveal>
            <div class="relative w-full md:w-72 h-56 md:h-auto flex-shrink-0">
                <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                <div class="absolute top-3 left-3 flex gap-2 flex-wrap">
                    <span class="badge {{ $statusClass }} text-white text-[0.65rem] border shadow-sm">
                        {{ ucfirst($kos->status) }}
                    </span>
                    @if($kos->is_premium)
                        <span class="badge bg-orange-400 text-white text-[0.65rem] border border-orange-500 shadow-sm flex items-center gap-1">Premium</span>
                    @endif
                </div>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between mb-1 gap-3 sm:gap-0">
                        <div>
                            <h3 class="text-lg font-bold text-text">{{ $kos->name }}</h3>
                            <div class="flex items-center gap-1 text-text-muted text-xs mt-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ \Illuminate\Support\Str::limit($kos->address, 75) }}
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="font-extrabold text-primary text-xl">Rp {{ $price }}</p>
                            <p class="text-[0.65rem] text-text-muted">per bulan</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-6 border-b border-border-light pb-6">
                        <div class="flex items-center gap-2 text-xs font-semibold text-text">
                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-text-muted"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                            {{ $kos->bookings_count }} Booking
                        </div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-text">
                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-text-muted"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg></div>
                            {{ $kos->reviews_count }} Ulasan
                        </div>
                        <div class="flex items-center gap-2 text-xs font-semibold text-text">
                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-text-muted font-bold text-xs">{{ $rating }}</div>
                            Rating
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 mt-4">
                    <div class="flex gap-2 w-full md:w-auto">
                        <a href="{{ route('dashboard.kos.edit', $kos) }}" class="btn btn-primary px-5 py-2 text-xs">Edit Kos</a>
                        <a href="{{ route('kos.show', ['slug' => $kos->slug]) }}" class="btn btn-white px-5 py-2 text-xs border-gray-200 hover:bg-gray-50 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Lihat Detail
                        </a>
                    </div>
                    <a href="{{ route('dashboard.booking', ['search' => $kos->name]) }}" class="btn btn-sm bg-green-700 text-white hover:bg-green-800 flex items-center gap-1 rounded-full px-4 border-none shadow-sm text-xs font-bold" data-hover="lift">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Booking
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="card border border-dashed border-border-light bg-white p-10 text-center text-text-muted rounded-3xl">
            Belum ada properti yang dipublikasikan.
            <div class="mt-4">
                <a href="{{ route('dashboard.kos.create') }}" class="btn btn-primary btn-sm">Tambah Properti</a>
            </div>
        </div>
    @endforelse
</div>
@endsection
