@extends('layouts.mahasiswa')
@section('title', 'Dashboard Mahasiswa — KosCheck')

@section('topbar_left')
    @php($currentUser = auth()->user())
    <div>
        <h1 class="text-xl font-bold text-text">Dashboard Mahasiswa</h1>
        <p class="text-xs text-text-muted mt-0.5">Selamat datang kembali, {{ $currentUser?->name ?? 'Mahasiswa' }}!</p>
    </div>
@endsection

@section('content')
<section class="bg-bg" data-reveal>
    <div class="container-custom">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4" data-reveal>
            <div>
                <h1 class="text-2xl font-bold text-text">Dashboard Mahasiswa</h1>
                <p class="text-sm text-text-muted mt-1">Kelola pencarian kos dan riwayat aktivitas kamu.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge badge-verified bg-green-100 text-green-800 border border-green-200">Akun Terverifikasi</span>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8 scroll-animate-container">
            <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
                <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
                <p class="text-xs text-text-muted font-medium mb-1">Kos Disimpan</p>
                <h3 class="text-3xl font-extrabold text-text">{{ $savedKosCount }} <span class="text-base font-medium text-text-muted">Kos</span></h3>
            </div>
            <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
                <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                <p class="text-xs text-text-muted font-medium mb-1">Review Ditulis</p>
                <h3 class="text-3xl font-extrabold text-text">{{ $reviewCount }} <span class="text-base font-medium text-text-muted">Ulasan</span></h3>
            </div>
            <div class="card p-5 border-none shadow-sm relative overflow-hidden" data-hover="lift" data-reveal>
                <div class="absolute top-0 left-0 w-1 h-full bg-green-600"></div>
                <p class="text-xs text-text-muted font-medium mb-1">Booking Aktif</p>
                <h3 class="text-3xl font-extrabold text-text">{{ $bookingActiveCount }} <span class="text-base font-medium text-text-muted">Booking</span></h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 scroll-animate-container">
            {{-- Kos Disimpan --}}
            <div class="lg:col-span-2 space-y-5" data-reveal>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-text">Kos yang Disimpan</h2>
                    <a href="{{ route('kos.index') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">Cari Kos Baru</a>
                </div>

                @forelse($savedKos as $kos)
                <div class="card p-4 border-none shadow-sm flex gap-4 items-center" data-hover="lift">
                    <img src="{{ $kos->primaryPhoto ? asset('storage/' . $kos->primaryPhoto->url) : asset('images/hero-illustration.png') }}" alt="{{ $kos->name }}" class="w-20 h-16 rounded-lg object-cover flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-sm text-text truncate">{{ $kos->name }}</h3>
                        <p class="text-xs text-text-muted mt-1">{{ $kos->address ?? 'Lokasi tidak tersedia' }}</p>
                        <p class="text-sm font-bold text-primary mt-1">Rp {{ number_format($kos->price, 0, ',', '.') }}<span class="text-xs font-normal text-text-muted">/bln</span></p>
                    </div>
                    <a href="{{ route('student.kos.show', ['slug' => $kos->slug]) }}" class="btn btn-primary btn-sm flex-shrink-0">Detail</a>
                </div>
                @empty
                <div class="card p-8 border-none shadow-sm flex flex-col items-center text-center">
                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <p class="text-sm text-text-muted font-medium">Belum ada kos yang disimpan.</p>
                    <a href="{{ route('student.kos') }}" class="btn btn-primary btn-sm mt-3">Cari Kos</a>
                </div>
                @endforelse
            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="space-y-5" data-reveal>
                <h2 class="text-lg font-bold text-text">Aktivitas Terbaru</h2>
                <div class="card p-5 border-none shadow-sm space-y-4" data-hover="lift">
                    @forelse($activities as $aktivitas)
                    <div class="flex items-start gap-3 pb-3 {{ !$loop->last ? 'border-b border-border-light' : '' }}">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                            @if($aktivitas['icon'] === 'heart')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            @elseif($aktivitas['icon'] === 'chat')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-text leading-relaxed">{{ $aktivitas['text'] }}</p>
                            <p class="text-xs text-text-muted mt-1">{{ $aktivitas['time'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center text-center py-4">
                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-text-muted font-medium">Belum ada aktivitas.</p>
                        <p class="text-xs text-text-muted mt-1">Mulai cari kos, booking, atau tulis review!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
