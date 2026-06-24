@extends('layouts.app')
@section('title', 'Pilih Peran - KosCheck')

@section('custom_footer')
    <x-auth-footer />
@endsection

@section('content')
<section class="bg-bg min-h-[calc(100vh-160px)] flex items-center py-8">
    <div class="container-custom w-full max-w-2xl">
        <div class="card card-elevated overflow-hidden border-none">
            {{-- Header with gradient --}}
            <div class="bg-gradient-to-br from-[#fff8ef] via-[#fff1e5] to-[#fdf5ed] p-8 text-center">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-white shadow-lg flex items-center justify-center overflow-hidden">
                    @if(session('oauth_pending') && session('oauth_pending')['avatar'])
                        <img src="{{ session('oauth_pending')['avatar'] }}"
                             alt="Avatar"
                             class="w-full h-full object-cover">
                    @else
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    @endif
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-text">Pilih Peran Anda</h1>
                <p class="mt-2 text-text-muted text-sm">
                    @if(session('oauth_pending') && session('oauth_pending')['email'])
                        Login sebagai <strong>{{ session('oauth_pending')['email'] }}</strong>
                    @endif
                </p>
                <p class="mt-1 text-text-muted text-xs">
                    Silakan pilih peran yang sesuai dengan kebutuhan Anda di KosCheck.
                </p>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
            <div class="mx-8 mt-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-8 mt-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
            @endif

            {{-- Role Selection Cards --}}
            <div class="p-8">
                <form action="{{ route('auth.google.select-role') }}" method="POST" x-data="roleSelection()">
                    @csrf

                    <div class="space-y-4">
                        {{-- Mahasiswa Option --}}
                        <label class="block cursor-pointer">
                            <input type="radio" name="role" value="mahasiswa" x-model="selectedRole" class="sr-only peer">
                            <div class="relative p-6 rounded-2xl border-2 transition-all duration-200
                                        peer-checked:border-primary peer-checked:bg-primary/5
                                        peer-checked:shadow-md
                                        hover:border-primary/50 hover:bg-gray-50
                                        border-border bg-white">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-bold text-text">Mahasiswa</h3>
                                            <div class="peer-checked:opacity-100 opacity-0 transition-opacity">
                                                <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-text-muted leading-relaxed">
                                            Cari kos berdasarkan lokasi kampus, simpan favorit, dan tulis review jujur untuk membantu sesama mahasiswa.
                                        </p>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                                Cari Kos
                                            </span>
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                                Simpan Favorit
                                            </span>
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                                Tulis Review
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>

                        {{-- Owner Option --}}
                        <label class="block cursor-pointer">
                            <input type="radio" name="role" value="owner" x-model="selectedRole" class="sr-only peer">
                            <div class="relative p-6 rounded-2xl border-2 transition-all duration-200
                                        peer-checked:border-primary peer-checked:bg-primary/5
                                        peer-checked:shadow-md
                                        hover:border-primary/50 hover:bg-gray-50
                                        border-border bg-white">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-bold text-text">Pemilik Kos / Partner</h3>
                                            <div class="peer-checked:opacity-100 opacity-0 transition-opacity">
                                                <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-text-muted leading-relaxed">
                                            Kelola listing kos atau layanan galon, terima leads dari calon penyewa, dan lihat statistik properti Anda.
                                        </p>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Kelola Listing
                                            </span>
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                                Lihat Leads
                                            </span>
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                                Statistik
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    @error('role')
                        <p class="mt-4 text-sm text-red-600 text-center">{{ $message }}</p>
                    @enderror

                    <div class="mt-6">
                        <button type="submit"
                                :disabled="!selectedRole"
                                :class="selectedRole ? 'btn btn-primary btn-full btn-lg' : 'btn btn-full btn-lg bg-gray-300 cursor-not-allowed'"
                                class="transition-all"
                                data-hover="lift">
                            Lanjutkan
                        </button>
                    </div>

                    <p class="mt-4 text-center text-xs text-text-muted">
                        Anda dapat mengubah peran di pengaturan akun nanti.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function roleSelection() {
    return {
        selectedRole: '',
    }
}
</script>
@endpush
