@extends('layouts.admin')
@section('title', 'Laporan Masuk — KosCheck Admin')

@section('topbar_left')
    <h1 class="text-xl font-bold text-text">Laporan Masuk</h1>
@endsection

@section('content')
<section class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card p-5 border-none shadow-sm" data-hover="lift" data-reveal>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-text-muted uppercase tracking-wide">Total</span>
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-text">24</h3>
            <p class="text-xs text-text-muted mt-1">Semua laporan</p>
        </div>
        <div class="card p-5 border-none shadow-sm" data-hover="lift" data-reveal>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-text-muted uppercase tracking-wide">Pending</span>
                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-text">8</h3>
            <p class="text-xs text-text-muted mt-1">Menunggu review</p>
        </div>
        <div class="card p-5 border-none shadow-sm" data-hover="lift" data-reveal>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-text-muted uppercase tracking-wide">Diproses</span>
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-text">5</h3>
            <p class="text-xs text-text-muted mt-1">Sedang diproses</p>
        </div>
        <div class="card p-5 border-none shadow-sm" data-hover="lift" data-reveal>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-text-muted uppercase tracking-wide">Selesai</span>
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-text">11</h3>
            <p class="text-xs text-text-muted mt-1">Telah diselesaikan</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-5 border-none shadow-sm" data-hover="lift">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="input-with-icon flex-1">
                    <span class="input-icon">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari laporan..." class="input-field">
                </div>
                <select class="input-field w-auto">
                    <option>Semua Status</option>
                    <option>Pending</option>
                    <option>Diproses</option>
                    <option>Selesai</option>
                </select>
                <select class="input-field w-auto">
                    <option>Semua Jenis</option>
                    <option>Penipuan</option>
                    <option>Foto Palsu</option>
                    <option>Spam</option>
                    <option>Konten Tidak Pantas</option>
                    <option>Review Palsu</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="flex items-center gap-2 text-xs text-text-muted">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Update terakhir: 5 menit lalu
            </div>
        </div>
    </div>

    {{-- Reports List --}}
    <div class="space-y-4" x-data="reportsPage()">
        {{-- Report Item --}}
        <div class="card bg-white border border-border-light overflow-hidden" data-hover="lift">
            <div class="p-5">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge bg-red-100 text-red-700 text-xs font-semibold">PENIPUAN</span>
                                <span class="badge bg-amber-100 text-amber-700 text-xs">Pending</span>
                            </div>
                            <h3 class="font-bold text-base text-text">Kos Skyline Student Residence</h3>
                            <p class="text-sm text-text-muted mt-1">Pemilik meminta transfer DP ke rekening pribadi bukan ke platform.</p>
                            <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-text-muted">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Dilaporkan oleh: andi_wijaya@usu.ac.id
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    2 jam yang lalu
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    2 lampiran
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex lg:flex-col items-center lg:items-end gap-2 lg:gap-3">
                        <button class="btn btn-white btn-sm">Tolak</button>
                        <button class="btn btn-primary btn-sm">Proses</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Report Item 2 --}}
        <div class="card bg-white border border-border-light overflow-hidden" data-hover="lift">
            <div class="p-5">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge bg-orange-100 text-orange-700 text-xs font-semibold">FOTO PALSU</span>
                                <span class="badge bg-blue-100 text-blue-700 text-xs">Diproses</span>
                            </div>
                            <h3 class="font-bold text-base text-text">Kos Melati Residence</h3>
                            <p class="text-sm text-text-muted mt-1">Foto yang ditampilkan tidak sesuai. Kamar lebih kecil dari foto dan AC tidak ada.</p>
                            <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-text-muted">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Dilaporkan oleh: siti_rahma@unpad.ac.id
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    1 hari yang lalu
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    3 lampiran
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex lg:flex-col items-center lg:items-end gap-2 lg:gap-3">
                        <button class="btn btn-white btn-sm">Tolak</button>
                        <button class="btn btn-primary btn-sm">Proses</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Report Item 3 --}}
        <div class="card bg-white border border-border-light overflow-hidden" data-hover="lift">
            <div class="p-5">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge bg-purple-100 text-purple-700 text-xs font-semibold">SPAM</span>
                                <span class="badge bg-green-100 text-green-700 text-xs">Selesai</span>
                            </div>
                            <h3 class="font-bold text-base text-text">Review - Kos Green Living</h3>
                            <p class="text-sm text-text-muted mt-1">Review promosi terselubung dari akun yang tidak jelas. Diduga review sponsored.</p>
                            <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-text-muted">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Dilaporkan oleh: wahyu_student@ugm.ac.id
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    3 hari yang lalu
                                </span>
                                <span class="flex items-center gap-1 text-green-600 font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Review dihapus
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex lg:flex-col items-center lg:items-end gap-2 lg:gap-3">
                        <span class="text-xs text-green-600 font-medium">✓ Diverifikasi</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Report Item 4 --}}
        <div class="card bg-white border border-border-light overflow-hidden" data-hover="lift">
            <div class="p-5">
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="badge bg-gray-100 text-gray-700 text-xs font-semibold">LAINNYA</span>
                                <span class="badge bg-amber-100 text-amber-700 text-xs">Pending</span>
                            </div>
                            <h3 class="font-bold text-base text-text">Pemilik Kos - Budi Santoso</h3>
                            <p class="text-sm text-text-muted mt-1">Nomor WhatsApp tidak aktif. Sudah 2 minggu tidak ada respons.</p>
                            <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-text-muted">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Dilaporkan oleh: rizki_fauzan@itb.ac.id
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    4 hari yang lalu
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex lg:flex-col items-center lg:items-end gap-2 lg:gap-3">
                        <button class="btn btn-white btn-sm">Tolak</button>
                        <button class="btn btn-primary btn-sm">Proses</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-text-muted">Menampilkan 1-4 dari 24 laporan</p>
            <div class="flex items-center gap-2">
                <button class="btn btn-white btn-sm" disabled>Previous</button>
                <button class="btn btn-white btn-sm">1</button>
                <button class="btn btn-primary btn-sm">2</button>
                <button class="btn btn-white btn-sm">3</button>
                <button class="btn btn-white btn-sm">...</button>
                <button class="btn btn-white btn-sm">6</button>
                <button class="btn btn-white btn-sm">Next</button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function reportsPage() {
    return {
        // This would be populated with real data in production
    };
}
</script>
@endpush