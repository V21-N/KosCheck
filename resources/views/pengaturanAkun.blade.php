@extends('layouts.owner')

@section('title', 'Pengaturan Akun — KosCheck Manager')

@section('topbar_left')
    <h1 class="text-2xl font-bold text-text">Pengaturan Akun</h1>
@endsection

@section('content')
<div class="max-w-4xl mx-auto scroll-animate-container">
    {{-- Success/Error Messages --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
    @endif

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
            </nav>
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Section 1: Informasi Profil --}}
            <div id="profil" class="bg-white rounded-xl border border-border-light p-8 shadow-sm scroll-mt-20" data-hover="lift" data-reveal>
                <h2 class="text-xl font-bold text-text mb-6">Informasi Profil</h2>

                <div class="flex items-center gap-4 mb-8 pb-8 border-b border-border-light">
                    <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-md overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=F47C20&color=fff&size=64" 
                                 class="w-full h-full object-cover" 
                                 loading="lazy">
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-text">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-text-muted">{{ Auth::user()->email }}</p>
                        @if(Auth::user()->google_id)
                            <span class="inline-flex items-center gap-1 text-xs text-green-600 mt-1">
                                <svg class="w-3 h-3" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Login dengan Google
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Form Profile --}}
                <form action="{{ route('dashboard.pengaturan.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nama Pemilik Kos --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Nama Pemilik Kos</label>
                        <input type="text" 
                               name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email (Readonly) --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Email</label>
                        <input type="email" 
                               value="{{ Auth::user()->email }}"
                               readonly
                               class="w-full px-4 py-3 border border-border-light rounded-lg bg-gray-50 text-text-muted cursor-not-allowed">
                        @if(Auth::user()->google_id)
                            <p class="text-xs text-text-muted mt-1">Email tidak dapat diubah karena terhubung dengan akun Google.</p>
                        @endif
                    </div>

                    {{-- Nomor WhatsApp --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Nomor WhatsApp</label>
                        <input type="tel" 
                               name="phone"
                               value="{{ old('phone', Auth::user()->phone ?? '') }}"
                               placeholder="+62 812 3456 7890"
                               class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Alamat</label>
                        <textarea name="address" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', Auth::user()->address ?? '') }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition-colors" data-hover="lift">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Section 2: Keamanan Akun --}}
            <div id="keamanan" class="bg-white rounded-xl border border-border-light p-8 shadow-sm scroll-mt-20" data-hover="lift" data-reveal>
                <h2 class="text-xl font-bold text-text mb-6">Keamanan Akun</h2>

                @if(Auth::user()->google_id)
                    {{-- Google User --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-blue-900">Akun Terhubung dengan Google</h3>
                                <p class="text-sm text-blue-700">Anda login menggunakan Google OAuth. Password dikelola oleh Google, sehingga tidak perlu diubah di sini.</p>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Non-Google User --}}
                    <form action="{{ route('dashboard.pengaturan.password') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Password Lama</label>
                            <input type="password" 
                                   name="current_password"
                                   class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Password Baru</label>
                            <input type="password" 
                                   name="password"
                                   class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Konfirmasi Password</label>
                            <input type="password" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 border border-border-light rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition-colors" data-hover="lift">
                            Ubah Password
                        </button>
                    </form>
                @endif

                {{-- Security Info --}}
                <div class="mt-8 pt-8 border-t border-border-light space-y-4">
                    <div class="bg-black/5 border border-black/10 rounded-lg p-4">
                        <h3 class="font-bold text-text text-sm mb-1">Keamanan Terjamin</h3>
                        <p class="text-xs text-text-muted">Enkripsi end-to-end dengan standar AES-256 dan HTTPS.</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-bold text-green-900 text-sm mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Kepercayaan Penyewa
                        </h3>
                        <p class="text-xs text-green-800">Data yang terverifikasi memberikan kepercayaan 50% lebih tinggi kepada calon penyewa.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection