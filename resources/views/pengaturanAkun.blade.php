@extends('layouts.owner')

@section('title', 'Pengaturan Akun — KosCheck Manager')

@section('topbar_left')
    <h1 class="text-2xl font-bold text-text">Pengaturan Akun</h1>
@endsection

@section('content')
<div class="max-w-4xl mx-auto scroll-animate-container">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Sidebar Tabs --}}
        <div class="lg:col-span-1" data-reveal>
            <nav class="space-y-2 bg-white rounded-xl border border-border-light p-4 sticky top-20 h-fit">
                <a href="#profil" class="block px-4 py-3 rounded-lg font-medium text-primary bg-primary-light transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informasi Profil
                    </div>
                </a>
                <a href="#keamanan" class="block px-4 py-3 rounded-lg font-medium text-text-muted hover:text-primary transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Keamanan Akun
                    </div>
                </a>
                <a href="#verifikasi" class="block px-4 py-3 rounded-lg font-medium text-text-muted hover:text-primary transition-colors">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Verifikasi Akun
                    </div>
                </a>
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Section 1: Informasi Profil --}}
            <div id="profil" class="bg-white rounded-xl border border-border-light p-8 shadow-sm scroll-mt-20" data-hover="lift" data-reveal>
                <h2 class="text-xl font-bold text-text mb-6">Informasi Profil</h2>

                <div class="flex items-center gap-4 mb-8 pb-8 border-b border-border-light">
                    <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-md overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=F47C20&color=fff&size=64" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <div>
                        <h3 class="font-bold text-text">Budi Santoso</h3>
                        <p class="text-sm text-text-muted">budi.budi.properti@example.com</p>
                    </div>
                </div>

                <form class="space-y-5" data-validate>
                    {{-- Nama Pemilik Kos --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Nama Pemilik Kos</label>
                        <input type="text" value="Budi Santoso"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Email</label>
                        <input type="email" value="budi.budi.properti@example.com"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- Nomor WhatsApp --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Nomor WhatsApp</label>
                        <input type="tel" value="+62 812345678990"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Alamat</label>
                        <textarea rows="3"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">Jl. Melati No. 45, Kecamatan Lowokwaru, Kota Malang, Jawa Timur</textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition-colors" data-hover="lift">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Section 2: Keamanan Akun --}}
            <div id="keamanan" class="bg-white rounded-xl border border-border-light p-8 shadow-sm scroll-mt-20" data-hover="lift" data-reveal>
                <h2 class="text-xl font-bold text-text mb-6">Keamanan Akun</h2>

                <div class="space-y-5">
                    {{-- Password Lama --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Password Lama</label>
                        <input type="password" value="••••••••"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- Password Baru --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Password Baru</label>
                        <input type="password" placeholder="••••••••"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Konfirmasi Password</label>
                        <input type="password" placeholder="••••••••"
                            class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <button type="button" class="text-sm font-medium text-primary hover:underline">
                        Ubah Password
                    </button>
                </div>

                {{-- Security Alerts --}}
                <div class="mt-8 pt-8 border-t border-border-light space-y-4">
                    <div class="bg-black/5 border border-black/10 rounded-lg p-4">
                        <h3 class="font-bold text-text text-sm mb-1">Keamanan Terjamin</h3>
                        <p class="text-xs text-text-muted">Enkripsi end-to-end dengan standar AES-256 dan HTTPS.</p>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h3 class="font-bold text-yellow-900 text-sm mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Keamanan Terjamin
                        </h3>
                        <p class="text-xs text-yellow-800">Data akun Anda dijaga baik dengan enkripsi end-to-end dan pastikan tak mudah diretas.</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-bold text-green-900 text-sm mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Kepercayaan Penyewa
                        </h3>
                        <p class="text-xs text-green-800">Verifikasi memberikan kepercayaan 50% lebih tinggi kepada calon penyewa dibanding pemilik kos tidak terverifikasi.</p>
                    </div>
                </div>
            </div>

            {{-- Section 3: Verifikasi Akun --}}
            <div id="verifikasi" class="bg-white rounded-xl border border-border-light p-8 shadow-sm scroll-mt-20" data-hover="lift" data-reveal>
                <h2 class="text-xl font-bold text-text mb-6">Verifikasi Akun</h2>

                <div class="space-y-6">
                    {{-- Status Verifikasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Terverifikasi --}}
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-green-900">Status: Terverifikasi</h3>
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                            <p class="text-sm text-green-700">Update data diri Anda lagi sebelum waktu verifikasi berakhir dalam 30 hari.</p>
                        </div>

                        {{-- Foto KTP --}}
                        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-orange-900 mb-2">Foto KTP</h3>
                                <p class="text-sm text-orange-700 mb-4">Cek verifikasi identitas kos Anda sebelum dengan foto KTP</p>
                            </div>
                            <button type="button" class="w-full px-6 py-2 bg-white border border-orange-200 text-orange-900 font-semibold rounded-lg hover:bg-orange-50 transition-colors text-sm" data-hover="lift">
                                Upload Foto KTP
                            </button>
                        </div>
                    </div>

                    {{-- Selfie dengan KTP --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                            Selfie dengan KTP
                        </h3>
                        <p class="text-sm text-blue-700 mb-4">Ambil foto selfie dengan menunjukan KTP sebagai verifikasi lanjutan</p>
                        <button type="button" class="px-6 py-2 bg-white border border-blue-200 text-blue-900 font-semibold rounded-lg hover:bg-blue-50 transition-colors text-sm" data-hover="lift">
                            Ambil Foto Selfie
                        </button>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="mt-8 pt-8 border-t border-border-light bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-text-muted leading-relaxed">
                        <strong class="text-text">Catatan Penting:</strong> Proses verifikasi memastikan bahwa data pemilik kos sudah terverifikasi dan dapat dipercaya. Verifikasi juga meningkatkan kepercayaan penyewa hingga 50% lebih tinggi dibanding pemilik kos yang belum terverifikasi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
