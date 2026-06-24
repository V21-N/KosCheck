@extends('layouts.owner')
@section('title', 'KosCheck+ Premium - Dashboard')

@section('topbar_left')
<h1 class="text-lg font-bold text-text hidden sm:block">KosCheck+</h1>
@endsection

@section('topbar_right')
@if($isPremium)
<span class="badge bg-gradient-to-r from-orange-500 to-amber-500 text-white">
    <svg class="w-3 h-3 mr-1 inline" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
    </svg>
    PREMIUM ACTIVE
</span>
@endif
@endsection

@section('content')
{{-- Success/Error Messages --}}
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-sm text-green-700">{{ session('success') }}</p>
</div>
@endif

@if(session('info'))
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-3">
    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-sm text-blue-700">{{ session('info') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-sm text-red-700">{{ session('error') }}</p>
</div>
@endif

{{-- Premium Status Card --}}
@if($isPremium)
<div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl p-6 text-white mb-8 shadow-lg">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <h2 class="text-xl font-bold">KosCheck+ Premium Active</h2>
            </div>
            <p class="text-white/80 text-sm">
                Sisa <strong>{{ $remainingDays }}</strong> hari subscription
                @if($activeSubscription)
                <span class="mx-2">|</span>
                Berakhir {{ $activeSubscription->expired_at->format('d M Y') }}
                @endif
            </p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('koscheck-plus.history') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition-colors text-white">
                Riwayat Langganan
            </a>
            <form action="{{ route('koscheck-plus.cancel') }}" method="POST" onsubmit="return confirm('Batalkan langganan KosCheck+?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 rounded-lg text-sm font-medium transition-colors text-white">
                    Batalkan
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Analytics Dashboard --}}
<div class="mb-8">
    <h2 class="text-lg font-bold text-text mb-4">Statistik Properti Anda</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="card p-5 border-none shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-text-muted">Pengunjung (30 hari)</span>
            </div>
            <h3 class="text-3xl font-bold text-text">{{ $analytics['views'] ?? 0 }}</h3>
        </div>

        <div class="card p-5 border-none shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-text-muted">Disimpan (30 hari)</span>
            </div>
            <h3 class="text-3xl font-bold text-text">{{ $analytics['favorites'] ?? 0 }}</h3>
        </div>

        <div class="card p-5 border-none shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-text-muted">Klik WhatsApp (30 hari)</span>
            </div>
            <h3 class="text-3xl font-bold text-text">{{ $analytics['whatsapp_clicks'] ?? 0 }}</h3>
        </div>
    </div>
</div>

{{-- Premium Benefits Reminder --}}
<div class="card p-6 border border-orange-200 bg-orange-50 dark:bg-orange-900/20">
    <h3 class="font-bold text-text mb-4">Benefit KosCheck+ Premium Anda</h3>
    <ul class="space-y-3">
        <li class="flex items-center gap-3 text-sm text-text">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Badge Verified pada semua properti Anda</span>
        </li>
        <li class="flex items-center gap-3 text-sm text-text">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Prioritas pencarian lebih tinggi</span>
        </li>
        <li class="flex items-center gap-3 text-sm text-text">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Statistik pengunjung dan favorit real-time</span>
        </li>
    </ul>
</div>

@else
{{-- ⚠️ FIX TOTAL: Non-Premium Upgrade Card --}}
<div class="rounded-2xl p-8 text-white mb-8 relative overflow-hidden shadow-xl" 
     style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">
    
    {{-- Efek blur background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-500/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="relative z-10">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="text-2xl font-bold text-white">KosCheck+</span>
        </div>

        <h2 class="text-3xl font-bold mb-2 text-white">Tingkatkan Properti Anda</h2>
        <p class="text-white/80 mb-6 max-w-lg">
            Dapatkan badge verified, prioritas pencarian, dan statistik real-time untuk meningkatkan visibilitas properti Anda.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                <p class="text-white/60 text-xs mb-1">Harga langganan</p>
                <p class="text-3xl font-bold text-white">Rp {{ number_format($price, 0, ',', '.') }}</p>
                <p class="text-white/60 text-sm">per 30 hari</p>
            </div>
            <a href="{{ route('koscheck-plus.checkout') }}" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 rounded-xl font-bold text-white transition-all transform hover:scale-105 shadow-lg shadow-orange-500/30 inline-block">
                Upgrade Sekarang
            </a>
        </div>
    </div>
</div>

{{-- Benefits Comparison --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="card p-6">
        <h3 class="font-bold text-text mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Paket Gratis
        </h3>
        <ul class="space-y-3">
            <li class="flex items-center gap-3 text-sm text-text-muted">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Dasar pencarian kos
            </li>
            <li class="flex items-center gap-3 text-sm text-text-muted">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tanpa badge verified
            </li>
            <li class="flex items-center gap-3 text-sm text-text-muted">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tanpa statistik
            </li>
        </ul>
    </div>

    <div class="card p-6 border-2 border-orange-500 relative">
        <div class="absolute -top-3 right-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full">
            REKOMENDASI
        </div>
        <h3 class="font-bold text-text mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            KosCheck+ 
        </h3>
        <ul class="space-y-3">
            <li class="flex items-center gap-3 text-sm text-text">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">Badge Verified pada properti</span>
            </li>
            <li class="flex items-center gap-3 text-sm text-text">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">Prioritas pencarian teratas</span>
            </li>
            <li class="flex items-center gap-3 text-sm text-text">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">Statistik pengunjung real-time</span>
            </li>
            <li class="flex items-center gap-3 text-sm text-text">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">Statistik favorit properti</span>
            </li>
            <li class="flex items-center gap-3 text-sm text-text">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">Statistik klik WhatsApp</span>
            </li>
        </ul>
    </div>
</div>
@endif
@endsection