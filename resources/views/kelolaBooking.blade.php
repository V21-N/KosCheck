@extends('layouts.owner')

@section('title', 'Kelola Booking — KosCheck')

@section('topbar_left')
    <div class="input-with-icon w-72 hidden md:block">
        <span class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></span>
        <form method="GET" action="{{ route('dashboard.booking') }}">
            <input type="text"
                   name="search"
                   value="{{ $filters['search'] }}"
                   placeholder="Cari booking..."
                   class="input-field py-2 text-sm bg-gray-50 border-none rounded-full">
        </form>
    </div>
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

<div class="mb-6">
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

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-text mb-1">Kelola Booking Mahasiswa</h1>
            <p class="text-sm text-text-muted">Permintaan booking masuk dari mahasiswa akan tampil di sini.</p>
        </div>
        <a href="{{ route('dashboard.properti') }}" class="btn btn-white text-sm">Lihat Properti</a>
    </div>

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

    <form method="GET" action="{{ route('dashboard.booking') }}" class="card p-4 md:p-5 mb-5 flex flex-col md:flex-row gap-3 md:items-center">
        <div class="flex-1">
            <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari mahasiswa, kos, atau universitas..." class="input-field">
        </div>
        <input type="hidden" name="status" value="{{ $filters['status'] ?? '' }}">
        <button type="submit" class="btn btn-primary px-5">Cari</button>
    </form>

    <div class="flex flex-wrap gap-2 mb-5">
        @foreach($statusTabs as $key => $label)
            <a href="{{ route('dashboard.booking', array_filter(['status' => $key === 'all' ? null : $key, 'search' => $filters['search'] ?: null])) }}"
               class="px-4 py-2 rounded-full text-sm font-semibold border {{ ($filters['status'] ?? null) === $key || ($key === 'all' && empty($filters['status'])) ? 'bg-primary text-white border-primary' : 'bg-white border-border-light text-text-muted' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="card border border-border-light shadow-sm rounded-3xl overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b text-xs font-bold text-text-muted uppercase tracking-wider">
                        <th class="p-4 pl-6 font-medium">Mahasiswa</th>
                        <th class="p-4 font-medium">Kos</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Detail</th>
                        <th class="p-4 pr-6 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light text-sm">
                    @forelse($bookingData as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 pl-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $booking['avatar'] }}" class="w-9 h-9 rounded-full object-cover ring-1 ring-gray-200" alt="{{ $booking['nama'] }}">
                                    <div>
                                        <p class="font-bold text-text">{{ $booking['nama'] }}</p>
                                        <p class="text-[0.65rem] text-text-muted">{{ $booking['universitas'] }}</p>
                                        <p class="text-[0.65rem] text-text-muted">{{ $booking['phone'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $booking['kos_photo'] }}" alt="{{ $booking['kos'] }}" class="w-16 h-16 rounded-2xl object-cover">
                                    <div>
                                        <p class="font-semibold text-text">{{ $booking['kos'] }}</p>
                                        <p class="text-xs text-text-muted">{{ $booking['tanggal'] }}</p>
                                        <p class="text-xs text-text-muted">{{ $booking['durasi'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-block text-xs font-bold px-3 py-1 rounded-full
                                    {{ $booking['status'] === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($booking['status'] === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700') }}">
                                    {{ $booking['statusLabel'] }}
                                </span>
                                @if(!empty($booking['rejection_reason']))
                                    <p class="mt-2 text-xs text-red-600">Alasan: {{ $booking['rejection_reason'] }}</p>
                                @endif
                            </td>
                            <td class="p-4">
                                <a href="{{ route('dashboard.kos.show', ['slug' => $booking['kos_slug']]) }}" class="text-primary font-semibold text-sm hover:underline">Lihat Detail Kos</a>
                                <p class="text-xs text-text-muted mt-1">Dibuat {{ $booking['created_at'] }}</p>
                            </td>
                            <td class="p-4 pr-6">
                                <div class="flex items-center justify-end gap-2 flex-wrap">
                                    @if($booking['status'] === 'pending')
                                        <form method="POST" action="{{ route('dashboard.booking.status', ['booking' => $booking['id']]) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-3 py-2 text-xs font-bold bg-emerald-600 text-white rounded-xl hover:bg-emerald-700">Terima</button>
                                        </form>
                                        <form method="POST" action="{{ route('dashboard.booking.status', ['booking' => $booking['id']]) }}" class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <input type="text" name="rejection_reason" placeholder="Alasan tolak" class="w-40 px-3 py-2 text-xs border border-border-light rounded-xl">
                                            <button type="submit" class="px-3 py-2 text-xs font-bold bg-red-600 text-white rounded-xl hover:bg-red-700">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-text-muted">Sudah diproses</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-text-muted">
                                Belum ada booking yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
