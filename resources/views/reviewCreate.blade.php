@extends('layouts.mahasiswa')
@section('title', 'Tulis Review Kos — KosCheck')

@section('topbar_left')
    <h1 class="text-xl font-bold text-text">Tulis Review</h1>
@endsection

@section('content')
<section class="bg-bg py-8 md:py-10" data-reveal>
    <div class="container-custom">
        <div class="breadcrumb mb-6" data-reveal>
            <a href="{{ route('student.kos') }}">Cari Kos</a>
            <span>&rsaquo;</span>
            <a href="{{ route('student.kos.show', ['slug' => $kos->slug]) }}">{{ $kos->name }}</a>
            <span>&rsaquo;</span>
            <span class="text-text font-medium">Tulis Review</span>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[1.05fr,1.4fr] gap-6 items-start" x-data="reviewForm()">
            <aside class="space-y-6">
                <div class="card overflow-hidden" data-hover="lift">
                    @php
                        $resolveImage = function (?string $path): string {
                            $path = trim((string) $path);
                            if ($path === '') return asset('images/hero-illustration.png');
                            if (preg_match('/^(https?:|data:)/i', $path)) return $path;
                            if (str_starts_with($path, '/')) return $path;
                            return asset('storage/' . ltrim($path, '/'));
                        };
                        $primaryPhotoUrl = $kos->photos->first()?->url ?? null;
                    @endphp
                    <div class="aspect-[16/10] overflow-hidden">
                        <img src="{{ $resolveImage($primaryPhotoUrl) }}" alt="{{ $kos->name }}" class="h-full w-full object-cover" loading="lazy">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="badge badge-verified">Kos Terverifikasi</span>
                            <span class="badge badge-type">{{ ucfirst($kos->gender ?? 'campur') }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-text">{{ $kos->name }}</h2>
                        <p class="mt-2 text-sm text-text-muted leading-relaxed">Tuliskan pengalaman tinggal yang jujur, spesifik, dan membantu mahasiswa lain membuat keputusan.</p>

                        <div class="mt-5 space-y-3 text-sm text-text-muted">
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span>{{ $kos->address ?? 'Lokasi kos tidak tersedia' }}</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Review diverifikasi dari akun mahasiswa yang pernah berinteraksi dengan listing.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 text-primary mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>1 akun hanya dapat memberi 1 review per kos.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tip-box">
                    <span class="tip-box-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <div>
                        <h3 class="font-bold text-sm text-text">Panduan review yang bagus</h3>
                        <p class="mt-1 text-xs leading-relaxed text-text-muted">Sebutkan hal yang paling relevan seperti kebersihan kamar, keamanan lingkungan, kualitas fasilitas, dan kecepatan respons pemilik.</p>
                    </div>
                </div>
            </aside>

            <div class="card card-elevated border-none p-6 md:p-8" data-hover="lift">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3 mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-text">Bagikan pengalaman Anda</h1>
                        <p class="mt-2 text-sm text-text-muted">Frontend-only form sesuai route PRD `/kos/{id}/review`.</p>
                    </div>
                    <div class="rounded-2xl bg-primary-light px-4 py-3 text-sm">
                        <span class="font-semibold text-primary">Status:</span>
                        <span class="text-text-muted">draft preview</span>
                    </div>
                </div>

                <form class="space-y-8" action="{{ route('student.kos.review.store', ['id' => $kos->id]) }}" method="POST" data-validate>
                    @csrf
                    <!-- Alpine.js bindings mapped to hidden inputs for form submission -->
                    <input type="hidden" name="rating" :value="Math.round((ratings.kebersihan + ratings.keamanan + ratings.fasilitas + ratings.respons) / 4)">
                    <input type="hidden" name="rating_cleanliness" :value="ratings.kebersihan">
                    <input type="hidden" name="rating_security" :value="ratings.keamanan">
                    <input type="hidden" name="rating_facilities" :value="ratings.fasilitas">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Nama Peninjau</label>
                            <input type="text" class="input-field bg-gray-50 focus:bg-white" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Status Hunian</label>
                            <select class="input-field bg-gray-50 focus:bg-white">
                                <option>Masih Tinggal</option>
                                <option>Sudah Pindah</option>
                                <option>Pernah Survey</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ([
                            'kebersihan' => 'Kebersihan',
                            'keamanan' => 'Keamanan',
                            'fasilitas' => 'Fasilitas',
                            'respons' => 'Respons Pemilik',
                        ] as $key => $label)
                            <div class="rounded-2xl border border-border-light p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-bold text-text">{{ $label }}</h3>
                                        <p class="mt-1 text-xs text-text-muted">Berikan penilaian 1 sampai 5 bintang.</p>
                                    </div>
                                    <span class="text-sm font-bold text-primary" x-text="ratings.{{ $key }}"></span>
                                </div>
                                <div class="mt-4 flex items-center gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button
                                            type="button"
                                            @click="ratings.{{ $key }} = {{ $i }}"
                                            class="transition-transform hover:-translate-y-0.5"
                                            aria-label="Beri nilai {{ $i }} bintang untuk {{ $label }}"
                                        >
                                            <svg
                                                class="h-7 w-7"
                                                :class="ratings.{{ $key }} >= {{ $i }} ? 'star' : 'star-empty'"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Judul Review</label>
                        <input type="text" class="input-field bg-gray-50 focus:bg-white" placeholder="Contoh: Bersih, aman, dan cocok untuk mahasiswa UI">
                    </div>

                    <div>
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <label class="block text-sm font-semibold text-text">Cerita Pengalaman</label>
                            <span class="text-xs text-text-muted" x-text="reviewLength + ' / 300 karakter'"></span>
                        </div>
                        <textarea name="comment" x-model="reviewText" rows="6" maxlength="1000" class="input-field bg-gray-50 focus:bg-white" placeholder="Ceritakan pengalaman Anda dengan jujur. Minimal 30 karakter agar ulasan lebih berguna." required></textarea>
                        <p class="mt-2 text-xs" :class="reviewLength < 30 ? 'text-red-500' : 'text-green-600'">
                            <span x-show="reviewLength < 30">Tambahkan detail lagi agar ulasan memenuhi batas minimum.</span>
                            <span x-show="reviewLength >= 30" x-cloak>Ulasan sudah cukup panjang untuk dipublikasikan.</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Kelebihan Utama</label>
                            <input type="text" class="input-field bg-gray-50 focus:bg-white" placeholder="Contoh: WiFi stabil, kamar bersih, dekat kampus">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Hal yang Perlu Ditingkatkan</label>
                            <input type="text" class="input-field bg-gray-50 focus:bg-white" placeholder="Contoh: area parkir masih terbatas">
                        </div>
                    </div>

                    <div class="rounded-2xl bg-bg p-5 border border-border-light">
                        <label class="flex items-start gap-3">
                            <input type="checkbox" class="mt-1 h-4 w-4 rounded border-border text-primary accent-primary">
                            <span class="text-sm leading-relaxed text-text-muted">Saya menyatakan review ini berdasarkan pengalaman nyata dan siap mengikuti moderasi KosCheck jika diperlukan.</span>
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                        <a href="{{ route('student.kos.show', ['slug' => $kos->slug]) }}" class="btn btn-white">Kembali ke Detail</a>
                        <button type="submit" class="btn btn-primary" data-hover="lift">Kirim Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function reviewForm() {
        return {
            ratings: {
                kebersihan: 5,
                keamanan: 5,
                fasilitas: 4,
                respons: 5,
            },
            reviewText: '',
            get reviewLength() {
                return this.reviewText.length;
            },
        };
    }
</script>
@endpush
