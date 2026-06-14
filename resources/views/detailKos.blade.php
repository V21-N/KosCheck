@extends(request()->routeIs('dashboard.kos.show') ? 'layouts.owner' : 'layouts.app')
@section('title', ($kos->name ?? 'Detail Kos') . ' — KosCheck')

@section('content')
@php
    $fallbackImage = asset('images/hero-illustration.png');
    $galleryPhotos = $kos->photos->take(4)->values();
    $gallerySlots = ['Tampak Depan', 'Kamar Tidur', 'Dapur', 'Area Tambahan'];
    $coverPhoto = $kos->cover_photo;
    $breadcrumbArea = trim(\Illuminate\Support\Str::before((string) ($kos->address ?? ''), ','));
    $genderLabel = match ($kos->gender) {
        'putra' => 'Putra',
        'putri' => 'Putri',
        default => 'Campur',
    };
    $isVerified = $kos->status === 'active' && (bool) $kos->is_active;
    $rating = $kos->average_rating ? number_format($kos->average_rating, 1) : '0.0';
    $reviewCount = (int) ($kos->review_count ?? 0);
    $stock = (int) ($kos->available_rooms ?? 0);
    $price = number_format((int) ($kos->price ?? 0), 0, ',', '.');
    $shortAddress = \Illuminate\Support\Str::limit($kos->address ?: 'Alamat belum tersedia', 48);
    $owner = $kos->owner;
    $ownerName = $owner?->name ?? 'Pemilik Kos';
    $ownerAvatar = $owner?->avatar
        ? resolve_image_url($owner->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($ownerName) . '&background=F47C20&color=fff&size=128';
    $whatsappRaw = preg_replace('/\D+/', '', (string) ($kos->whatsapp ?: $kos->phone ?: ''));

    if ($whatsappRaw !== '' && str_starts_with($whatsappRaw, '0')) {
        $whatsappRaw = '62' . substr($whatsappRaw, 1);
    }

    $whatsappUrl = $whatsappRaw !== ''
        ? 'https://wa.me/' . $whatsappRaw . '?text=' . urlencode('Halo, saya tertarik dengan kos ' . $kos->name)
        : null;
    $nearbyList = $nearbyKos ?? collect();
    $reportKosData = [
        'id' => $kos->id,
        'type' => 'kos',
        'name' => $kos->name,
        'location' => $kos->address,
        'image' => resolve_image_url($coverPhoto?->url, $fallbackImage),
    ];
@endphp

<section class="bg-bg py-6" data-reveal x-data="detailKosPage()">
    <x-report-modal />

    <div class="container-custom">
        <div class="breadcrumb mb-6">
            <a href="{{ route('kos.index') }}">Cari Kos</a>
            <span>&rsaquo;</span>
            <a href="{{ route('kos.index') }}?area={{ urlencode($breadcrumbArea) }}">
                {{ $breadcrumbArea ?: 'Kos' }}
            </a>
            <span>&rsaquo;</span>
            <span class="text-text font-medium">{{ $kos->name }}</span>

            <div class="ml-auto flex items-center gap-3">
                <button class="text-text-muted hover:text-primary transition-colors" type="button" aria-label="Bagikan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </button>
                <button class="text-text-muted hover:text-red-500 transition-colors" type="button" aria-label="Favorit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
                <button @click="openReportModal()" class="text-text-muted hover:text-red-600 transition-colors flex items-center gap-1 text-xs" title="Laporkan masalah" type="button">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="gallery-grid mb-8">
            <div class="gallery-main img-overlay rounded-2xl h-[250px] md:h-[400px]">
                <img src="{{ resolve_image_url($galleryPhotos[0]?->url, $fallbackImage) }}" alt="{{ $gallerySlots[0] }}" loading="lazy">
                <span class="img-label rounded-b-2xl">{{ $gallerySlots[0] }}</span>
            </div>
            <div class="grid grid-cols-2 gap-2 md:contents">
                <div class="img-overlay rounded-2xl h-[120px] md:h-[196px]">
                    <img src="{{ resolve_image_url($galleryPhotos[1]?->url, $fallbackImage) }}" alt="{{ $gallerySlots[1] }}" loading="lazy">
                    <span class="img-label rounded-b-2xl text-[0.65rem] md:text-xs">{{ $gallerySlots[1] }}</span>
                </div>
                <div class="img-overlay rounded-2xl h-[120px] md:h-[196px]">
                    <img src="{{ resolve_image_url($galleryPhotos[2]?->url, $fallbackImage) }}" alt="{{ $gallerySlots[2] }}" loading="lazy">
                    <span class="img-label rounded-b-2xl text-[0.65rem] md:text-xs">{{ $gallerySlots[2] }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2 mb-3 flex-wrap">
                    @if($isVerified)
                        <span class="badge badge-verified">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Kos Terverifikasi
                        </span>
                    @else
                        <span class="badge badge-type">Menunggu Verifikasi</span>
                    @endif
                    @if($kos->isPremium())
                        <span class="badge badge-premium">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Premium
                        </span>
                    @endif
                    <span class="badge badge-type">{{ $genderLabel }}</span>
                </div>

                <h1 class="text-3xl font-extrabold text-text mb-2">{{ $kos->name }}</h1>
                <div class="flex items-center gap-4 text-sm mb-6 flex-wrap">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 star" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="font-bold">{{ $rating }}</span>
                        <span class="text-text-muted">({{ $reviewCount }} Ulasan)</span>
                    </div>
                    <div class="flex items-center gap-1 text-text-muted">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $kos->address ?: 'Alamat belum tersedia' }}
                    </div>
                </div>

                <div class="card bg-gray-50 p-5 mb-8 border-none shadow-sm flex flex-wrap gap-y-4 justify-between" data-hover="lift">
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Ketersediaan</p>
                        @if($stock > 0)
                            <p class="font-bold text-green-600 text-sm">{{ $stock }} Kamar Tersisa</p>
                        @else
                            <p class="font-bold text-red-500 text-sm">Kamar Penuh</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Harga per Bulan</p>
                        <p class="font-bold text-text text-sm">Rp {{ $price }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Lokasi</p>
                        <p class="font-bold text-text text-sm">{{ $shortAddress }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Status</p>
                        <p class="font-bold text-text text-sm">{{ $isVerified ? 'Aktif' : 'Menunggu Verifikasi' }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">Fasilitas Kos</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-2">
                        @forelse($kos->facilities as $facility)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-light flex items-center justify-center flex-shrink-0 text-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-text-muted">{{ $facility->name }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-text-muted">Fasilitas belum diisi oleh pemilik kos.</p>
                        @endforelse
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h2 class="text-lg font-bold mb-4">Deskripsi Kos</h2>
                        <p class="text-sm leading-relaxed text-text-muted">
                            {{ $kos->description ?: 'Deskripsi kos belum diisi oleh pemilik.' }}
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold mb-4">Informasi Tambahan</h2>
                        <ul class="space-y-2">
                            <li class="flex items-start gap-2 text-sm text-text-muted">
                                <svg class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pemilik: {{ $ownerName }}
                            </li>
                            <li class="flex items-start gap-2 text-sm text-text-muted">
                                <svg class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Koordinat: {{ $kos->latitude !== null && $kos->longitude !== null ? $kos->latitude . ', ' . $kos->longitude : 'Belum tersedia' }}
                            </li>
                            <li class="flex items-start gap-2 text-sm text-text-muted">
                                <svg class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                WhatsApp: {{ $kos->whatsapp ?: ($kos->phone ?: 'Belum tersedia') }}
                            </li>
                            <li class="flex items-start gap-2 text-sm text-text-muted">
                                <svg class="w-5 h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status publikasi: {{ $kos->status }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold">Review Mahasiswa</h2>
                        <div class="flex items-center gap-3">
                            @if(auth()->check() && auth()->user()->role === 'mahasiswa')
                                <a href="{{ route('student.kos.review.create', $kos->id) }}" class="text-sm font-semibold text-primary">Tulis Review</a>
                            @endif
                            <a href="#" class="text-sm font-semibold text-primary">Lihat Semua</a>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($kos->reviews as $review)
                            <div class="review-card">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($review->user?->name ?? 'An', 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm">{{ $review->user?->name ?? 'Anonim' }}</h4>
                                            <p class="text-[0.65rem] text-text-muted">
                                                {{ $review->user?->university ?: 'Mahasiswa' }} • {{ $review->created_at?->format('d M Y') ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 star {{ $i <= (int) $review->rating ? '' : 'opacity-20' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-text-muted leading-relaxed">
                                    {{ $review->comment ?: 'Review tanpa komentar.' }}
                                </p>
                            </div>
                        @empty
                            <div class="review-card text-sm text-text-muted">
                                Belum ada review untuk kos ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                @if($nearbyList->isNotEmpty())
                    <div class="mb-8">
                        <h2 class="text-lg font-bold mb-4">Rekomendasi Kos Terdekat</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($nearbyList as $nearby)
                                <a href="{{ route('kos.show', ['slug' => $nearby->slug]) }}" class="card p-4 flex gap-4 items-center" data-hover="lift">
                                    <img src="{{ resolve_image_url($nearby->photos->first()?->url, $fallbackImage) }}" alt="{{ $nearby->name }}" class="w-24 h-24 rounded-xl object-cover flex-shrink-0" loading="lazy">
                                    <div class="min-w-0">
                                        <p class="font-bold text-text truncate">{{ $nearby->name }}</p>
                                        <p class="text-sm text-text-muted truncate">{{ $nearby->address }}</p>
                                        <p class="font-semibold text-primary">Rp {{ number_format((int) ($nearby->price ?? 0), 0, ',', '.') }} / bulan</p>
                                        <p class="text-xs text-text-muted mt-1">{{ ucfirst($nearby->gender ?? 'campur') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                <div>
                    <div class="card card-elevated p-4 md:p-6 mb-0 md:mb-4 fixed md:relative bottom-[env(safe-area-inset-bottom)] md:bottom-auto left-0 right-0 z-[60] md:z-auto rounded-t-2xl md:rounded-2xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)] md:shadow-none border-t border-border-light md:border-none flex md:block items-center justify-between gap-4 md:gap-0 bg-white">
                        <div class="md:hidden">
                            <div class="text-[0.65rem] text-text-muted line-through mb-0.5">Rp {{ $price }}</div>
                            <div class="text-lg font-bold text-primary leading-none">Rp {{ $price }}<span class="text-[0.65rem] font-normal text-text-muted">/bln</span></div>
                        </div>
                        <div class="hidden md:block">
                            <div class="flex items-center gap-2 mb-2 text-text-muted line-through text-xs">Rp {{ $price }}</div>
                            <div class="price-tag mb-6">Rp {{ $price }} <span class="price-period">/ bulan</span></div>
                        </div>

                        <div class="flex-1 md:flex-none">
                            @if(auth()->check() && auth()->user()->role === 'owner' && auth()->id() === $kos->user_id)
                                <a href="{{ route('dashboard.booking', ['search' => $kos->name]) }}" class="btn btn-primary btn-full md:mb-3" data-hover="lift">
                                    Kelola Booking
                                </a>
                            @else
                                @if($stock > 0)
                                    <a href="{{ route('booking', ['slug' => $kos->slug]) }}" class="btn btn-primary btn-full md:mb-3" data-hover="lift">
                                        Booking <span class="hidden md:inline">Sekarang</span>
                                    </a>
                                @else
                                    <button disabled class="btn btn-full md:mb-3 bg-red-100 text-red-600" style="cursor:not-allowed;">Penuh</button>
                                @endif
                            @endif

                            @if($whatsappUrl && !(auth()->check() && auth()->id() === $kos->user_id))
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="hidden md:flex btn btn-white btn-full text-green-brand border-green-brand hover:bg-green-50 items-center justify-center gap-2" data-hover="lift">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.717-1.394A11.955 11.955 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.287 0-4.408-.703-6.164-1.902l-.436-.3-2.825.835.87-2.727-.327-.47A9.955 9.955 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                                    </svg>
                                    Hubungi via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    @if(auth()->check() && auth()->user()->role === 'mahasiswa')
                    <a href="{{ route('student.kos.review.create', $kos->id) }}" class="hidden md:flex btn btn-primary-outline btn-full mb-4" data-hover="lift">
                        Bagikan Pengalaman
                    </a>
                    @endif

                    <div class="mt-4 flex items-center justify-center gap-1 text-xs text-text-muted">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Terakhir diupdate {{ $kos->updated_at?->diffForHumans() ?? 'baru saja' }}
                    </div>

                <div class="card p-6 text-center mt-6">
                    <div class="relative inline-block mb-3">
                        <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden mx-auto">
                            <img src="{{ $ownerAvatar }}" alt="{{ $ownerName }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <h3 class="font-bold text-sm mb-1">{{ $ownerName }}</h3>
                    <div class="flex items-center justify-center gap-1 text-xs text-green-brand mb-4">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Pemilik Terdaftar
                    </div>
                    <div class="flex items-center justify-around bg-gray-50 rounded-lg p-3 text-xs mb-4">
                        <div>
                            <p class="text-text-muted mb-0.5">RESPON</p>
                            <p class="font-bold">{{ $whatsappRaw !== '' ? 'Tersedia' : '-' }}</p>
                        </div>
                        <div class="w-px h-6 bg-border"></div>
                        <div>
                            <p class="text-text-muted mb-0.5">ONLINE</p>
                            <p class="font-bold">{{ $owner?->created_at?->diffForHumans() ?? '-' }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-text-muted">Bergabung sejak {{ $owner?->created_at?->translatedFormat('F Y') ?? '-' }}</p>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function detailKosPage() {
    return {
        openReportModal() {
            const kosData = @json($reportKosData);

            const userRole = '{{ session("user_role") }}';
            if (!userRole) {
                if (confirm('Anda harus login untuk melaporkan masalah. Login sekarang?')) {
                    window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
                }
                return;
            }

            this.$dispatch('open-report-modal', kosData);
        }
    };
}

document.addEventListener('alpine:init', () => {
    Alpine.data('reportModal', () => ({
        isOpen: false,
        reportType: '',
        description: '',
        files: [],
        contactPhone: '',
        agreeTerms: false,
        isDragging: false,
        isSubmitting: false,
        submitted: false,
        targetId: null,
        targetType: null,
        targetName: '',
        targetLocation: '',
        targetImage: '',

        openModal(options = {}) {
            this.isOpen = true;
            this.resetForm();
            this.targetId = options.id || null;
            this.targetType = options.type || 'kos';
            this.targetName = options.name || 'Tidak dikenal';
            this.targetLocation = options.location || '';
            this.targetImage = options.image || '';
            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
        },

        resetForm() {
            this.reportType = '';
            this.description = '';
            this.files = [];
            this.contactPhone = '';
            this.agreeTerms = false;
            this.submitted = false;
            this.isSubmitting = false;
        },

        get canSubmit() {
            return this.reportType && this.description.length >= 20 && this.agreeTerms;
        },

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.addFiles(files);
        },

        handleFileDrop(event) {
            this.isDragging = false;
            const files = Array.from(event.dataTransfer.files);
            this.addFiles(files);
        },

        addFiles(files) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
            const maxSize = 5 * 1024 * 1024;
            const maxFiles = 3;

            if (this.files.length >= maxFiles) {
                alert('Maksimal 3 file dapat diupload.');
                return;
            }

            files.forEach(file => {
                if (this.files.length >= maxFiles) return;
                if (!validTypes.includes(file.type)) {
                    alert('Hanya file gambar (JPG, PNG, GIF, WEBP) dan PDF yang diizinkan.');
                    return;
                }
                if (file.size > maxSize) {
                    alert('Ukuran file maksimal 5MB.');
                    return;
                }

                const fileObj = { file: file, name: file.name, size: file.size, preview: null };
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        fileObj.preview = e.target.result;
                        this.files.push(fileObj);
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.files.push(fileObj);
                }
            });
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        async submitReport() {
            if (!this.canSubmit) return;
            this.isSubmitting = true;

            try {
                await new Promise(resolve => setTimeout(resolve, 1500));
                this.submitted = true;
            } catch (error) {
                console.error('Error submitting report:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }));
});
</script>
@endpush
