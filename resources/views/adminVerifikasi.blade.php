@extends('layouts.admin')
@section('title', 'Verifikasi Kos — Admin Panel')

@section('topbar_left')
    <div>
        <h1 class="text-xl font-bold text-text">Verifikasi Kos</h1>
        <p class="text-xs text-text-muted mt-1">Antrian listing baru yang perlu dicek sebelum tayang.</p>
    </div>
@endsection

@section('topbar_right')
    <a href="{{ route('admin.kos') }}" class="btn btn-white btn-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Lihat Semua
    </a>
@endsection

@php
    $statusFilters = [
        'semua' => ['label' => 'Semua', 'count' => $statusCounts['total'] ?? 0, 'class' => 'bg-primary text-white'],
        'menunggu' => ['label' => 'Menunggu', 'count' => $statusCounts['pending'] ?? 0, 'class' => 'bg-orange-500 text-white'],
        'disetujui' => ['label' => 'Disetujui', 'count' => $statusCounts['active'] ?? 0, 'class' => 'bg-emerald-600 text-white'],
        'ditolak' => ['label' => 'Ditolak', 'count' => $statusCounts['rejected'] ?? 0, 'class' => 'bg-red-600 text-white'],
    ];

    // Determine active filter from request
    $currentStatus = request('status', 'semua');
    $activeCount = $statusCounts['active'] ?? 0;
    $pendingCount = $statusCounts['pending'] ?? 0;
    $rejectedCount = $statusCounts['rejected'] ?? 0;
    $totalCount = $statusCounts['total'] ?? 0;
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="card p-4 text-center border-none shadow-sm">
            <p class="text-2xl font-bold text-primary">{{ $totalCount }}</p>
            <p class="text-xs text-text-muted mt-1">Total Kos</p>
        </div>
        <div class="card p-4 text-center border-none shadow-sm">
            <p class="text-2xl font-bold text-orange-500">{{ $pendingCount }}</p>
            <p class="text-xs text-text-muted mt-1">Menunggu</p>
        </div>
        <div class="card p-4 text-center border-none shadow-sm">
            <p class="text-2xl font-bold text-emerald-600">{{ $activeCount }}</p>
            <p class="text-xs text-text-muted mt-1">Disetujui</p>
        </div>
        <div class="card p-4 text-center border-none shadow-sm">
            <p class="text-2xl font-bold text-red-600">{{ $rejectedCount }}</p>
            <p class="text-xs text-text-muted mt-1">Ditolak</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.verifikasi') }}"
               class="btn btn-sm px-4 {{ !request('status') || request('status') === 'semua' ? 'bg-primary text-white' : 'bg-white border border-border-light' }}">
                Semua <span class="text-xs opacity-70">({{ $totalCount }})</span>
            </a>
            <a href="{{ route('admin.verifikasi', ['status' => 'pending']) }}"
               class="btn btn-sm px-4 {{ request('status') === 'pending' ? 'bg-orange-500 text-white' : 'bg-white border border-border-light' }}">
                Menunggu <span class="text-xs opacity-70">({{ $pendingCount }})</span>
            </a>
            <a href="{{ route('admin.verifikasi', ['status' => 'active']) }}"
               class="btn btn-sm px-4 {{ request('status') === 'active' ? 'bg-emerald-600 text-white' : 'bg-white border border-border-light' }}">
                Disetujui <span class="text-xs opacity-70">({{ $activeCount }})</span>
            </a>
            <a href="{{ route('admin.verifikasi', ['status' => 'rejected']) }}"
               class="btn btn-sm px-4 {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-white border border-border-light' }}">
                Ditolak <span class="text-xs opacity-70">({{ $rejectedCount }})</span>
            </a>
        </div>

        <form method="GET" action="{{ route('admin.verifikasi') }}" class="flex gap-3 items-center w-full sm:w-auto">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1 sm:flex-none sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau alamat..."
                       class="w-full pl-9 py-2 text-sm border border-border-light rounded-xl">
                <svg class="w-4 h-4 absolute left-3 top-3 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
        </form>
    </div>

    <!-- Kos List -->
    @if($kos->isEmpty())
        <div class="bg-white border border-border-light rounded-xl p-8 text-center text-text-muted">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p>Tidak ada kos yang ditemukan.</p>
        </div>
    @else
        <div class="card border-none shadow-sm divide-y divide-border-light">
            @foreach($kos as $k)
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                        <!-- Kos Info -->
                        <div class="flex-1">
                            <div class="flex items-start gap-3">
                                @if($k->photos->first())
                                    <img src="{{ $k->photos->first()->url && str_starts_with($k->photos->first()->url, 'http') ? $k->photos->first()->url : asset('storage/' . $k->photos->first()->url) }}"
                                         alt="{{ $k->name }}"
                                         class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-text">{{ $k->name }}</h3>
                                    <p class="mt-1 text-sm text-text-muted">
                                        Owner: {{ $k->owner->name ?? 'N/A' }}
                                    </p>
                                    <p class="text-sm text-text-muted">
                                        <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        {{ $k->address }}
                                    </p>
                                    <div class="flex items-center gap-3 mt-2 flex-wrap">
                                        <span class="inline-flex rounded-full px-3 py-1 text-[0.7rem] font-bold
                                            @if($k->status === 'pending') bg-orange-100 text-orange-700
                                            @elseif($k->status === 'active') bg-emerald-100 text-emerald-700
                                            @else bg-red-100 text-red-600 @endif">
                                            @if($k->status === 'pending') Menunggu
                                            @elseif($k->status === 'active') Disetujui
                                            @else Ditolak @endif
                                        </span>
                                        <span class="text-xs text-text-muted bg-gray-100 px-2 py-1 rounded-full">
                                            {{ ucfirst($k->gender) }}
                                        </span>
                                        <span class="text-xs font-semibold text-primary">
                                            Rp {{ number_format($k->price, 0, ',', '.') }}/bln
                                        </span>
                                        @if($k->is_premium)
                                            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-semibold">
                                                ⭐ Premium
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-2 md:flex-nowrap items-center">
                            <a href="{{ route('kos.show', $k->slug) }}" target="_blank"
                               class="btn btn-white btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat
                            </a>

                            @if($k->status === 'pending')
                                <form action="{{ route('admin.kos.approve', $k) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Setujui
                                    </button>
                                </form>

                                <button type="button" onclick="openRejectModal({{ $k->id }}, '{{ $k->name }}')"
                                        class="btn btn-sm bg-red-50 text-red-600 hover:bg-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Tolak
                                </button>
                            @endif

                            @if($k->status === 'active')
                                <form action="{{ route('admin.kos.premium', $k) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $k->is_premium ? 'bg-yellow-50 text-yellow-600' : 'bg-gray-50 text-gray-600' }}">
                                        {{ $k->is_premium ? '⭐ Cabut Premium' : 'Jadikan Premium' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Facilities -->
                    @if($k->facilities->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-1">
                            @foreach($k->facilities->take(6) as $facility)
                                <span class="text-[0.65rem] bg-bg text-text-muted px-2 py-1 rounded-full">
                                    {{ $facility->name }}
                                </span>
                            @endforeach
                            @if($k->facilities->count() > 6)
                                <span class="text-[0.65rem] bg-bg text-text-muted px-2 py-1 rounded-full">
                                    +{{ $k->facilities->count() - 6 }} lagi
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Timestamps -->
                    <p class="mt-3 text-xs text-text-muted">
                        Dibuat: {{ $k->created_at->format('d M Y, H:i') }}
                        @if($k->updated_at && $k->updated_at->ne($k->created_at))
                            • Diperbarui: {{ $k->updated_at->format('d M Y, H:i') }}
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($kos->hasPages())
            <div class="flex justify-center">
                {{ $kos->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-[999] hidden">
    <div class="bg-white rounded-3xl w-full max-w-md mx-4 p-7" x-transition>
        <div class="flex justify-between mb-4">
            <h3 class="text-xl font-bold">Tolak Kos</h3>
            <button onclick="closeRejectModal()" class="text-2xl text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="rejectForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <p class="text-sm text-text-muted mb-4">
                Kos: <span id="rejectKosName" class="font-semibold text-text"></span>
            </p>

            <div class="mb-4">
                <label class="block text-sm font-medium text-text mb-2">Alasan Penolakan (opsional)</label>
                <textarea name="reason" rows="3" placeholder="Jelaskan alasan penolakan agar owner bisa memperbaiki..."
                          class="w-full px-4 py-2.5 border border-border-light rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeRejectModal()" class="flex-1 py-2.5 bg-gray-100 text-text font-bold rounded-2xl hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700">
                    Tolak Kos
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div id="toast" class="fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-xl text-sm z-[9999]">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) toast.remove();
        }, 3000);
    </script>
@endif

<script>
function openRejectModal(kosId, kosName) {
    document.getElementById('rejectKosName').textContent = kosName;
    document.getElementById('rejectForm').action = '/admin/kos/' + kosId + '/reject';
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal on backdrop click
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endsection