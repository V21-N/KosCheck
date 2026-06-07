@extends('layouts.app')
@section('title', 'Verifikasi Email — KosCheck')

@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-5xl">
        <div class="card card-elevated overflow-hidden flex flex-col md:flex-row min-h-[600px] border-none" data-hover="lift">

            {{-- Left Side - Illustration --}}
            <div class="w-full md:w-1/2 bg-gradient-to-br from-green-50 to-emerald-100 p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="#1A6B3C" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    {{-- Email Icon Animation --}}
                    <div class="w-32 h-32 mx-auto mb-8 relative">
                        <div class="absolute inset-0 bg-green-200 rounded-full animate-ping opacity-25"></div>
                        <div class="relative w-full h-full bg-white rounded-2xl shadow-xl flex items-center justify-center">
                            <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-text mb-3">Verifikasi Email Anda</h2>
                    <p class="text-text-muted text-sm max-w-[280px] mx-auto leading-relaxed">
                        Kami telah mengirimkan link verifikasi ke email Anda. Klik link tersebut untuk mengaktifkan akun.
                    </p>
                </div>

                {{-- Steps --}}
                <div class="relative z-10 mt-8 w-full max-w-xs">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-text">Cek Email</p>
                            <p class="text-xs text-text-muted">Buka kotak masuk email Anda</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-primary/80 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-text">Klik Link</p>
                            <p class="text-xs text-text-muted">Verifikasi alamat email Anda</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/60 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-text">Selesai!</p>
                            <p class="text-xs text-text-muted">Mulai gunakan akun KosCheck</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Verification Status --}}
            <div class="w-full md:w-1/2 bg-white p-8 md:p-12 flex flex-col md:justify-center justify-start" x-data="verifyEmailPage()">
                <div class="max-w-md mx-auto w-full">

                    {{-- Pending Verification State --}}
                    <template x-if="!verified">
                        <div>
                            <div class="text-center mb-8">
                                <div class="w-20 h-20 mx-auto mb-6 bg-amber-100 rounded-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v.01"/>
                                    </svg>
                                </div>
                                <h1 class="text-2xl md:text-3xl font-bold text-text mb-2">Verifikasi Email</h1>
                                <p class="text-text-muted text-sm leading-relaxed">
                                    Kami telah mengirimkan email verifikasi ke:<br>
                                    <span class="font-semibold text-text">{{ auth()->user()->email }}</span>
                                </p>
                            </div>

                            {{-- Status Messages --}}
                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Email verifikasi baru telah dikirim. Silakan cek inbox atau folder spam.</span>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            <div class="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-100">
                                <h3 class="text-sm font-bold text-text mb-3">Belum menerima email?</h3>
                                <ul class="text-xs text-text-muted space-y-2 mb-4">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-text-muted flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span>Cek folder <strong>Spam</strong> atau <strong>Promosi</strong></span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-text-muted flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span>Pastikan alamat email benar</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-text-muted flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <span>Tunggu 1-2 menit, email mungkin sedang diproses</span>
                                    </li>
                                </ul>
                            </div>

                            {{-- Resend Verification Form --}}
                            <form action="{{ route('verification.send') }}" method="POST" class="mb-6">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-full btn-lg flex items-center justify-center gap-2" data-hover="lift">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Kirim Ulang Email Verifikasi
                                </button>
                            </form>

                            <div class="text-center">
                                <p class="text-sm text-text-muted mb-4">Ikuti langkah berikut:</p>
                                <div class="flex justify-center gap-4 text-xs">
                                    <span class="flex items-center gap-1 text-text-muted">
                                        <span class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-text font-bold">1</span>
                                        Buka email
                                    </span>
                                    <span class="text-text-muted">→</span>
                                    <span class="flex items-center gap-1 text-text-muted">
                                        <span class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-text font-bold">2</span>
                                        Klik link
                                    </span>
                                    <span class="text-text-muted">→</span>
                                    <span class="flex items-center gap-1 text-text-muted">
                                        <span class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-text font-bold">3</span>
                                        Selesai
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Verified State --}}
                    <template x-if="verified">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center animate-bounce">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h1 class="text-2xl md:text-3xl font-bold text-text mb-2">Email Terverifikasi!</h1>
                            <p class="text-text-muted text-sm leading-relaxed mb-8">
                                Email Anda telah berhasil diverifikasi.<br>
                                Selamat! Sekarang Anda bisa menikmati semua fitur KosCheck.
                            </p>
                            <a href="{{ route(auth()->user()->role === 'owner' ? 'owner.dashboard' : (auth()->user()->role === 'admin' ? 'admin' : 'student.dashboard')) }}"
                               class="btn btn-primary btn-lg">
                                Lanjutkan ke Dashboard
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </template>

                    {{-- Logout Option --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-xs text-text-muted text-center">
                            Bukan {{ auth()->user()->name }}?
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="font-semibold text-primary hover:text-primary-dark transition-colors ml-1">
                                    Keluar dan login ulang
                                </button>
                            </form>
                        </p>
                    </div>

                    {{-- Trust Badge --}}
                    <div class="mt-6 bg-green-50 rounded-xl p-4 flex items-start gap-3 border border-green-100">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <div>
                            <p class="text-xs text-green-800 leading-relaxed font-medium">Email verifikasi hanya berlaku selama 60 menit untuk keamanan akun Anda.</p>
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
function verifyEmailPage() {
    return {
        verified: {{ auth()->user()?->hasVerifiedEmail() ? 'true' : 'false' }}
    }
}
</script>
@endpush