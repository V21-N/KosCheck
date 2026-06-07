@extends('layouts.app')

@section('title', 'Layanan Galon — KosCheck')

{{-- Public page: show public navbar (guest). Ordering requires login --}}

@section('content')
<div class="bg-white min-h-screen" x-data="{">
    @include('components.mobile-review')

<div x-data="{
    lokasi: '',
    cari: '',
    partners: [
        {name:'GalonKu Medan', rating:4.8, reviews:156, location:'Medan Baru', badge:'REKOMENDASI', wa:'6281234567890', slug:'galonku-medan', color:'bg-blue-200'},
        {name:'Aqua Fresh USU', rating:4.7, reviews:89, location:'Medan Tuntungan', badge:'PARTNER RESMI', wa:'6281234567891', slug:'aqua-fresh-usu', color:'bg-cyan-200'},
        {name:'Air Bersih 24 Jam', rating:4.9, reviews:243, location:'Medan Kota', badge:'PARTNER RESMI', wa:'6281234567892', slug:'air-bersih-24-jam', color:'bg-blue-100'},
        {name:'Fresh Water Station', rating:4.6, reviews:92, location:'Medan Selayang', badge:'PARTNER RESMI', wa:'6281234567893', slug:'fresh-water-station', color:'bg-emerald-200'},
        {name:'Aqua Segar Medan', rating:4.5, reviews:67, location:'Medan Sunggal', badge:'PARTNER BARU', wa:'6281234567894', slug:'aqua-segar-medan', color:'bg-teal-200'},
        {name:'Water Depot Plus', rating:4.7, reviews:104, location:'Medan Amplas', badge:'PARTNER RESMI', wa:'6281234567895', slug:'water-depot-plus', color:'bg-sky-200'}
    ],
    get filteredPartners() {
        const q = (this.lokasi + ' ' + this.cari).toLowerCase().trim();
        if (!q) return this.partners;
        return this.partners.filter(p => 
            p.name.toLowerCase().includes(q) || 
            p.location.toLowerCase().includes(q)
        );
    },

    attemptOrder(partner) {
        const role = localStorage.getItem('kc_role');
        if (!role) {
            if (confirm('Kamu harus masuk untuk memesan. Masuk sekarang?')) {
                window.location.href = '/login';
            }
            return;
        }
        if (role !== 'mahasiswa') {
            alert('Fitur pemesanan hanya untuk akun Mahasiswa.');
            return;
        }
        const msg = encodeURIComponent('Halo ' + partner.name + ', saya ingin memesan galon.');
        window.open('https://wa.me/' + partner.wa + '?text=' + msg, '_blank');
    }
}">

    {{-- Search & Filter --}}
    <section class="bg-gray-50 py-8 border-b border-border-light">
        <div class="container-custom">
            <div class="flex flex-col md:flex-row gap-4 items-stretch">
                <div class="flex-1 flex items-center gap-2 bg-white border border-border-light rounded-lg px-4 py-3">
                    <svg class="w-5 h-5 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <input type="text" x-model="lokasi" placeholder="Cari lokasi (cth: Medan Tuntungan)" class="flex-1 outline-none text-sm" @input.debounce.300ms="cariPartner">
                </div>

                <div class="flex-1 flex items-center gap-2 bg-white border border-border-light rounded-lg px-4 py-3">
                    <svg class="w-5 h-5 text-text-muted flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="cari" placeholder="Cari penyedia galon" class="flex-1 outline-none text-sm" @input.debounce.300ms="cariPartner">
                </div>

                <button @click="cariPartner" class="bg-primary hover:bg-primary-dark text-white font-semibold px-8 py-3 rounded-lg transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Sekarang
                </button>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-12 border-b border-border-light" data-reveal>
        <div class="container-custom">
            <h2 class="text-3xl font-bold text-center mb-12">Cara Pesan Galon di KosCheck</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach([
                    ['icon' => '👤', 'title' => 'Pilih Penyedia', 'desc' => 'Cari penyedia galon terdekat yang sesuai budgetmu'],
                    ['icon' => '💬', 'title' => 'Hubungi WhatsApp', 'desc' => 'Klik tombol WhatsApp untuk langsung menghubungi pemilik'],
                    ['icon' => '📍', 'title' => 'Konfirmasi Alamat', 'desc' => 'Berikan detail alamat kos dan jumlah galon yang kamu pesan'],
                    ['icon' => '🚚', 'title' => 'Galon Diantar', 'desc' => 'Penyedia mengantarkan galon langsung ke depan pintu kamarmu']
                ] as $step)
                <div class="text-center" data-hover="lift" data-reveal>
                    <div class="w-16 h-16 rounded-full bg-primary-light flex items-center justify-center text-4xl mx-auto mb-4">{{ $step['icon'] }}</div>
                    <h3 class="font-bold text-text text-lg mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-text-muted leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Partners --}}
    <section class="py-12">
        <div class="container-custom">
            <h2 class="text-2xl font-bold mb-8">Penyedia Terdekat di Medan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="p in filteredPartners" :key="p.slug">
                    <div class="bg-white border border-border-light rounded-xl overflow-hidden hover:shadow-lg transition-shadow" data-hover="lift">
                        <div :class="p.color" class="h-48 flex items-center justify-center relative">
                            <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                            <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold" :class="p.badge.includes('REKOMENDASI') ? 'bg-primary text-white' : 'bg-green-100 text-green-800'" x-text="p.badge"></span>
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-lg text-text mb-2" x-text="p.name"></h3>
                            
                            <div class="flex items-center gap-2 mb-3">
                                <div class="flex items-center">
                                    <template x-for="i in 5">
                                        <svg class="w-4 h-4" :class="i <= Math.floor(p.rating) ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    </template>
                                </div>
                                <span class="text-sm font-medium" x-text="p.rating"></span>
                                <span class="text-xs text-text-muted" x-text="'(' + p.reviews + ' review)'"></span>
                            </div>

                            <p class="text-sm text-text-muted mb-4 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                <span x-text="p.location"></span>
                            </p>

                            <a :href="'/login'" class="w-full btn btn-primary block text-center mb-2 text-sm">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.79l.291 1.991a1 1 0 01-.963 1.179h-1.97a1 1 0 00-.8.4l-1.5 2a1 1 0 00.2 1.291l1.378 1.035a1 1 0 01.4 1.091L3.85 15.75a1 1 0 01-.95.844H3a1 1 0 01-1-1v-12z"/></svg>
                                <span>Pesan via WhatsApp</span>
                            </a>
                            <a :href="'/login'" class="w-full px-4 py-2 border-2 border-primary text-primary hover:bg-primary-light rounded-lg font-semibold transition-colors text-sm block text-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- Security --}}
    <section class="bg-gray-50 py-12 border-t border-border-light">
        <div class="container-custom">
            <h2 class="text-2xl font-bold text-center mb-8">Keamanan Pemesanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex gap-4">
                    <svg class="w-6 h-6 text-green-brand flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <h3 class="font-bold text-text mb-1">Gunakan WhatsApp Resmi</h3>
                        <p class="text-sm text-text-muted">Selalu berkomunikasi melalui nomor partner yang terdaftar di sistem KosCheck</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <svg class="w-6 h-6 text-green-brand flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <h3 class="font-bold text-text mb-1">Pastikan Alamat Benar</h3>
                        <p class="text-sm text-text-muted">Cek detail alamat kos sebelum konfirmasi estimasi waktu antar</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <svg class="w-6 h-6 text-green-brand flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div>
                        <h3 class="font-bold text-text mb-1">Bayar Setelah Sampai</h3>
                        <p class="text-sm text-text-muted">Hindari transfer sebelum galon sampai di depan pintu kamar kos</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Partner CTA --}}
    <section class="bg-primary text-white py-12">
        <div class="container-custom text-center">
            <h2 class="text-3xl font-bold mb-4">Menjadi Partner KosCheck</h2>
            <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Penyedia air galon dapat bekerja sama dengan KosCheck untuk menjangkau lebih banyak mahasiswa kos dan meningkatkan kredibilitas bisnis.</p>
            <a href="{{ route('register') }}" class="inline-block btn bg-white text-primary hover:bg-gray-100 font-semibold px-8 py-3 rounded-lg transition-colors">
                Daftar Sebagai Partner
            </a>
        </div>
    </section>
</div>
@endsection