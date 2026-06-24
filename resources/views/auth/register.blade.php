@extends('layouts.app')
@section('title', 'Daftar Akun KosCheck')

@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-6xl">
        <div class="card card-elevated overflow-hidden flex flex-col lg:flex-row min-h-[680px] border-none">
            <div class="w-full lg:w-[42%] bg-gradient-to-br from-[#fff8ef] via-[#fff1e5] to-[#fdf5ed] p-8 md:p-10 flex flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <span class="inline-flex items-center rounded-full bg-white/80 px-3 py-1 text-xs font-bold text-primary shadow-sm">Frontend Preview</span>
                    <h1 class="mt-5 text-3xl font-extrabold leading-tight text-text">Satu akun untuk cari kos, tulis review, dan kelola listing.</h1>
                    <p class="mt-4 text-sm leading-relaxed text-text-muted max-w-sm">
                        Pilih peran yang sesuai. Mahasiswa bisa menyimpan kos favorit dan menulis ulasan, sementara pemilik partner atau galon bisa mulai mengiklankan properti atau layanan air galon.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 relative z-10 mt-8">
                    <div class="rounded-2xl bg-white/90 p-4 shadow-sm border border-white">
                        <h3 class="text-sm font-bold text-text">Untuk Mahasiswa</h3>
                        <p class="mt-2 text-xs leading-relaxed text-text-muted">Cari kos berdasarkan lokasi kampus, lihat review penghuni, dan hubungi pemilik langsung via WhatsApp.</p>
                    </div>
                    <div class="rounded-2xl bg-white/90 p-4 shadow-sm border border-white">
                        <h3 class="text-sm font-bold text-text">Untuk Pemilik Kos & Partner</h3>
                        <p class="mt-2 text-xs leading-relaxed text-text-muted">Pasang listing kos atau layanan galon, kelola kamar aktif, dan lihat lead yang masuk dari calon penyewa.</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[58%] bg-white p-8 md:p-10 lg:p-12" x-data="registerPage()">
                <div class="max-w-2xl">
                    <h2 class="text-2xl md:text-3xl font-bold text-text">Buat akun baru</h2>
                    <p class="mt-2 text-sm text-text-muted">Pilih peran yang sesuai dengan kebutuhan anda.</p>

                    {{-- Success/Error Messages --}}
                    @if(session('success'))
                    <div class="mt-6 mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
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
                    <div class="mt-6 mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Kesalahan</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Role Toggle: Only 2 options --}}
                    <div class="mt-8 flex bg-gray-100 p-1 rounded-xl">
                        <button type="button" @click="selectedRole = 'mahasiswa'" :class="selectedRole === 'mahasiswa' ? 'bg-white shadow text-primary' : 'text-text-muted hover:text-text'" class="flex-1 rounded-lg px-4 py-2.5 text-sm font-semibold transition-all">
                            Mahasiswa
                        </button>
                        <button type="button" @click="selectedRole = 'owner'" :class="selectedRole === 'owner' ? 'bg-white shadow text-primary' : 'text-text-muted hover:text-text'" class="flex-1 rounded-lg px-4 py-2.5 text-sm font-semibold transition-all">
                            Pemilik / Partner
                        </button>
                    </div>

                    <form class="mt-8 space-y-5" action="{{ route('register') }}" method="POST" data-validate>
                        @csrf
                        <input type="hidden" name="role" x-model="selectedRole">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="input-field bg-gray-50 focus:bg-white @error('name') border-red-500 @enderror" placeholder="Contoh: Budi Santoso">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="input-field bg-gray-50 focus:bg-white @error('email') border-red-500 @enderror" placeholder="contoh@kampus.ac.id">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Nomor WhatsApp</label>
                                <div class="flex">
                                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-border bg-gray-50 px-3 text-sm text-text-muted">+62</span>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" class="input-field rounded-l-none bg-gray-50 focus:bg-white @error('phone') border-red-500 @enderror" placeholder="081234567890">
                                </div>
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-show="selectedRole === 'mahasiswa'" x-cloak>
                                <label class="block text-sm font-semibold text-text mb-2">Universitas</label>
                                <input type="text" name="university" value="{{ old('university') }}" class="input-field bg-gray-50 focus:bg-white @error('university') border-red-500 @enderror" placeholder="Contoh: Universitas Sumatera Utara (USU)">
                                @error('university')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-show="selectedRole === 'owner'" x-cloak>
                                <label class="block text-sm font-semibold text-text mb-2">Nama Properti / Brand</label>
                                <input type="text" name="brand_name" value="{{ old('brand_name') }}" class="input-field bg-gray-50 focus:bg-white @error('brand_name') border-red-500 @enderror" placeholder="Contoh: Kos Mentari Residence">
                                @error('brand_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div x-show="selectedRole === 'owner'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Kota Operasional</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="input-field bg-gray-50 focus:bg-white @error('city') border-red-500 @enderror" placeholder="Contoh: Medan">
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Tipe Listing</label>
                                <select name="listing_type" class="input-field bg-gray-50 focus:bg-white @error('listing_type') border-red-500 @enderror">
                                    <option value="kos">Properti Kos</option>
                                    <option value="galon">Layanan Galon</option>
                                </select>
                                @error('listing_type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Password</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password" class="input-field bg-gray-50 pr-12 focus:bg-white @error('password') border-red-500 @enderror" placeholder="Minimal 8 karakter">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-3 text-text-muted hover:text-text">
                                        <span x-show="!showPassword">Lihat</span>
                                        <span x-show="showPassword" x-cloak>Sembunyi</span>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-text mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" class="input-field bg-gray-50 pr-16 focus:bg-white @error('password_confirmation') border-red-500 @enderror" placeholder="Ulangi password">
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-3 text-text-muted hover:text-text">
                                        <span x-show="!showConfirmPassword">Lihat</span>
                                        <span x-show="showConfirmPassword" x-cloak>Sembunyi</span>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="rounded-2xl border border-border-light bg-bg p-5">
                            <div class="flex items-start gap-3">
                                <input id="terms" type="checkbox" class="mt-1 h-4 w-4 rounded border-border text-primary accent-primary">
                                <label for="terms" class="text-sm leading-relaxed text-text-muted">
                                    Saya setuju dengan syarat penggunaan, kebijakan privasi, serta memahami bahwa KosCheck adalah platform lead generator dan komunikasi lanjutan dilakukan langsung dengan pemilik kos.
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full btn-lg" data-hover="lift">Daftar Sekarang</button>

                        {{-- Divider --}}
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-text-muted">atau</span>
                            </div>
                        </div>

                        {{-- Google OAuth Button --}}
                        <a href="{{ route('auth.google.redirect') }}"
                           class="btn btn-outline btn-full btn-lg flex items-center justify-center gap-3 border-2 hover:bg-gray-50 transition-all">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="font-semibold">Daftar dengan Google</span>
                        </a>

                        <p class="text-center text-sm text-text-muted">
                            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark">Masuk di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function registerPage() {
    return {
        selectedRole: 'mahasiswa',
        showPassword: false,
        showConfirmPassword: false
    }
}
</script>
@endpush
