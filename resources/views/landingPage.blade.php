@extends('layouts.landing')

@section('content')
{{-- ═══════ HERO SECTION ═══════ --}}
<section class="bg-white py-12 md:py-20" data-reveal>
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center scroll-animate-container">
            <div class="animate-fade-in-up">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight text-text" data-reveal>
                    Temukan Kos Nyaman<br>Dekat Kampus dengan<br>
                    <span class="text-green-brand">Aman</span>
                </h1>
                <p class="mt-4 text-text-muted text-base md:text-lg leading-relaxed max-w-md" data-reveal>
                    Cari kos terdekat, lihat review mahasiswa, dan hubungi pemilik langsung melalui WhatsApp.
                </p>
                <form action="{{ route('kos.index') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-3">
                    <div class="input-with-icon flex-1">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="search" placeholder="Cari lokasi atau nama kos..." class="input-field" id="hero-search">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" id="hero-cari-btn" data-hover="lift" style="background-color: #EA580C; border-color: #EA580C;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari Kos
                    </button>
                </form>
            </div>
            <div class="hidden md:flex justify-center">
                <img src="{{ asset('images/hero-illustration.png') }}" alt="Ilustrasi pencarian kos" class="max-w-sm lg:max-w-md w-full rounded-2xl" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- ═══════ MENGAPA KOSCHECK ═══════ --}}
<section class="section bg-bg" data-reveal>
    <div class="container-custom text-center">
        <h2 class="section-title" data-reveal>Mengapa KosCheck?</h2>
        <p class="section-subtitle" data-reveal>Platform terpercaya untuk pencarian kos mahasiswa</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8 scroll-animate-container">
            @php
            $features = [
                ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'title' => 'Kos Terverifikasi', 'desc' => 'Setiap kos telah melalui proses verifikasi untuk keamanan dan kenyamanan penghuni.'],
                ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>', 'title' => 'Pemilik Terpercaya', 'desc' => 'Pemilik kos yang terdaftar dan terverifikasi di platform kami.'],
                ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>', 'title' => 'WhatsApp Direct', 'desc' => 'Hubungi pemilik kos langsung melalui WhatsApp tanpa ribet.'],
                ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>', 'title' => 'Review Asli', 'desc' => 'Review dari mahasiswa yang benar-benar pernah tinggal di kos tersebut.'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="card card-elevated p-6 text-center hover:scale-[1.02] transition-transform" data-hover="lift" data-reveal>
                <div class="w-14 h-14 rounded-2xl bg-primary-light flex items-center justify-center mx-auto text-primary mb-4">
                    {!! $f['icon'] !!}
                </div>
                <h3 class="font-semibold text-sm text-text mb-2">{{ $f['title'] }}</h3>
                <p class="text-xs text-text-muted leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ REKOMENDASI KOS TERPOPULER ═══════ --}}
