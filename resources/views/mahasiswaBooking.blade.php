@extends('layouts.mahasiswa')

@section('title', 'Booking Saya — KosCheck')

@section('topbar_left')
    <h1 class="text-xl font-bold text-text">Booking Saya</h1>
@endsection

@section('content')
@php
    $statusTabs = [
        'all' => 'Semua',
        'pending' => 'Menunggu',
        'approved' => 'Diterima',
        'rejected' => 'Ditolak',
    ];
@endphp

<div class="max-w-5xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div>
            <p class="text-sm text-text-muted">Daftar booking kos yang sudah kamu ajukan.</p>
        </div>
        <a href="{{ route('kos.index') }}" class="btn btn-primary px-5 text-sm w-full sm:w-auto text-center">Cari Kos Baru</a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-xs text-text-muted uppercase">Total</p>
            <p class="text-2xl font-extrabold">{{ $counts['total'] }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-text-muted uppercase">Menunggu</p>
            <p class="text-2xl font-extrabold text-orange-600">{{ $counts['pending'] }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-text-muted uppercase">Diterima</p>
            <p class="text-2xl font-extrabold text-emerald-600">{{ $counts['approved'] }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-text-muted uppercase">Ditolak</p>
            <p class="text-2xl font-extrabold text-red-600">{{ $counts['rejected'] }}</p>
        </div>
    </div>

    <form method="GET" action="{{ route('student.booking') }}" class="card p-4 md:p-5 mb-6 flex flex-col md:flex-row gap-3 md:items-center">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari kos, alamat, atau owner..." class="input-field">
        </div>
        <input type="hidden" name="status" value="{{ $filters['status'] ?? '' }}">
        <button type="submit" class="btn btn-primary px-5">Cari</button>
    </form>

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($statusTabs as $key => $label)
            <a href="{{ route('student.booking', array_filter(['status' => $key === 'all' ? null : $key, 'search' => $filters['search'] ?: null])) }}"
               class="px-4 py-2 rounded-full text-sm font-semibold border {{ ($filters['status'] ?? null) === $key || ($key === 'all' && empty($filters['status'])) ? 'bg-primary text-white border-primary' : 'bg-white border-border-light text-text-muted' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($bookingsData as $booking)
            <div class="card bg-white border border-border-light p-5 rounded-2xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <img src="{{ $booking['photo'] }}" alt="{{ $booking['kos_name'] }}" class="w-24 h-20 rounded-xl object-cover flex-shrink-0" loading="lazy">
                        <div>
                            <h3 class="font-bold text-lg">{{ $booking['kos_name'] }}</h3>
                            <p class="text-sm text-text-muted">{{ $booking['kos_address'] }}</p>
                            <p class="text-xs text-text-muted mt-1">Owner: {{ $booking['owner_name'] }}</p>
                            <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                <span class="badge {{ $booking['status_class'] }}">{{ $booking['status_label'] }}</span>
                                <span class="badge bg-gray-100 text-gray-700">Masuk {{ $booking['move_in_date'] ?? '-' }}</span>
                                <span class="badge bg-gray-100 text-gray-700">{{ $booking['duration_months'] ? $booking['duration_months'] . ' bulan' : '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-left md:text-right border-t md:border-t-0 border-border-light pt-4 md:pt-0 mt-2 md:mt-0">
                        <p class="font-bold text-primary text-lg">Rp {{ number_format((int) ($booking['price'] ?? 0), 0, ',', '.') }}</p>
                        <p class="text-xs text-text-muted">per bulan</p>
                        <p class="text-xs text-text-muted mt-2">Diajukan: {{ $booking['created_at'] }}</p>
                        @if(!empty($booking['rejection_reason']))
                            <p class="text-xs text-red-600 mt-2">Alasan penolakan: {{ $booking['rejection_reason'] }}</p>
                        @endif
                        <div class="mt-3 flex gap-2 justify-start md:justify-end flex-wrap">
                            <a href="{{ route('student.kos.show', ['slug' => $booking['kos_slug']]) }}" class="btn btn-white btn-sm text-xs flex-1 md:flex-none">Lihat Detail</a>
                            @if(!empty($booking['owner_phone']))
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D+/', '', $booking['owner_phone'])) }}" target="_blank" rel="noopener noreferrer" class="btn btn-white btn-sm text-xs flex-1 md:flex-none">Chat Owner</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-text-muted">
                Belum ada booking. Yuk cari kos yang cocok dulu.
            </div>
        @endforelse
    </div>
</div>
@endsection
