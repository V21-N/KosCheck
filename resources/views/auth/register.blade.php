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
                                    <input type="tel" name="phone" value="{{ old('phone') }}" class="input-field rounded-l-none bg-gray-50 focus:bg-white @error('phone') border-red-500 @enderror" placeholder="81234567890">
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
