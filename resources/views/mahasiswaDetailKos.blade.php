@extends('layouts.mahasiswa')
@section('title', ($kos->name ?? 'Detail Kos') . ' — KosCheck')

@section('content')
@php
    $fallbackImage = asset('images/hero-illustration.png');
    $photos = $kos->photos->take(4)->values();
    $coverPhoto = $kos->cover_photo;
    $area = trim(\Illuminate\Support\Str::before((string) ($kos->address ?? ''), ','));
    $genderLabel = match ($kos->gender) {
        'putra' => 'Putra',
        'putri' => 'Putri',
        default => 'Campur',
    };
    $rating = $kos->average_rating ? number_format($kos->average_rating, 1) : '0.0';
    $reviewCount = (int) ($kos->review_count ?? 0);
    $price = number_format((int) ($kos->price ?? 0), 0, ',', '.');
    $stock = (int) ($kos->available_rooms ?? 0);
    $owner = $kos->owner;
    $ownerName = $owner?->name ?? 'Pemilik Kos';
    $whatsappRaw = preg_replace('/\D+/', '', (string) ($kos->whatsapp ?: $kos->phone ?: ''));

    if ($whatsappRaw !== '' && str_starts_with($whatsappRaw, '0')) {
        $whatsappRaw = '62' . substr($whatsappRaw, 1);
    }

    $whatsappUrl = $whatsappRaw !== ''
        ? 'https://wa.me/' . $whatsappRaw . '?text=' . urlencode('Halo, saya tertarik dengan kos ' . $kos->name)
        : null;
@endphp

<section class="bg-bg py-6">
    <div class="container-custom">
        <div class="breadcrumb mb-6">
            <a href="{{ route('student.kos') }}">Cari Kos</a>
            <span>&rsaquo;</span>
            <a href="{{ route('student.kos') }}?area={{ urlencode($area) }}">{{ $area ?: 'Kos' }}</a>
            <span>&rsaquo;</span>
            <span class="text-text font-medium">{{ $kos->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="gallery-grid mb-8">
                    <div class="gallery-main img-overlay rounded-2xl h-[250px] md:h-[400px]">
                        <img src="{{ resolve_image_url($photos[0]?->url, $fallbackImage) }}" alt="{{ $kos->name }}" loading="lazy">
                        <span class="img-label rounded-b-2xl">Tampak Depan</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 md:contents">
                        <div class="img-overlay rounded-2xl h-[120px] md:h-[196px]">
                            <img src="{{ resolve_image_url($photos[1]?->url, $fallbackImage) }}" alt="{{ $kos->name }}" loading="lazy">
                            <span class="img-label rounded-b-2xl text-[0.65rem] md:text-xs">Kamar</span>
                        </div>
                        <div class="img-overlay rounded-2xl h-[120px] md:h-[196px]">
                            <img src="{{ resolve_image_url($photos[2]?->url, $fallbackImage) }}" alt="{{ $kos->name }}" loading="lazy">
                            <span class="img-label rounded-b-2xl text-[0.65rem] md:text-xs">Area Lain</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 mb-3 flex-wrap">
                    @if($kos->status === 'active' && $kos->is_active)
                        <span class="badge badge-verified">Kos Terverifikasi</span>
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

                <div class="card bg-gray-50 p-5 mb-8 border-none shadow-sm flex flex-wrap gap-y-4 justify-between">
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Ketersediaan</p>
                        <p class="font-bold {{ $stock > 0 ? 'text-green-600' : 'text-red-500' }} text-sm">
                            {{ $stock > 0 ? $stock . ' Kamar Tersisa' : 'Kamar Penuh' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Harga per Bulan</p>
                        <p class="font-bold text-text text-sm">Rp {{ $price }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-text-muted mb-1 font-medium uppercase tracking-wide">Pemilik</p>
                        <p class="font-bold text-text text-sm">{{ $ownerName }}</p>
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
                            <p class="text-sm text-text-muted">Fasilitas belum diisi.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4">Deskripsi</h2>
                    <p class="text-sm leading-relaxed text-text-muted">
                        {{ $kos->description ?: 'Deskripsi kos belum diisi oleh pemilik.' }}
                    </p>
                </div>

                <div class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold">Review Mahasiswa</h2>
                        <a href="{{ route('student.kos.review.create', ['id' => $kos->id]) }}" class="text-sm font-semibold text-primary">Tulis Review</a>
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
                                            <p class="text-[0.65rem] text-text-muted">{{ $review->user?->university ?: 'Mahasiswa' }} • {{ $review->created_at?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-text-muted leading-relaxed">{{ $review->comment ?: 'Review tanpa komentar.' }}</p>
                            </div>
                        @empty
                            <div class="review-card text-sm text-text-muted">Belum ada review untuk kos ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="card card-elevated p-4 md:p-6 mb-4 bg-white rounded-2xl">
                        <div class="text-[0.65rem] text-text-muted line-through mb-0.5">Rp {{ $price }}</div>
                        <div class="price-tag mb-6">Rp {{ $price }} <span class="price-period">/ bulan</span></div>

                        @if($stock > 0)
                            <a href="{{ route('booking', ['slug' => $kos->slug]) }}" class="btn btn-primary btn-full md:mb-3" data-hover="lift">Booking Sekarang</a>
                        @else
                            <button disabled class="btn btn-full md:mb-3 bg-red-100 text-red-600" style="cursor:not-allowed;">Penuh</button>
                        @endif

                        @if($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-white btn-full text-green-brand border-green-brand hover:bg-green-50 items-center justify-center gap-2" data-hover="lift">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                        @endif
                    </div>

                    <div class="card p-6 text-center">
                        <div class="relative inline-block mb-3">
                            <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden mx-auto">
                                <img src="{{ $owner?->avatar ? resolve_image_url($owner->avatar, $fallbackImage) : 'https://ui-avatars.com/api/?name=' . urlencode($ownerName) . '&background=F47C20&color=fff&size=128' }}" alt="{{ $ownerName }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <h3 class="font-bold text-sm mb-1">{{ $ownerName }}</h3>
                        <p class="text-xs text-text-muted">Bergabung sejak {{ $owner?->created_at?->translatedFormat('F Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
