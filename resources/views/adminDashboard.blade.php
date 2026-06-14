@extends('layouts.admin')
@section('title', 'Admin Panel — KosCheck')

@section('topbar_left')
    <div>
        <h1 class="text-xl font-bold text-text">Admin Panel</h1>
        <p class="text-xs text-text-muted mt-1">Moderasi review, verifikasi kos, dan kontrol inventori iklan lokal.</p>
    </div>
@endsection

@section('topbar_right')
    <div class="flex items-center gap-2">
        <span class="bg-green-100 text-green-800 border border-green-200 text-xs px-3 py-1 rounded-full hidden md:inline-flex">
            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
            Database Connected
        </span>
    </div>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Stats Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 scroll-animate-container">
        <a href="{{ route('admin.verifikasi', ['status' => 'pending']) }}" class="card p-5 border-none shadow-sm relative overflow-hidden block" data-hover="lift" data-reveal>
            <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-text-muted">Kos Menunggu Verifikasi</p>
                    <h2 class="mt-3 text-3xl font-extrabold text-text">{{ $stats['pending_kos'] }}</h2>
                </div>
                <span class="rounded-full bg-bg px-3 py-1 text-[0.65rem] font-bold text-text-muted">
                    {{ $stats['total_kos'] }} total
                </span>
            </div>
        </a>

        <a href="{{ route('admin.moderasi') }}" class="card p-5 border-none shadow-sm relative overflow-hidden block" data-hover="lift" data-reveal>
            <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-text-muted">Review Perlu Moderasi</p>
                    <h2 class="mt-3 text-3xl font-extrabold text-text">{{ $stats['pending_reviews'] }}</h2>
                </div>
                <span class="rounded-full bg-bg px-3 py-1 text-[0.65rem] font-bold text-text-muted">
                    {{ $stats['total_reviews'] }} total
                </span>
            </div>
        </a>

        <a href="{{ route('admin.iklan') }}" class="card p-5 border-none shadow-sm relative overflow-hidden block" data-hover="lift" data-reveal>
            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-text-muted">Laporan Pending</p>
                    <h2 class="mt-3 text-3xl font-extrabold text-text">{{ $stats['pending_reports'] }}</h2>
                </div>
                <span class="rounded-full bg-bg px-3 py-1 text-[0.65rem] font-bold text-text-muted">
                    {{ $stats['total_reports'] }} total
                </span>
            </div>
        </a>
    </section>

    <!-- Verifikasi Kos Section -->
    <section class="grid grid-cols-1 xl:grid-cols-[1.45fr,1fr] gap-6">
        <div class="card border-none shadow-sm" data-hover="lift" data-reveal>
            <div class="flex items-center justify-between gap-3 p-6 border-b border-border-light">
                <div>
                    <h2 class="text-lg font-bold text-text">Verifikasi Kos</h2>
                    <p class="text-sm text-text-muted mt-1">Antrian listing baru yang perlu dicek sebelum tayang.</p>
                </div>
                <a href="{{ route('admin.verifikasi') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-border-light">
                @forelse($recentKos as $listing)
                    <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if($listing->photos->first())
                                <img src="{{ resolve_image_url($listing->photos->first()?->url) }}"
                                     alt="{{ $listing->name }}"
                                     class="w-12 h-12 rounded-xl object-cover" loading="lazy">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-text">{{ $listing->name }}</h3>
                                <p class="mt-1 text-sm text-text-muted">Pemilik: {{ $listing->owner->name ?? 'N/A' }}</p>
                                <span class="mt-2 inline-flex rounded-full px-2.5 py-0.5 text-[0.65rem] font-bold
                                    @if($listing->status === 'pending') bg-orange-100 text-orange-700
                                    @elseif($listing->status === 'active') bg-emerald-100 text-emerald-700
                                    @else bg-red-100 text-red-600 @endif">
                                    @if($listing->status === 'pending') Menunggu Verifikasi
                                    @elseif($listing->status === 'active') Aktif
                                    @else Ditolak @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2 w-full md:w-auto mt-2 md:mt-0">
                            @if($listing->status === 'pending')
                                <form action="{{ route('admin.kos.approve', $listing) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Setujui</button>
                                </form>
                            @else
                                <span class="btn btn-white btn-sm opacity-60 cursor-not-allowed">
                                    @if($listing->status === 'active') ✓ Aktif @else Ditolak @endif
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-text-muted">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p>Tidak ada kos yang perlu diverifikasi</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card border-none shadow-sm p-6 bg-primary text-white" data-hover="lift" data-reveal>
            <h2 class="text-lg font-bold">Checklist Admin</h2>
            <p class="mt-2 text-sm text-white/85">Blok ringkas untuk membantu verifikasi listing tetap konsisten.</p>
            <ul class="mt-6 space-y-4 text-sm">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 6"/></svg>
                    Pastikan foto asli properti dan tidak blur.
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 6"/></svg>
                    Cek alamat, harga, dan tipe kos sesuai form.
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 6"/></svg>
                    Tandai premium bila owner memiliki paket aktif.
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 6"/></svg>
                    Verifikasi nomor WhatsApp aktif dan responsif.
                </li>
            </ul>

            <!-- Quick Stats -->
            <div class="mt-6 pt-6 border-t border-white/20">
                <p class="text-xs font-semibold text-white/70 uppercase tracking-wide">Statistik Cepat</p>
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['total_kos'] }}</p>
                        <p class="text-xs text-white/70">Total Kos</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['active_kos'] }}</p>
                        <p class="text-xs text-white/70">Kos Aktif</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-white/70">Total User</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['leads_this_month'] }}</p>
                        <p class="text-xs text-white/70">Leads Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Reviews Needing Moderation -->
    @if($recentReviews->isNotEmpty())
    <section class="card border-none shadow-sm">
        <div class="flex items-center justify-between gap-3 p-6 border-b border-border-light">
            <div>
                <h2 class="text-lg font-bold text-text">Moderasi Review</h2>
                <p class="text-sm text-text-muted mt-1">Review yang dilaporkan atau terdeteksi perlu ditinjau manual.</p>
            </div>
            <a href="{{ route('admin.moderasi') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-6">
            @foreach($recentReviews as $review)
                <article class="rounded-2xl border border-border-light p-5 bg-bg" data-hover="lift" data-reveal>
                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-[0.7rem] font-bold text-red-600">Butuh Moderasi</span>
                    <div class="flex items-center gap-2 mt-3">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm text-text-muted">{{ $review->rating }}/5</span>
                    </div>
                    <p class="mt-3 text-sm text-text line-clamp-2">{{ $review->comment }}</p>
                    <p class="mt-2 text-xs text-text-muted">{{ $review->kos->name ?? 'N/A' }} • {{ $review->user->name ?? 'Anonim' }}</p>
                    <div class="mt-4 flex gap-2">
                        <form action="{{ route('admin.reviews.hide', $review) }}" method="POST" class="inline flex-1">
                            @csrf
                            <button type="submit" class="btn btn-white btn-sm w-full">Sembunyikan</button>
                        </form>
                        <form action="{{ route('admin.reviews.unflag', $review) }}" method="POST" class="inline flex-1">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm w-full">Publikasi</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Recent Reports -->
    @if($recentReports->isNotEmpty())
    <section class="card border-none shadow-sm">
        <div class="flex items-center justify-between gap-3 p-6 border-b border-border-light">
            <div>
                <h2 class="text-lg font-bold text-text">Laporan Terbaru</h2>
                <p class="text-sm text-text-muted mt-1">Laporan dari pengguna yang perlu ditinjau.</p>
            </div>
            <a href="{{ route('admin.reports') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">Lihat Semua →</a>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentReports as $report)
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-bg hover:bg-gray-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-text">{{ $report->reportType->name ?? 'Laporan' }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-orange-100 text-orange-700">
                                    {{ $report->status === 'pending' ? 'Pending' : ucfirst($report->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-text-muted mt-1">{{ Str::limit($report->description, 100) }}</p>
                            <p class="text-xs text-text-muted mt-2">
                                {{ $report->reporter->name ?? 'Anonim' }} •
                                {{ $report->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Top Performing Kos -->
    @if($topKos->isNotEmpty())
    <section class="card border-none shadow-sm p-6" data-hover="lift" data-reveal>
        <div class="flex items-center justify-between gap-3 mb-5">
            <div>
                <h2 class="text-lg font-bold text-text">Kos Terpopuler</h2>
                <p class="text-sm text-text-muted mt-1">Kos dengan jumlah leads tertinggi.</p>
            </div>
        </div>
        <div class="space-y-4">
            @foreach($topKos as $index => $kos)
                <div class="flex items-center gap-4 p-4 rounded-xl border border-border-light hover:bg-bg transition-colors">
                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">
                        {{ $index + 1 }}
                    </div>
                    @if($kos->photos->first())
                        <img src="{{ resolve_image_url($kos->photos->first()?->url) }}"
                             alt="{{ $kos->name }}"
                             class="w-12 h-12 rounded-xl object-cover" loading="lazy">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-bold text-text">{{ $kos->name }}</h3>
                        <p class="text-sm text-text-muted">{{ $kos->owner->name ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-primary">{{ $kos->leads_count ?? 0 }}</p>
                        <p class="text-xs text-text-muted">Leads</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
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
@endsection