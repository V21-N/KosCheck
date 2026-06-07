@extends('layouts.app')

@section('title', 'Pesan Air Galon — GalonKu — KosCheck')

@section('content')
<div class="bg-white min-h-screen">
    {{-- Breadcrumb --}}
    <div class="bg-gray-50 border-b border-border-light">
        <div class="container-custom py-4 text-sm">
            <div class="flex items-center gap-2 text-text-muted">
                <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <a href="{{ route('home') }}" class="hover:text-primary">Layanan Galon</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-text">GalonKu</span>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Service Detail --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Header with Image --}}
                <div>
                    <div class="relative mb-4 rounded-xl overflow-hidden h-80 bg-blue-200 flex items-center justify-center" data-reveal>
                        <svg class="w-32 h-32 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                    </div>

                    {{-- Badges & Title --}}
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-green-100 text-green-700 text-xs font-bold">Partner Resmi KosCheck</span>
                        <span class="badge bg-blue-100 text-blue-700 text-xs font-bold">Terverifikasi</span>
                    </div>

                    <h1 class="text-4xl font-bold text-text mb-3">GalonKu</h1>

                    {{-- Rating & Info --}}
                    <div class="flex flex-wrap gap-6 text-sm text-text-muted mb-6">
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="font-bold">4.9/5.0</span>
                            <span>(156 review)</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            <span>Depok, Jawa Barat</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-.707.707a1 1 0 101.414 1.414L9 9.414V6z" clip-rule="evenodd"/></svg>
                            <span>Jam Operasional: 08:00 - 20:00 WIB</span>
                        </div>
                    </div>

                    <div class="text-sm text-text-muted">
                        <p class="mb-2"><strong>Area Pengantar:</strong> Sekitar Kampus UI & Gunadarma</p>
                        <p><strong>Estimasi Pengiriman:</strong> 15–30 Menit</p>
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div>
                    <h2 class="text-2xl font-bold text-text mb-6">Daftar Produk</h2>

                    <div class="space-y-4">
                        @foreach([
                            ['name' => 'Isi Ulang Air Mineral 19L', 'price' => 'Rp 18.000', 'desc' => 'Air mineral penggunaan ulang gallon berkualitas untuk hunian maks -SMB per foto'],
                            ['name' => 'Isi Ulang Air RO 19L', 'price' => 'Rp 22.000', 'desc' => 'Reverse Osmosis dengan filtrasi mikro untuk kemurnian maksimal'],
                            ['name' => 'Galon Baru + Isi', 'price' => 'Rp 55.000', 'desc' => 'Galon PC baru berkualitas tinggi lengkap dengan isi air mineral.']
                        ] as $product)
                        <div class="border border-border-light rounded-lg p-5 hover:shadow-md transition-shadow" data-hover="lift" data-reveal>
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <h3 class="font-bold text-text mb-1">{{ $product['name'] }}</h3>
                                    <p class="text-sm text-text-muted">{{ $product['desc'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-primary">{{ $product['price'] }}</span>
                                <button class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition-colors text-sm" data-hover="lift">
                                    Pesan
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Keunggulan Partner --}}
                <div>
                    <h2 class="text-2xl font-bold text-text mb-6">Keunggulan Partner</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 scroll-animate-container">
                        @foreach([
                            ['icon' => '⚡', 'title' => 'Pengiriman Cepat', 'desc' => 'Layanan pengiriman yang cepat dan tepat sampai dari pintu kamarmu tanpa menunggu lama'],
                            ['icon' => '💰', 'title' => 'Harga Mahasiswa', 'desc' => 'Harga yang terjangkau untuk kantong anak setiap produk layanan terpercaya'],
                            ['icon' => '✅', 'title' => 'Aman & Terpercaya', 'desc' => 'Telah melalui proses verifikasi ketat dan standar kebersihan yang ketat KosCheck'],
                            ['icon' => '👥', 'title' => '500+ Mahasiswa', 'desc' => 'Sudah melayani ratusan mahasiswa kos setia dengan tingkat kepuasan 99%']
                        ] as $keunggulan)
                        <div class="flex gap-4">
                            <div class="text-3xl flex-shrink-0">{{ $keunggulan['icon'] }}</div>
                            <div>
                                <h3 class="font-bold text-text mb-1">{{ $keunggulan['title'] }}</h3>
                                <p class="text-sm text-text-muted">{{ $keunggulan['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Panduan Keamanan --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="font-bold text-red-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        Panduan Keamanan
                    </h3>

                    <ul class="space-y-2 text-sm text-red-800">
                        <li class="flex gap-2">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>Gunakan WhatsApp Resmi:</strong> Partner yang terdaftar di halaman ini sudah terverifikasi ketat</span>
                        </li>
                        <li class="flex gap-2">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>Pastikan Alamat Benar:</strong> Cek verifikasi detail alamat kos Anda sebelum dengan foto KTP</span>
                        </li>
                        <li class="flex gap-2">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span><strong>Hindari Pembayaran Sebelum Konfirmasi:</strong> Jangan transfer sampai partner memberikan estimasi dan foto produk terlebih dulu</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Right: Order Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    {{-- Status Badge --}}
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                        <h3 class="font-bold text-green-900 text-sm mb-1">Status: Online</h3>
                        <p class="text-xs text-green-700">Respons cepat dalam hitungan detik</p>
                    </div>

                    {{-- Order Summary --}}
                    <div class="bg-white border-t md:border border-border-light rounded-t-2xl md:rounded-xl p-4 md:p-6 fixed md:relative bottom-[env(safe-area-inset-bottom)] md:bottom-auto left-0 right-0 z-[60] md:z-auto shadow-[0_-10px_40px_rgba(0,0,0,0.1)] md:shadow-none">
                        <h3 class="font-bold text-text mb-4 hidden md:block">Ringkasan Pesanan</h3>

                        <div class="space-y-4 mb-6 pb-6 border-b border-border-light">
                            <div class="flex justify-between text-sm">
                                <span class="text-text-muted">Pilih Produk Galon</span>
                                <select class="text-right font-medium text-text focus:outline-none bg-transparent">
                                    <option>Isi Ulang Air Mineral 19L</option>
                                </select>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-text-muted">Harga Produk (1x)</span>
                                <span class="font-medium text-text">Rp 18.000</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-text-muted">Ongkos Kirim</span>
                                <span class="font-medium text-text">Rp 2.000</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4 md:mb-6">
                            <span class="font-bold text-text hidden md:inline">Total Bayar</span>
                            <div class="md:hidden">
                                <span class="text-xs text-text-muted">Total Bayar</span>
                                <div class="font-bold text-lg text-primary leading-none">Rp 20.000</div>
                            </div>
                            <span class="font-bold text-2xl text-primary hidden md:inline">Rp 20.000</span>
                            
                            <div class="flex gap-2 md:hidden">
                                <button class="btn btn-primary font-semibold px-6 py-2">
                                    Pesan
                                </button>
                            </div>
                        </div>

                        <div class="hidden md:block">
                            <button class="w-full btn btn-primary mb-3 font-semibold py-3" data-hover="lift">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.79l.291 1.991a1 1 0 01-.963 1.179h-1.97a1 1 0 00-.8.4l-1.5 2a1 1 0 00.2 1.291l1.378 1.035a1 1 0 01.4 1.091L3.85 15.75a1 1 0 01-.95.844H3a1 1 0 01-1-1v-12z"/></svg>
                                Pesan via WhatsApp
                            </button>

                            <button class="w-full border-2 border-primary text-primary hover:bg-primary-light rounded-lg font-semibold py-3 transition-colors" data-hover="lift">
                                Konfirmasi Pesanan
                            </button>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-900">
                        <p class="mb-2"><strong>💡 Tips:</strong> Hubungi partner langsung via WhatsApp untuk mendapatkan promo menarik atau penawaran khusus untuk pembelian dalam jumlah besar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