<section class="section bg-white" data-reveal>
    <div class="container-custom">
        <div class="flex items-center justify-between mb-2" data-reveal>
            <div>
                <h2 class="section-title">Rekomendasi Kos Terpopuler</h2>
                <p class="section-subtitle mb-0">Pilihan terbaik untuk masa depan studimu.</p>
            </div>
            <a href="{{ route('kos.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors">
                Lihat Semua 
                <span class="text-xs">→</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6 scroll-animate-container">
            @forelse($featuredKos as $kos)
            <div class="card group">
                <div class="relative overflow-hidden aspect-[4/3]">
                    @php
                        $coverPhoto = $kos->cover_photo;
                        $imageSrc = resolve_image_url($coverPhoto?->url);
                    @endphp
                    <img src="{{ $imageSrc }}" alt="{{ $kos->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    @if($kos->is_active && $kos->status === 'active')
                    <span class="absolute top-3 right-3 badge badge-verified text-[0.65rem]">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        TERVERIFIKASI
                    </span>
                    @endif
                    @if($kos->isPremium())
                    <span class="absolute top-3 {{ $kos->is_active && $kos->status === 'active' ? 'left-24' : 'left-3' }}">
                        <span class="badge badge-premium text-[0.65rem]">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            PREMIUM
                        </span>
                    </span>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between mb-1">
                        <div>
                            <p class="text-xs text-text-muted">Mulai dari</p>
                            <p class="font-bold text-primary text-lg">Rp {{ number_format($kos->price, 0, ',', '.') }}<span class="text-xs font-normal text-text-muted">/bln</span></p>
                        </div>
                        @if($kos->average_rating)
                        <div class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-xs font-semibold">{{ number_format($kos->average_rating, 1) }}</span>
                        </div>
                        @endif
                    </div>
                    <h3 class="font-semibold text-sm mt-1">{{ $kos->name }}</h3>
                    <div class="flex items-center gap-1 mt-1 text-text-muted">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-xs">{{ $kos->address }}</span>
                    </div>
                    <div class="flex items-center gap-2 mt-2 flex-wrap">
                        @foreach($kos->facilities->take(3) as $facility)
                        <span class="text-[0.65rem] text-text-muted bg-bg px-2 py-0.5 rounded-full">{{ $facility->name }}</span>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2 mt-2 mb-2">
                        @if($kos->available_rooms > 0)
                        <span class="text-xs font-semibold text-green-600">{{ $kos->available_rooms }} Kamar Tersisa</span>
                        @else
                        <span class="text-xs font-semibold text-red-500">Kamar Penuh</span>
                        @endif
                    </div>
                    <div class="flex gap-2 mt-1">
                        <a href="{{ route('kos.show', ['slug' => $kos->slug]) }}" class="flex-1 text-center py-1.5 px-2 text-xs font-semibold text-green-700 border border-green-700 rounded-lg hover:bg-green-50 transition" data-hover="lift">Detail</a>
                        @if($kos->available_rooms > 0 && $kos->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kos->whatsapp) }}?text=Halo%20saya%20tertarik%20dengan%20{{ urlencode($kos->name) }}" target="_blank" class="flex-1 text-center py-1.5 px-2 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition flex items-center justify-center gap-1" data-hover="lift">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            WhatsApp
                        </a>
                        @else
                        <span class="flex-1 text-center py-1.5 px-2 text-xs font-semibold bg-red-100 text-red-600 rounded-lg" style="cursor:not-allowed;">Booking</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-text-muted">
                <p>Belum ada kos yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-6 sm:hidden">
            <a href="{{ route('kos.index') }}" class="text-sm font-semibold text-primary">Lihat Semua →</a>
        </div>
    </div>
</section>

{{-- ═══════ TIPS AMAN CARI KOS ═══════ --}}
<section class="section bg-bg" data-reveal>
    <div class="container-custom">
        <div class="card card-elevated p-8 md:p-10" data-hover="lift">
            <h2 class="section-title text-center mb-8" data-reveal>Tips Aman Cari Kos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 scroll-animate-container">
                @php
                $tips = [
                    ['icon' => '🚫', 'title' => 'Jangan Transfer Sebelum Survey', 'desc' => 'Pastikan kamu sudah melihat kondisi kos secara langsung sebelum transfer.'],
                    ['icon' => '📍', 'title' => 'Pastikan Alamat Sesuai Maps', 'desc' => 'Cek lokasi di Google Maps dan pastikan kos mudah diakses dari kampusmu.'],
                    ['icon' => '💬', 'title' => 'Gunakan WhatsApp Resmi', 'desc' => 'Gunakan nomor yang terdata di sistem KosCheck untuk komunikasi.'],
                    ['icon' => '✅', 'title' => 'Pilih Kos Terverifikasi', 'desc' => 'Utamakan kos yang sudah memiliki tanda terverifikasi di platform.'],
                ];
                @endphp
                @foreach($tips as $tip)
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary-light flex items-center justify-center flex-shrink-0 text-lg">{{ $tip['icon'] }}</div>
                    <div>
                        <h3 class="font-semibold text-sm text-text mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-xs text-text-muted leading-relaxed">{{ $tip['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection