@extends('layouts.app')
@section('title', 'Cari Kos - KosCheck')
@section('meta_description', 'Temukan kos terpercaya dan hubungi pemilik langsung melalui WhatsApp.')

{{-- Public page: show public navbar (guest). Booking requires login --}}

@section('content')
<div x-data="cariKosPage()" x-init="init()">
    @include('components.mobile-review')

    <section class="bg-white py-8 md:py-10" data-reveal>
        <div class="container-custom">
            <h1 class="text-2xl md:text-3xl font-extrabold text-text" data-reveal>Cari Kos Sesuai Kebutuhanmu</h1>
            <p class="text-text-muted text-sm mt-1" data-reveal>Temukan kos terpercaya dan hubungi pemilik langsung melalui WhatsApp.</p>

            <div class="mt-6 card card-elevated p-4 md:p-5" data-hover="lift">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="text-xs font-medium text-text mb-1.5 block">Nama Kos</label>
                        <div class="input-with-icon">
                            <span class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></span>
                            <input type="text" placeholder="Cari nama kos..." class="input-field" x-model="searchNama">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-text mb-1.5 block">Lokasi</label>
                        <div class="input-with-icon">
                            <span class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></span>
                            <input type="text" placeholder="Kota atau area..." class="input-field" x-model="searchLokasi">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-text mb-1.5 block">Dekat Kampus</label>
                        <div class="input-with-icon">
                            <span class="input-icon"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></span>
                            <input type="text" placeholder="Nama kampus..." class="input-field" x-model="searchKampus">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="btn btn-primary btn-full" @click="filterKos()" data-hover="lift">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-bg pb-12">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <aside class="lg:col-span-1 sticky top-24 self-start">
                    <button type="button" @click="showFilter = !showFilter" class="lg:hidden btn btn-white btn-full mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter
                    </button>

                    <div :class="showFilter ? 'block' : 'hidden lg:block'">
                        <div class="card card-elevated p-5">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="font-bold text-base">Filter</h3>
                                <button type="button" class="text-xs text-primary font-semibold hover:text-primary-dark" @click="resetFilters()">Reset</button>
                            </div>

                            <div class="mb-6">
                                <label class="text-sm font-semibold text-text mb-3 block">Rentang Harga (Bulanan)</label>
                                <input type="range" min="500000" max="5000000" step="100000" x-model.number="maxPrice" class="w-full">
                                <div class="flex justify-between mt-2 text-xs text-text-muted">
                                    <span>Rp 500rb</span>
                                    <span class="font-semibold text-primary" x-text="'Rp ' + formatPrice(maxPrice)"></span>
                                    <span>Rp 5jt+</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-sm font-semibold text-text mb-3 block">Tipe Kos</label>
                                <div class="flex gap-2 flex-wrap">
                                    <button type="button" @click="selectedType = selectedType === 'Putra' ? '' : 'Putra'; filterKos()" :class="selectedType === 'Putra' ? 'bg-primary text-white border-primary' : 'bg-white text-text-muted border-border hover:border-primary'" class="px-3 py-1.5 rounded-full text-xs font-medium border transition-colors">Putra</button>
                                    <button type="button" @click="selectedType = selectedType === 'Putri' ? '' : 'Putri'; filterKos()" :class="selectedType === 'Putri' ? 'bg-primary text-white border-primary' : 'bg-white text-text-muted border-border hover:border-primary'" class="px-3 py-1.5 rounded-full text-xs font-medium border transition-colors">Putri</button>
                                    <button type="button" @click="selectedType = selectedType === 'Campur' ? '' : 'Campur'; filterKos()" :class="selectedType === 'Campur' ? 'bg-primary text-white border-primary' : 'bg-white text-text-muted border-border hover:border-primary'" class="px-3 py-1.5 rounded-full text-xs font-medium border transition-colors">Campur</button>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-sm font-semibold text-text mb-3 block">Fasilitas</label>
                                <div class="space-y-2.5">
                                    @foreach(['WiFi', 'AC', 'Kamar mandi dalam', 'Parkir Mobil'] as $fas)
                                    <label class="flex items-center gap-2.5 cursor-pointer group">
                                        <input type="checkbox" class="w-4 h-4 rounded border-border text-primary accent-primary" x-model="selectedFacilities" value="{{ $fas }}" @change="filterKos()">
                                        <span class="text-sm text-text-muted group-hover:text-text transition-colors">{{ $fas }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="text-sm font-semibold text-text">Terverifikasi</label>
                                <label class="toggle-wrapper">
                                    <input type="checkbox" x-model="verifiedOnly">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="lg:col-span-3">
                    <div class="tip-box mb-6">
                        <span class="tip-box-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </span>
                        <p class="text-sm"><strong class="text-primary">Tips Keamanan:</strong> Pilih kos yang sudah terverifikasi dan jangan lakukan transfer pembayaran sebelum melakukan survei lokasi langsung.</p>
                    </div>

                    <div class="flex items-center justify-between gap-3 mb-4">
                        <p class="text-sm text-text-muted" x-text="filteredKos.length + ' kos ditemukan'"></p>
                        <button type="button" class="text-sm text-primary font-semibold hover:text-primary-dark" @click="resetFilters()" x-show="searchNama || searchLokasi || searchKampus || selectedType || selectedFacilities.length || verifiedOnly || maxPrice < 5000000" x-cloak>
                            Hapus semua filter
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 scroll-animate-container" x-show="filteredKos.length > 0">
                        <template x-for="kos in filteredKos" :key="kos.slug">
                            <div class="card group" data-hover="lift" data-reveal>
                                <div class="relative overflow-hidden aspect-[4/3]">
                                    <img :src="getImageSrc(kos)" :alt="kos.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                    <span x-show="kos.verified" class="absolute top-3 right-3 badge badge-verified text-[0.65rem]" x-cloak>
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        TERVERIFIKASI
                                    </span>
                                    <span x-show="kos.is_premium" class="absolute top-3 left-3" :class="kos.verified ? 'top-12' : ''">
                                        <span class="badge badge-premium text-[0.65rem]">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            PREMIUM
                                        </span>
                                    </span>
                                    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 flex items-center justify-center hover:bg-white transition-colors" aria-label="Simpan kos">
                                        <svg class="w-4 h-4 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="font-bold text-base" x-text="kos.name"></h3>
                                            <p class="text-xs text-text-muted mt-1" x-text="kos.campus"></p>
                                        </div>
                                        <div class="flex items-center gap-1 ml-2">
                                            <svg class="w-4 h-4 star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-sm font-semibold" x-text="kos.rating"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 mt-1 text-text-muted">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        <span class="text-xs" x-text="kos.loc"></span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-2 flex-wrap">
                                        <template x-for="facility in kos.fac" :key="facility">
                                            <span class="facility-item text-xs">
                                                <svg class="w-3 h-3 text-green-brand" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                <span x-text="facility"></span>
                                            </span>
                                        </template>
                                    </div>
                                    <div class="mt-3 flex items-end justify-between">
                                        <div>
                                            <p class="text-xs text-text-muted">Mulai dari</p>
                                            <p class="font-extrabold text-lg text-primary">
                                                Rp <span x-text="formatPrice(kos.price_number)"></span><span class="text-xs font-normal text-text-muted">/bln</span>
                                            </p>
                                        </div>
                                        <span x-show="kos.stock > 0" class="text-xs font-semibold text-green-600" x-text="kos.stock + ' Kamar Tersisa'"></span>
                                        <span x-show="kos.stock === 0" class="text-xs font-semibold text-red-500">Kamar Penuh</span>
                                    </div>
                                    <div class="flex gap-2 mt-3">
                                        <a :href="getDetailUrl(kos)" class="btn btn-primary-outline btn-sm flex-1 text-xs" data-hover="lift">Lihat Detail</a>
                                        <template x-if="kos.stock > 0">
                                            <a :href="getBookingUrl(kos)" class="btn btn-primary btn-sm flex-1 text-xs" data-hover="lift">Booking</a>
                                        </template>
                                        <template x-if="kos.stock === 0">
                                            <span class="btn btn-sm flex-1 text-xs bg-red-100 text-red-600" style="cursor:not-allowed;">Booking</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="filteredKos.length === 0" class="bg-white border border-border-light rounded-xl p-8 text-center text-text-muted" x-cloak>
                        Tidak ada kos yang sesuai filter. Coba ubah kata kunci atau longgarkan filter pencarian.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function cariKosPage() {
        return {
            showFilter: false,
            searchNama: '',
            searchLokasi: '',
            searchKampus: '',
            selectedType: '',
            selectedFacilities: [],
            maxPrice: 5000000,
            verifiedOnly: false,
            storageBaseUrl: @json(asset('storage')),
            appBaseUrl: @json(url('/')),
            placeholderImage: @json(asset('images/hero-illustration.png')),
            allKos: [],
            filteredKos: [],
            init() {
                // Map database records to Alpine.js format
                this.allKos = @json($kosData);
                
                const params = new URLSearchParams(window.location.search);
                if (params.has('search')) {
                    this.searchNama = params.get('search');
                }
                
                this.filterKos();

                this.$watch('searchNama', () => this.filterKos());
                this.$watch('searchLokasi', () => this.filterKos());
                this.$watch('searchKampus', () => this.filterKos());
                this.$watch('selectedType', () => this.filterKos());
                this.$watch('selectedFacilities', () => this.filterKos());
                this.$watch('maxPrice', () => this.filterKos());
                this.$watch('verifiedOnly', () => this.filterKos());
            },
            resetFilters() {
                this.searchNama = '';
                this.searchLokasi = '';
                this.searchKampus = '';
                this.selectedType = '';
                this.selectedFacilities = [];
                this.maxPrice = 5000000;
                this.verifiedOnly = false;
                this.filterKos();
            },
            formatPrice(value) {
                return Number(value).toLocaleString('id-ID');
            },
            getImageSrc(kos) {
                const rawImage = kos.image || kos.img || '';

                if (!rawImage) {
                    return this.placeholderImage;
                }

                // External URLs (http, https, data)
                if (rawImage.startsWith('http://') || rawImage.startsWith('https://') || rawImage.startsWith('data:')) {
                    return rawImage;
                }

                // Absolute path (starts with /)
                if (rawImage.startsWith('/')) {
                    return rawImage;
                }

                // Already full URL
                if (rawImage.startsWith('storage/')) {
                    return this.appBaseUrl + '/' + rawImage;
                }

                // Local storage path
                return this.storageBaseUrl + '/' + rawImage.replace(/^\/+/, '');
            },
            getDetailUrl(kos) {
                return window.location.origin + '/kos/' + encodeURIComponent(kos.slug);
            },
            getBookingUrl(kos) {
                return window.location.origin + '/booking/' + encodeURIComponent(kos.slug);
            },

            attemptBooking(kos) {
                // If user is not logged in (simulated via localStorage kc_role), prompt to login
                const role = localStorage.getItem('kc_role');
                if (!role) {
                    // show login prompt modal
                    if (confirm('Kamu harus masuk untuk melakukan booking. Masuk sekarang?')) {
                        window.location.href = '/login';
                    }
                    return;
                }
                // If logged in as mahasiswa, go to booking
                if (role === 'mahasiswa') {
                    window.location.href = this.getBookingUrl(kos);
                    return;
                }
                alert('Fitur booking hanya untuk akun Mahasiswa.');
            },
            getWhatsAppLink(kos) {
                const message = encodeURIComponent('Halo, saya tertarik dengan ' + kos.name + '. Apakah kamar masih tersedia?');
                return 'https://wa.me/' + kos.whatsappNumber + '?text=' + message;
            },
            filterKos() {
                const nameFilter = this.searchNama.trim().toLowerCase();
                const locationFilter = this.searchLokasi.trim().toLowerCase();
                const campusFilter = this.searchKampus.trim().toLowerCase();
                const selectedFacilities = this.selectedFacilities.map((facility) => facility.toLowerCase());

                this.filteredKos = (this.allKos || []).filter((kos) => {
                    const kosFacilities = (kos.fac || []).map((facility) => String(facility).toLowerCase());
                    const typeMatch = !this.selectedType || String(kos.type || '').toLowerCase() === this.selectedType.toLowerCase();
                    const priceMatch = Number(kos.price_number || 0) <= this.maxPrice;
                    const facilitiesMatch = selectedFacilities.length === 0
                        || selectedFacilities.every((facility) => kosFacilities.includes(facility));
                    const nameMatch = !nameFilter || String(kos.name || '').toLowerCase().includes(nameFilter);
                    const locationMatch = !locationFilter || String(kos.loc || '').toLowerCase().includes(locationFilter);
                    const campusMatch = !campusFilter || String(kos.campus || '').toLowerCase().includes(campusFilter);
                    const verifiedMatch = !this.verifiedOnly || Boolean(kos.verified);

                    return typeMatch
                        && priceMatch
                        && facilitiesMatch
                        && nameMatch
                        && locationMatch
                        && campusMatch
                        && verifiedMatch;
                });
            }
        };
    }
</script>
@endpush
