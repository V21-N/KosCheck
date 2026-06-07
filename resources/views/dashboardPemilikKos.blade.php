@extends('layouts.owner')
@section('title', 'Dashboard Pemilik - KosCheck')

@section('topbar_left')
<h1 class="text-lg font-bold text-text hidden sm:block">Dashboard</h1>
@endsection

@section('topbar_right')
<span class="badge badge-verified bg-green-400 text-white border border-green-500 shadow-sm hidden md:inline-flex">Pemilik Terverifikasi</span>
@endsection

@section('content')
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-text mb-1">Ringkasan Properti</h1>
        <p class="text-sm text-text-muted">Data yang tampil di bawah diambil langsung dari database milik akun owner kamu.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="badge bg-green-100 text-green-700 border border-green-200">Aktif {{ $activeKosCount }}</span>
        <span class="badge bg-orange-100 text-orange-700 border border-orange-200">Premium {{ $premiumKosCount }}</span>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 scroll-animate-container">
    <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
        <div class="absolute top-0 left-0 w-1 h-full bg-orange-700"></div>
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
        <p class="text-xs text-text-muted font-medium mb-1">Total Properti</p>
        <h3 class="text-3xl font-extrabold text-text">{{ $kosList->count() }} <span class="text-base font-medium text-text-muted">Properti</span></h3>
    </div>

    <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
        <div class="absolute top-0 left-0 w-1 h-full bg-green-600"></div>
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-xs text-text-muted font-medium mb-1">Booking Masuk</p>
        <h3 class="text-3xl font-extrabold text-text">{{ $totalBookings }} <span class="text-base font-medium text-text-muted">Booking</span></h3>
    </div>

    <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
        <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
        </div>
        <p class="text-xs text-text-muted font-medium mb-1">Lead Bulan Ini</p>
        <h3 class="text-3xl font-extrabold text-text">{{ $totalLeads }} <span class="text-base font-medium text-text-muted">Lead</span></h3>
    </div>

    <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
        <div class="absolute top-0 left-0 w-1 h-full bg-purple-500"></div>
        <div class="flex justify-between items-start mb-4">
            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
        </div>
        <p class="text-xs text-text-muted font-medium mb-1">Ulasan Diterima</p>
        <h3 class="text-3xl font-extrabold text-text">{{ $totalReviews }} <span class="text-base font-medium text-text-muted">Ulasan</span></h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-4" data-reveal>
            <h2 class="text-lg font-bold text-text">Aktivitas Terbaru</h2>
            <a href="{{ route('dashboard.booking') }}" class="text-xs font-semibold text-primary hover:text-primary-dark">Lihat Semua Booking</a>
        </div>

        <div class="card border-none shadow-sm divide-y divide-border-light bg-gray-50 overflow-hidden" data-hover="lift">
            @forelse($recentActivities as $activity)
                <div class="p-4 flex items-center justify-between hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $activity['icon'] === 'booking' ? 'bg-green-200 text-green-700' : ($activity['icon'] === 'lead' ? 'bg-orange-200 text-orange-700' : 'bg-blue-200 text-blue-700') }}">
                            @if($activity['icon'] === 'booking')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($activity['icon'] === 'lead')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            @else
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-text">{{ $activity['title'] }}</p>
                            <p class="text-[0.65rem] text-text-muted mt-0.5">{{ $activity['message'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[0.65rem] text-text-muted">{{ $activity['time'] }}</p>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-text-muted">
                    Belum ada aktivitas terbaru.
                </div>
            @endforelse
        </div>
    </div>

    <div class="lg:col-span-1">
        <h2 class="text-lg font-bold text-text mb-4">Ringkasan Cepat</h2>
        <div class="card p-6 bg-primary text-white border-none shadow-md h-full flex flex-col justify-between">
            <ul class="space-y-4">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <p class="text-xs font-medium leading-relaxed">Properti aktif: {{ $activeKosCount }}</p>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs font-medium leading-relaxed">Booking masuk: {{ $totalBookings }}</p>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p class="text-xs font-medium leading-relaxed">Lead bulan ini: {{ $totalLeads }}</p>
                </li>
            </ul>
            <a href="{{ route('dashboard.kos.create') }}" class="btn btn-white text-primary btn-full mt-6 text-xs font-bold py-3 shadow-md hover:-translate-y-0.5">Tambah Properti Baru</a>
        </div>
    </div>
</div>

<div>
    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
        <h2 class="text-lg font-bold text-text">Properti Terbaru</h2>
        <a href="{{ route('dashboard.kos.create') }}" class="btn btn-primary-dark btn-sm text-xs font-semibold px-4 flex items-center gap-1 bg-[#8B4513] hover:bg-[#6b350f] border-none shadow-md" data-hover="lift">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Properti
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 scroll-animate-container">
        @forelse($kosWithStats as $kos)
            @php
                $photo = $kos->photos->first();
                $photoUrl = $photo?->url ? asset('storage/' . ltrim($photo->url, '/')) : asset('images/kos-bedroom.png');
                $rating = $kos->avg_rating !== null ? number_format((float) $kos->avg_rating, 1) : '-';
                $price = number_format((int) $kos->price, 0, ',', '.');
                $statusClass = $kos->status === 'active'
                    ? 'bg-green-700 border-green-800'
                    : ($kos->status === 'pending' ? 'bg-orange-700 border-orange-800' : 'bg-red-700 border-red-800');
            @endphp
            <div class="card border-none shadow-md overflow-hidden bg-white p-4 pb-5 rounded-2xl" data-hover="lift" data-reveal>
                <div class="relative h-48 rounded-xl overflow-hidden mb-4">
                    <img src="{{ $photoUrl }}" class="w-full h-full object-cover" alt="{{ $kos->name }}">
                    <span class="absolute top-3 right-3 badge {{ $statusClass }} text-white text-[0.65rem] px-3 shadow-sm border">
                        {{ ucfirst($kos->status) }}
                    </span>
                    @if($kos->is_premium)
                        <span class="absolute top-3 left-3 badge bg-orange-400 text-white text-[0.65rem] border border-orange-500 shadow-sm">Premium</span>
                    @endif
                </div>
                <div class="px-2">
                    <h3 class="font-bold text-base mb-1">{{ $kos->name }}</h3>
                    <div class="flex items-center gap-1 text-text-muted text-xs mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ \Illuminate\Support\Str::limit($kos->address, 60) }}
                    </div>
                    <div class="flex items-center gap-4 text-xs text-text-muted mb-4">
                        <span>{{ $kos->bookings_count }} booking</span>
                        <span>{{ $kos->reviews_count }} ulasan</span>
                        <span>{{ $rating }} rating</span>
                    </div>
                    <div class="flex items-end justify-between">
                        <p class="font-extrabold text-primary text-base">Rp {{ $price }}<span class="text-[0.65rem] font-normal text-text-muted">/bulan</span></p>
                        <a href="{{ route('dashboard.kos.edit', $kos) }}" class="text-xs font-semibold text-green-600 hover:text-green-700">Edit</a>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('kos.show', ['slug' => $kos->slug]) }}" class="btn btn-white text-primary border-primary flex-1 text-xs py-2 hover:bg-orange-50 font-bold">Lihat Detail</a>
                        <a href="{{ route('dashboard.booking', ['search' => $kos->name]) }}" class="btn btn-white flex-1 text-xs py-2 border-gray-200 hover:bg-gray-50 font-bold">Booking</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-8 text-text-muted">
                <p>Belum ada properti. Tambahkan properti pertama Anda.</p>
                <a href="{{ route('dashboard.kos.create') }}" class="btn btn-primary btn-sm mt-4">Tambah Properti</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
