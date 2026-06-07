@extends('layouts.app')
@section('title', 'Pusat Bantuan — KosCheck')

@section('content')
{{-- Hero Section --}}
<section class="bg-gradient-to-br from-green-50 to-orange-50 py-16 md:py-20 text-center border-b border-border-light" data-reveal>
    <div class="container-custom max-w-3xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-extrabold text-text mb-4" data-reveal>Pusat Bantuan KosCheck</h1>
        <p class="text-sm text-text-muted mb-8 max-w-xl mx-auto leading-relaxed" data-reveal>
            Temukan jawaban dan informasi seputar penggunaan platform KosCheck. Kami siap membantu perjalanan mencari hunian Anda.
        </p>
        <div class="input-with-icon max-w-2xl mx-auto shadow-sm">
            <span class="input-icon"><svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></span>
            <input type="text" placeholder="Cari pertanyaan bantuan..." class="input-field py-4 rounded-xl border-none shadow-md focus:ring-2 focus:ring-primary">
        </div>
    </div>
</section>

{{-- Main Content Layout --}}
<section class="bg-bg py-10 md:py-16" data-reveal>
    <div class="container-custom">
        <div class="flex flex-col md:flex-row gap-10 lg:gap-16">

            {{-- Sidebar Categories --}}
            <aside class="w-full md:w-64 flex-shrink-0" data-reveal>
                <h3 class="text-xs font-bold text-text-muted mb-4 tracking-wider">KATEGORI</h3>
                <nav class="space-y-1">
                    <a href="#akun" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-medium text-sm transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Akun
                    </a>
                    <a href="#pencarian" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-muted hover:bg-gray-100 hover:text-text font-medium text-sm transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Pencarian Kos
                    </a>
                    <a href="#keamanan" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-muted hover:bg-gray-100 hover:text-text font-medium text-sm transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Keamanan
                    </a>
                    <a href="#galon" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-muted hover:bg-gray-100 hover:text-text font-medium text-sm transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Layanan Galon
                    </a>
                    <a href="#pemilik" class="flex items-center gap-3 px-4 py-3 rounded-xl text-text-muted hover:bg-gray-100 hover:text-text font-medium text-sm transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Pemilik Kos
                    </a>
                </nav>
            </aside>

            {{-- Main FAQ Content --}}
            <div class="flex-1 space-y-12">
                
                {{-- Akun --}}
                <div id="akun">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-text">Akun</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach(['Cara daftar akun', 'Cara login', 'Edit profil'] as $q)
                        <div x-data="{ open: false }" class="bg-white rounded-xl border border-border-light overflow-hidden transition-all duration-200 shadow-sm hover:border-primary/30">
                            <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 focus:outline-none">
                                <span class="font-semibold text-sm text-text">{{ $q }}</span>
                                <svg class="w-5 h-5 text-text-muted transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-collapse x-cloak>
                                <div class="p-5 text-sm text-text-muted leading-relaxed border-t border-border-light">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pencarian Kos --}}
                <div id="pencarian">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-text">Pencarian Kos</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach(['Cara mencari kos', 'Cara menghubungi pemilik'] as $q)
                        <div x-data="{ open: false }" class="bg-white rounded-xl border border-border-light overflow-hidden transition-all duration-200 shadow-sm hover:border-primary/30">
                            <button @click="open = !open" class="w-full flex items-center justify-between p-5 text-left bg-gray-50 focus:outline-none">
                                <span class="font-semibold text-sm text-text">{{ $q }}</span>
                                <svg class="w-5 h-5 text-text-muted transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-collapse x-cloak>
                                <div class="p-5 text-sm text-text-muted leading-relaxed border-t border-border-light">
                                    Gunakan fitur pencarian di beranda atau masuk ke menu Cari Kos. Anda bisa menggunakan filter rentang harga, tipe kos, dan fasilitas untuk mendapatkan hasil yang lebih spesifik.
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Keamanan --}}
                <div id="keamanan">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-green-brand text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-text">Keamanan</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 border border-green-200 border-l-4 border-l-green-500 rounded-xl p-5 shadow-sm">
                            <h4 class="font-bold text-sm text-text mb-2">Kos Terverifikasi</h4>
                            <p class="text-xs text-text-muted leading-relaxed">Cari logo centang hijau pada kartu kos. Itu menandakan tim kami telah melakukan survei fisik ke lokasi.</p>
                        </div>
                        <div class="bg-gray-50 border border-red-200 border-l-4 border-l-red-500 rounded-xl p-5 shadow-sm">
                            <h4 class="font-bold text-sm text-text mb-2">Hindari Penipuan</h4>
                            <p class="text-xs text-text-muted leading-relaxed">Jangan pernah mentransfer uang tanpa melihat lokasi fisik atau melalui sistem pembayaran resmi KosCheck.</p>
                        </div>
                    </div>
                </div>

                {{-- Layanan Air Galon --}}
                <div id="galon">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center">
                            <span class="text-lg">💧</span>
                        </div>
                        <h2 class="text-xl font-bold text-text">Layanan Air Galon</h2>
                    </div>
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 text-sm text-blue-800 leading-relaxed">
                        Kami bekerja sama dengan partner galon lokal untuk memastikan stok air minum di kos Anda selalu tersedia dengan harga kompetitif dan pengiriman cepat. Hubungi admin layanan galon kami jika mengalami kendala.
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- Masih Butuh Bantuan CTA --}}
<section class="bg-white py-12 md:py-16">
    <div class="container-custom">
        <div class="card p-8 md:p-10 border-none shadow-xl bg-gray-50" data-hover="lift">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div data-reveal>
                    <h2 class="text-2xl font-bold text-text mb-3">Masih butuh bantuan?</h2>
                    <p class="text-sm text-text-muted mb-6 max-w-md">Tim Customer Excellence kami siap menjawab pertanyaan Anda setiap hari.</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            support@koscheck.com
                        </div>
                        <div class="flex items-center gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Senin - Minggu (08:00 - 20:00 WIB)
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
<a href="#" class="btn btn-primary px-8 py-4" data-hover="lift">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Hubungi<br>Admin
                    </a>
                    <a href="#" class="btn btn-white border-green-500 text-green-600 px-8 py-4" data-hover="lift">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        Chat<br>WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
