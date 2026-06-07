@extends('layouts.app')
@section('title', 'Konfirmasi Password — KosCheck')

@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-5xl">
        <div class="card card-elevated overflow-hidden flex flex-col md:flex-row min-h-[600px] border-none" data-hover="lift">

            {{-- Left Side - Illustration --}}
            <div class="w-full md:w-1/2 bg-gradient-to-br from-amber-50 to-orange-100 p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="#D97706" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    {{-- Shield Icon Animation --}}
                    <div class="w-32 h-32 mx-auto mb-8 relative">
                        <div class="absolute inset-0 bg-orange-200 rounded-full animate-pulse opacity-25"></div>
                        <div class="relative w-full h-full bg-white rounded-2xl shadow-xl flex items-center justify-center">
                            <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m7.515-10.206a.75.75 0 00-.668.421l-12.5 26.25a.75.75 0 00.896 1.216l26.25-12.5a.75.75 0 00.421-.668v-13.5a.75.75 0 00-.75-.75h-13.5z"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-text mb-3">Verifikasi Identitas</h2>
                    <p class="text-text-muted text-sm max-w-[280px] mx-auto leading-relaxed">
                        Untuk keamanan akun Anda, silakan konfirmasi password saat mengakses area yang aman.
                    </p>
                </div>

                {{-- Security Note --}}
                <div class="relative z-10 mt-8 max-w-xs w-full">
                    <div class="rounded-2xl bg-white/90 p-4 shadow-sm border border-white">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-left">
                                <p class="text-xs font-bold text-text">Akses Aman</p>
                                <p class="text-xs text-text-muted">Ini adalah area terlindungi di KosCheck</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Form --}}
            <div class="w-full md:w-1/2 bg-white p-8 md:p-12 flex flex-col md:justify-center justify-start">
                <div class="max-w-md mx-auto w-full">
                    <h1 class="text-2xl md:text-3xl font-bold text-text mb-2">Konfirmasi Password</h1>
                    <p class="text-text-muted text-sm mb-8">Ini adalah area yang dilindungi. Silakan konfirmasi password Anda untuk melanjutkan.</p>

                    {{-- Error Alert --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Password tidak cocok</p>
                                <p>Password yang Anda masukkan tidak benar. Silakan coba lagi.</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('password.confirm') }}" method="POST" class="space-y-5" x-data="confirmPasswordForm()">
                        @csrf

                        {{-- Password Field --}}
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Password Anda</label>
                            <div class="input-with-icon relative">
                                <span class="input-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••" class="input-field bg-gray-50 pr-12 focus:bg-white @error('password') border-red-500 @enderror" required autocomplete="current-password">
                                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg" data-hover="lift">
                            Konfirmasi
                        </button>

                        <div class="text-center pt-4 border-t border-gray-100">
                            <p class="text-sm text-text-muted">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="font-semibold text-primary hover:text-primary-dark">Masuk dengan akun lain</a>
                            </p>
                        </div>
                    </form>

                    {{-- Logout Form (Hidden) --}}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                    {{-- Security Reminder --}}
                    <div class="mt-8 bg-amber-50 rounded-xl p-4 text-sm text-amber-800 border border-amber-100">
                        <p class="font-semibold mb-2">💡 Tips Keamanan</p>
                        <p class="text-xs leading-relaxed">Jangan pernah membagikan password Anda kepada siapa pun, termasuk tim KosCheck. Kami tidak akan pernah meminta password Anda melalui email atau pesan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function confirmPasswordForm() {
    return {
        showPassword: false
    }
}
</script>
@endpush
