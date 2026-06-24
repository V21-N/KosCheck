@extends('layouts.app')
@section('title', 'Masuk ke KosCheck')

{{-- Simplified Footer for Auth Pages --}}
@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-5xl">
        <div class="card card-elevated overflow-hidden flex flex-col md:flex-row min-h-[600px] border-none" data-hover="lift">

            {{-- Left Side - Illustration --}}
            <div class="w-full md:w-1/2 bg-gradient-to-br from-orange-50 to-orange-100 p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <img src="{{ asset('images/login-illustration.png') }}" alt="Ilustrasi" class="w-full max-w-[320px] rounded-2xl mb-8 relative z-10 shadow-lg" loading="lazy">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-text mb-3">Memulai Babak Baru</h2>
                    <p class="text-text-muted text-sm max-w-[280px] mx-auto leading-relaxed">
                        Temukan hunian yang aman, nyaman, dan terverifikasi untuk perjalanan akademikmu.
                    </p>
                </div>
            </div>

            {{-- Right Side - Form --}}
            <div class="w-full md:w-1/2 bg-white p-8 md:p-12 flex flex-col md:justify-center justify-start" x-data="loginPage()">
                <h1 class="text-2xl md:text-3xl font-bold text-text mb-2">Masuk ke KosCheck</h1>
                <p class="text-text-muted text-sm mb-8">Pilih peran untuk masuk ke dashboard masing-masing.</p>

                {{-- Success/Error Messages --}}
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
                @endif
                
                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold">Kesalahan</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                {{-- Dummy Accounts Info --}}
                <div class="flex gap-2 mb-6 flex-wrap">
                    <template x-if="selectedRole === 'mahasiswa'">
                        <div class="w-full bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs text-blue-800 leading-relaxed">
                            <span class="font-bold">Akun Demo Mahasiswa:</span> mahasiswa@usu.ac.id / <span class="font-mono">password</span>
                        </div>
                    </template>
                    <template x-if="selectedRole === 'owner'">
                        <div class="w-full bg-green-50 border border-green-100 rounded-xl p-3 text-xs text-green-800 leading-relaxed">
                            <span class="font-bold">Akun Demo Pemilik:</span> owner@email.com / <span class="font-mono">password</span>
                        </div>
                    </template>
                    <template x-if="selectedRole === 'admin'">
                        <div class="w-full bg-purple-50 border border-purple-100 rounded-xl p-3 text-xs text-purple-800 leading-relaxed">
                            <span class="font-bold">Akun Demo Admin:</span> admin@koscheck.id / <span class="font-mono">password</span>
                        </div>
                    </template>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" x-model="selectedRole">

                    {{-- Role Toggle --}}
                    <div class="flex flex-col sm:flex-row bg-gray-100 p-1 rounded-lg mb-6 gap-1 sm:gap-0">
                        <button type="button" @click.prevent="selectedRole = 'mahasiswa'" :class="selectedRole === 'mahasiswa' ? 'bg-white shadow text-primary' : 'text-text-muted hover:text-text'" class="flex-1 py-2 text-sm font-semibold rounded-md transition-all">Mahasiswa</button>
                        <button type="button" @click.prevent="selectedRole = 'owner'" :class="selectedRole === 'owner' ? 'bg-white shadow text-primary' : 'text-text-muted hover:text-text'" class="flex-1 py-2 text-sm font-semibold rounded-md transition-all">Pemilik / Partner</button>
                        <button type="button" @click.prevent="selectedRole = 'admin'" :class="selectedRole === 'admin' ? 'bg-white shadow text-primary' : 'text-text-muted hover:text-text'" class="flex-1 py-2 text-sm font-semibold rounded-md transition-all">Admin</button>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-text mb-2">Email</label>
                        <div class="input-with-icon">
                            <span class="input-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                            <input type="email" name="email" placeholder="contoh: budi@kampus.id" class="input-field bg-gray-50 focus:bg-white @error('email') border-red-500 @enderror" x-model="email" required>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-text mb-2">Password</label>
                        <div class="input-with-icon relative">
                            <span class="input-icon"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••" class="input-field bg-gray-50 focus:bg-white @error('password') border-red-500 @enderror" x-model="password" required>
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-border text-primary accent-primary">
                            <span class="text-sm text-text group-hover:text-primary transition-colors">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary hover:text-primary-dark transition-colors">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full btn-lg mb-6" data-hover="lift">Masuk</button>

                    {{-- Divider --}}
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-text-muted">atau</span>
                        </div>
                    </div>

                    {{-- Google OAuth Button --}}
                    <a href="{{ route('auth.google.redirect') }}"
                       class="btn btn-outline btn-full btn-lg mb-6 flex items-center justify-center gap-3 border-2 hover:bg-gray-50 transition-all">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="font-semibold">Masuk dengan Google</span>
                    </a>

                    <p class="text-center text-sm text-text-muted mb-8">
                        Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-primary hover:text-primary-dark">Daftar</a>
                    </p>
                </form>

                {{-- Trust Badges --}}
                <div class="bg-green-50 rounded-xl p-4 flex items-start gap-3 border border-green-100">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <div>
                        <p class="text-xs text-green-800 leading-relaxed mb-2">Komunikasi dilakukan melalui WhatsApp resmi pemilik kos yang terverifikasi.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="text-[0.6rem] font-bold bg-green-600 text-white px-2 py-0.5 rounded-full flex items-center gap-1"><svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> PEMILIK TERVERIFIKASI</span>
                            <span class="text-[0.6rem] font-bold bg-orange-700 text-white px-2 py-0.5 rounded-full flex items-center gap-1"><svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg> AMAN & TERPERCAYA</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function loginPage() {
    return {
        selectedRole: 'mahasiswa',
        email: '',
        password: '',
        showPassword: false
    }
}
</script>
@endpush
