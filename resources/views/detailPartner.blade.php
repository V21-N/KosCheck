@extends('layouts.app')

@section('title', 'Detail Partner — KosCheck')

@section('content')
<div class="bg-white min-h-screen" x-data="{
    slug: '{{ $slug ?? request()->route('slug') }}',
    partners: {
        'galonku-medan': {
            name: 'GalonKu Medan',
            location: 'Medan Baru',
            rating: '4.8',
            reviews: 156,
            wa: '6281234567890',
            jam: '08:00 - 20:00',
            estimasi: '15–30 Menit',
            products: [
                {name: 'Isi Ulang Air Mineral 19L', price: 'Rp 18.000'},
                {name: 'Isi Ulang Air RO 19L', price: 'Rp 22.000'},
                {name: 'Galon Baru + Isi', price: 'Rp 55.000'}
            ]
        },
        'aqua-fresh-usu': {
            name: 'Aqua Fresh USU',
            location: 'Medan Tuntungan',
            rating: '4.7',
            reviews: 89,
            wa: '6281234567891',
            jam: '07:00 - 21:00',
            estimasi: '20–40 Menit',
            products: [
                {name: 'Isi Ulang Air Mineral 19L', price: 'Rp 17.000'},
                {name: 'Air RO Premium 19L', price: 'Rp 21.000'}
            ]
        },
        'air-bersih-24-jam': {
            name: 'Air Bersih 24 Jam',
            location: 'Medan Kota',
            rating: '4.9',
            reviews: 243,
            wa: '6281234567892',
            jam: '24 Jam',
            estimasi: '10–25 Menit',
            products: [
                {name: 'Isi Ulang Air Mineral 19L', price: 'Rp 16.500'},
                {name: 'Galon Baru + Isi', price: 'Rp 52.000'}
            ]
        }
    },
    get data() {
        return this.partners[this.slug] || this.partners['galonku-medan'];
    }
}">
    {{-- Breadcrumb --}}
    <div class="bg-gray-50 border-b border-border-light">
        <div class="container-custom py-4 text-sm">
            <div class="flex items-center gap-2 text-text-muted">
                <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <a href="{{ route('layanan-galon') }}" class="hover:text-primary">Layanan Galon</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-text" x-text="data.name"></span>
            </div>
        </div>
    </div>

    <div class="container-custom py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Content --}}
            <div class="lg:col-span-2">
                <div class="relative mb-6 rounded-2xl overflow-hidden h-96 bg-blue-200 flex items-center justify-center">
                    <svg class="w-40 h-40 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                </div>

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-green-100 text-green-700 text-xs font-bold">Partner Resmi KosCheck</span>
                    <span class="badge bg-blue-100 text-blue-700 text-xs font-bold">Terverifikasi</span>
                </div>

                <h1 class="text-4xl font-bold text-text mb-2" x-text="data.name"></h1>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 p-4 bg-gray-50 rounded-xl">
                    <div>
                        <h3 class="text-sm text-text-muted mb-1">Rating</h3>
                        <p class="font-bold text-text flex items-center gap-1">
                            <span class="text-lg">⭐</span> <span x-text="data.rating + '/5.0'"></span>
                        </p>
                        <p class="text-xs text-text-muted" x-text="'(' + data.reviews + ' review)'"></p>
                    </div>
                    <div>
                        <h3 class="text-sm text-text-muted mb-1">Lokasi</h3>
                        <p class="font-bold text-text" x-text="data.location"></p>
                        <p class="text-xs text-text-muted">Medan, Sumatera Utara</p>
                    </div>
                    <div>
                        <h3 class="text-sm text-text-muted mb-1">Jam Operasional</h3>
                        <p class="font-bold text-text" x-text="data.jam"></p>
                        <p class="text-xs text-text-muted">WIB</p>
                    </div>
                    <div>
                        <h3 class="text-sm text-text-muted mb-1">Estimasi</h3>
                        <p class="font-bold text-text" x-text="data.estimasi"></p>
                        <p class="text-xs text-text-muted">Pengiriman</p>
                    </div>
                </div>

                {{-- Products --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-text mb-6">Daftar Produk</h2>
                    <div class="space-y-4">
                        <template x-for="prod in data.products">
                            <div class="flex items-center justify-between p-5 border border-border-light rounded-lg">
                                <div>
                                    <h3 class="font-bold text-text" x-text="prod.name"></h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary" x-text="prod.price"></p>
                                    <a :href="'https://wa.me/' + data.wa + '?text=Halo%20' + encodeURIComponent(data.name) + '%2C%20saya%20mau%20pesan%20' + encodeURIComponent(prod.name)" target="_blank" class="mt-2 inline-block px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold text-sm">Pesan</a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Keunggulan --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-text mb-6">Keunggulan Partner</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            ['icon' => '⚡', 'title' => 'Pengiriman Cepat', 'desc' => 'Layanan pengiriman yang cepat sampai di pintu kamarmu'],
                            ['icon' => '💰', 'title' => 'Harga Mahasiswa', 'desc' => 'Harga terjangkau untuk kantong anak setiap produk'],
                            ['icon' => '✅', 'title' => 'Aman & Terpercaya', 'desc' => 'Telah lolos verifikasi ketat KosCheck'],
                            ['icon' => '👥', 'title' => '500+ Mahasiswa', 'desc' => 'Melayani ratusan mahasiswa dengan kepuasan 99%']
                        ] as $k)
                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="text-4xl flex-shrink-0">{{ $k['icon'] }}</div>
                            <div>
                                <h3 class="font-bold text-text mb-1">{{ $k['title'] }}</h3>
                                <p class="text-sm text-text-muted">{{ $k['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5 text-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mx-auto mb-3 animate-pulse"></div>
                        <h3 class="font-bold text-green-900 mb-1">Status: Sedang Online</h3>
                        <p class="text-xs text-green-700">Respons cepat dalam hitungan detik</p>
                    </div>

                    <div class="bg-white border-t md:border border-border-light rounded-t-2xl md:rounded-xl p-4 md:p-6 fixed md:relative bottom-[env(safe-area-inset-bottom)] md:bottom-auto left-0 right-0 z-[60] md:z-auto shadow-[0_-10px_40px_rgba(0,0,0,0.1)] md:shadow-none flex flex-row md:flex-col items-center justify-between gap-4 md:gap-0">
                        <div class="hidden md:block w-full">
                            <h3 class="font-bold text-text mb-4">Informasi Kontak</h3>
                            <div class="space-y-4 mb-6 pb-6 border-b border-border-light">
                                <div>
                                    <p class="text-xs text-text-muted mb-1">Nomor WhatsApp</p>
                                    <p class="font-semibold text-text" x-text="'+62 ' + data.wa.substring(2)"></p>
                                </div>
                            </div>
                        </div>

                        <div class="md:hidden">
                            <p class="text-xs text-text-muted mb-0.5">Mulai dari</p>
                            <p class="font-bold text-primary leading-none" x-text="data.products[0]?.price || 'Hubungi Admin'"></p>
                        </div>

                        <div class="flex gap-2 flex-1 md:w-full md:flex-col md:gap-3">
                            <a :href="'https://wa.me/' + data.wa + '?text=Halo%20' + encodeURIComponent(data.name)" target="_blank" class="w-full btn btn-primary font-semibold py-2 md:py-3 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 hidden md:block" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.79l.291 1.991a1 1 0 01-.963 1.179h-1.97a1 1 0 00-.8.4l-1.5 2a1 1 0 00.2 1.291l1.378 1.035a1 1 0 01.4 1.091L3.85 15.75a1 1 0 01-.95.844H3a1 1 0 01-1-1v-12z"/></svg>
                                <span class="hidden md:inline">Chat via WhatsApp</span>
                                <span class="md:hidden">Chat</span>
                            </a>
                            <a :href="'https://wa.me/' + data.wa + '?text=Halo%20' + encodeURIComponent(data.name) + '%2C%20saya%20ingin%20konfirmasi%20pesanan%20galon'" target="_blank" class="w-full border-2 border-primary text-primary hover:bg-primary-light rounded-lg font-semibold py-2 md:py-3 transition-colors block text-center flex items-center justify-center">
                                Konfirmasi <span class="hidden md:inline">&nbsp;Pesanan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection