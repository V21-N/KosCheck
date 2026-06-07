@extends('layouts.app')
@section('title', 'Atur Ulang Password — KosCheck')

@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-5xl">
        <div class="card card-elevated overflow-hidden flex flex-col md:flex-row min-h-[600px] border-none" data-hover="lift">

            {{-- Left Side - Illustration --}}
            <div class="w-full md:w-1/2 bg-gradient-to-br from-purple-50 to-pink-100 p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="#9F1239" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    {{-- Lock Icon Animation --}}
                    <div class="w-32 h-32 mx-auto mb-8 relative">
                        <div class="absolute inset-0 bg-pink-200 rounded-full animate-pulse opacity-25"></div>
                        <div class="relative w-full h-full bg-white rounded-2xl shadow-xl flex items-center justify-center">
                            <svg class="w-16 h-16 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-text mb-3">Password Baru</h2>
                    <p class="text-text-muted text-sm max-w-[280px] mx-auto leading-relaxed">
                        Buat password yang kuat dan aman untuk melindungi akun KosCheck Anda.
                    </p>
                </div>

                {{-- Password Tips --}}
                <div class="relative z-10 mt-8 max-w-xs w-full space-y-3">
                    <div class="flex items-start gap-3 bg-white/90 rounded-xl p-4 border border-white">
                        <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-left">
                            <p class="text-xs font-bold text-text">Gunakan Password Kuat</p>
                            <p class="text-xs text-text-muted">Minimal 8 karakter dengan huruf, angka, dan simbol</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Form --}}
            <div class="w-full md:w-1/2 bg-white p-8 md:p-12 flex flex-col md:justify-center justify-start">
                <div class="max-w-md mx-auto w-full">
                    <h1 class="text-2xl md:text-3xl font-bold text-text mb-2">Atur Ulang Password</h1>
                    <p class="text-text-muted text-sm mb-8">Masukkan password baru yang kuat untuk mengamankan akun Anda.</p>

                    {{-- Email Error --}}
                    @if ($errors->has('email'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Email tidak valid</p>
                                <p>{{ $errors->first('email') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Password Error --}}
                    @if ($errors->has('password'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Password tidak memenuhi syarat</p>
                                <p>{{ $errors->first('password') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('password.update', ['token' => $request->route('token')]) }}" method="POST" class="space-y-5" x-data="resetPasswordForm()">
                    @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        {{-- Email Address --}}
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Alamat Email</label>
                            <div class="input-with-icon">
                                <span class="input-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <input type="email" name="email" value="{{ $request->email }}" placeholder="contoh@email.com" class="input-field bg-gray-50 focus:bg-white @error('email') border-red-500 @enderror" required autofocus autocomplete="email">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Password Baru</label>
                            <div class="input-with-icon relative">
                                <span class="input-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••" class="input-field bg-gray-50 pr-12 focus:bg-white @error('password') border-red-500 @enderror" required autocomplete="new-password">
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

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Konfirmasi Password</label>
                            <div class="input-with-icon relative">
                                <span class="input-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" placeholder="••••••••" class="input-field bg-gray-50 pr-12 focus:bg-white @error('password_confirmation') border-red-500 @enderror" required autocomplete="new-password">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text">
                                    <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showConfirmPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg" data-hover="lift">
                            Atur Ulang Password
                        </button>

                        <div class="text-center">
                            <p class="text-sm text-text-muted">
                                Ingat password Anda? <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark">Masuk di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function resetPasswordForm() {
    return {
        showPassword: false,
        showConfirmPassword: false
    }
}
</script>
@endpush
