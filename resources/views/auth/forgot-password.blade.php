@extends('layouts.app')
@section('title', 'Lupa Password — KosCheck')

@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-5xl">
        <div class="card card-elevated overflow-hidden flex flex-col md:flex-row min-h-[600px] border-none" data-hover="lift">

            {{-- Left Side - Illustration --}}
            <div class="w-full md:w-1/2 bg-gradient-to-br from-blue-50 to-cyan-100 p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="#0E7490" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    {{-- Password Icon Animation --}}
                    <div class="w-32 h-32 mx-auto mb-8 relative">
                        <div class="absolute inset-0 bg-cyan-200 rounded-full animate-pulse opacity-25"></div>
                        <div class="relative w-full h-full bg-white rounded-2xl shadow-xl flex items-center justify-center">
                            <svg class="w-16 h-16 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-text mb-3">Atur Ulang Password</h2>
                    <p class="text-text-muted text-sm max-w-[280px] mx-auto leading-relaxed">
                        Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password Anda.
                    </p>
                </div>

                {{-- Security Badge --}}
                <div class="relative z-10 mt-8 max-w-xs w-full">
                    <div class="rounded-2xl bg-white/90 p-4 shadow-sm border border-white flex items-start gap-3">
                        <svg class="w-5 h-5 text-cyan-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-left">
                            <p class="text-xs font-bold text-text">Keamanan Terjamin</p>
                            <p class="text-xs text-text-muted">Link reset hanya berlaku 60 menit</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Form --}}
            <div class="w-full md:w-1/2 bg-white p-8 md:p-12 flex flex-col md:justify-center justify-start">
                <div class="max-w-md mx-auto w-full">
                    <h1 class="text-2xl md:text-3xl font-bold text-text mb-2">Lupa Password?</h1>
                    <p class="text-text-muted text-sm mb-8">Tidak masalah. Kami akan mengirimkan instruksi pemulihan ke email Anda.</p>

                    {{-- Success Message --}}
                    @if (session('status'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Berhasil!</p>
                                <p>{{ session('status') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Email Error --}}
                    @if ($errors->has('email'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Kesalahan</p>
                                <p>{{ $errors->first('email') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Alamat Email</label>
                            <div class="input-with-icon">
                                <span class="input-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="input-field bg-gray-50 focus:bg-white @error('email') border-red-500 @enderror" required autofocus>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg" data-hover="lift">
                            Kirim Link Reset
                        </button>

                        <div class="text-center">
                            <p class="text-sm text-text-muted">
                                Ingat password Anda? <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark">Masuk di sini</a>
                            </p>
                        </div>
                    </form>

                    {{-- Alternative Help --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-800 border border-blue-100">
                            <p class="font-semibold mb-2">Perlu bantuan lainnya?</p>
                            <p class="text-xs leading-relaxed">Jika Anda tidak menerima email dalam beberapa menit, periksa folder spam atau hubungi support kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
