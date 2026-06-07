@extends('layouts.mahasiswa')
@section('title', 'Profil Pengguna — KosCheck')

@section('topbar_left')
    <h1 class="text-xl font-bold text-text">Profil Saya</h1>
@endsection

@section('content')
@php($currentUser = auth()->user())
<section class="bg-bg py-8 md:py-12 min-h-[calc(100vh-140px)]" x-data="profilePage()">
    @include('components.mobile-review')

    <div class="container-custom max-w-5xl">
        
        {{-- Top Section: Profile Info --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 scroll-animate-container">

            {{-- Main User Card --}}
            <div class="md:col-span-2 card p-6 md:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 border-none shadow-sm" data-hover="lift" data-reveal>
                <div class="relative flex-shrink-0">
                    <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-md bg-gray-200">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($currentUser?->name ?? 'Mahasiswa') }}&background=3B82F6&color=fff&size=112" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center text-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-2">
                        <h1 class="text-2xl font-bold text-text">{{ $currentUser?->name ?? 'Mahasiswa' }}</h1>
                        <span class="badge badge-verified bg-green-400 text-white text-[0.65rem] px-2 py-0.5 mx-auto sm:mx-0 shadow-sm border border-green-500 w-max">Mahasiswa Terverifikasi</span>
                    </div>
                    <div class="space-y-2 mt-4 text-sm text-text-muted">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                            {{ $currentUser?->university ?? 'Universitas' }}
                        </div>
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $currentUser?->email ?? '' }}
                        </div>
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $currentUser?->phone ?? '-' }}
                        </div>
                    </div>
                    <div class="flex items-center justify-center sm:justify-start gap-3 mt-6">
                        <button @click="openEditModal()" class="btn btn-primary-outline btn-sm px-6" data-hover="lift">Edit Profil</button>
                        <button onclick="event.preventDefault(); localStorage.removeItem('kc_role'); window.location.href='{{ route('logout.get') }}'" 
                                class="text-sm font-semibold text-red-500 hover:text-red-600 flex items-center gap-1 transition-colors px-4 py-2" data-hover="lift">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar
                        </button>
                    </div>
                </div>
            </div>

            {{-- Security Info Card --}}
            <div class="card p-6 border-none shadow-sm flex flex-col justify-between" data-hover="lift" data-reveal>
                <h3 class="font-bold text-sm flex items-center gap-2 mb-4 text-text">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Keamanan Akun
                </h3>
                <div class="space-y-4 flex-1">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 text-green-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-text">Password terenkripsi</p>
                            <p class="text-[0.65rem] text-text-muted mt-0.5">Terakhir diubah 3 bulan lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.612.638l4.717-1.394A11.955 11.955 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.287 0-4.408-.703-6.164-1.902l-.436-.3-2.825.835.87-2.727-.327-.47A9.955 9.955 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-text">WhatsApp terverifikasi</p>
                            <p class="text-[0.65rem] text-text-muted mt-0.5">Dihubungkan ke +62 812***</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Booking --}}
        <div class="mb-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-text">Riwayat Booking</h2>
                <a href="/mahasiswa/booking" class="text-xs font-semibold text-green-600 hover:text-green-700">Lihat Semua</a>
            </div>
            
            <div class="card p-3 border border-border flex flex-col sm:flex-row items-center gap-4 hover:border-primary/40 transition-colors shadow-sm bg-white" data-hover="lift" data-reveal>
                <div class="w-full sm:w-40 h-28 rounded-lg overflow-hidden flex-shrink-0 relative">
                    <img src="{{ asset('images/kos-bedroom.png') }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 w-full py-1 pr-2">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-base text-text">Kos Skyline Student</h3>
                        <span class="badge bg-green-400 text-white text-[0.65rem] px-2.5 py-0.5 rounded-full shadow-sm shadow-green-200">Aktif</span>
                    </div>
                    <div class="flex items-center gap-1 text-text-muted text-xs mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        Beji, Depok
                    </div>
                    <div class="flex items-center justify-between border-t border-border-light pt-3 mt-auto">
                        <p class="text-xs text-text-muted">Booking: <span class="font-bold text-text">12 Okt 2025</span></p>
                        <a href="/mahasiswa/booking" class="text-xs font-semibold text-primary flex items-center gap-1 hover:text-primary-dark transition-colors">Lihat Detail <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kos Favorit --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-text">Kos Favorit</h2>
                <a href="/kos" class="text-xs font-semibold text-green-600 hover:text-green-700">Kelola Favorit</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="card group shadow-sm bg-white" data-hover="lift" data-reveal>
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset('images/kos-bedroom.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <span class="absolute bottom-3 left-3 badge badge-verified text-[0.65rem] bg-green-700 text-white border border-green-800">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Terverifikasi
                        </span>
                        <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white flex items-center justify-center text-red-500 shadow-md">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-sm">Kos Ceria Putri UI</h3>
                        <p class="text-xs text-text-muted mt-1 mb-4">Kukusan, Depok</p>
                        <div class="flex items-end justify-between">
                            <p class="font-extrabold text-primary text-base">Rp 1.800.000<span class="text-[0.65rem] font-normal text-text-muted">/bln</span></p>
                            <a href="/kos" class="text-xs font-semibold text-green-600">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="card group shadow-sm bg-white" data-hover="lift" data-reveal>
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="{{ asset('images/kos-kitchen.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <span class="absolute bottom-3 left-3 badge badge-verified text-[0.65rem] bg-green-700 text-white border border-green-800">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Terverifikasi
                        </span>
                        <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white flex items-center justify-center text-red-500 shadow-md">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-sm">Griya Studio Premium</h3>
                        <p class="text-xs text-text-muted mt-1 mb-4">Margonda, Depok</p>
                        <div class="flex items-end justify-between">
                            <p class="font-extrabold text-primary text-base">Rp 2.500.000<span class="text-[0.65rem] font-normal text-text-muted">/bln</span></p>
                            <a href="/kos" class="text-xs font-semibold text-green-600">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="card border-2 border-dashed border-border-light bg-transparent hover:bg-white hover:border-primary/40 transition-colors flex flex-col items-center justify-center p-6 text-center min-h-[260px] shadow-none" data-hover="lift" data-reveal>
                    <div class="w-12 h-12 rounded-full bg-orange-100 text-primary flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <h3 class="font-bold text-sm mb-2">Cari Kos Lainnya</h3>
                    <p class="text-xs text-text-muted mb-6">Temukan lebih banyak pilihan kos impianmu di sekitar kampus.</p>
                    <a href="{{ route('kos.index') }}" class="btn btn-primary btn-sm px-6" data-hover="lift">Explore Sekarang</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Profile Modal -->
    <div x-show="showEditModal" x-transition class="fixed inset-0 bg-black/60 flex items-center justify-center z-[999]" @click="showEditModal = false">
        <div @click.stop class="bg-white rounded-3xl w-full max-w-md mx-4 p-7 shadow-2xl" x-transition>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">Edit Profil</h3>
                <button @click="showEditModal = false" class="text-2xl text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" x-model="editForm.nama" class="w-full px-4 py-2.5 border border-border-light rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Email</label>
                    <input type="email" x-model="editForm.email" class="w-full px-4 py-2.5 border border-border-light rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Nomor WhatsApp</label>
                    <input type="tel" x-model="editForm.phone" class="w-full px-4 py-2.5 border border-border-light rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Universitas</label>
                    <input type="text" x-model="editForm.universitas" class="w-full px-4 py-2.5 border border-border-light rounded-xl text-sm">
                </div>
            </div>

            <div class="flex gap-3 mt-7">
                <button @click="showEditModal = false" class="flex-1 py-2.5 border border-border-light rounded-2xl font-semibold text-sm">Batal</button>
                <button @click="saveProfile()" class="flex-1 py-2.5 bg-primary text-white font-semibold rounded-2xl text-sm">Simpan Perubahan</button>
            </div>
        </div>
    </div>

</section>

<script>
function profilePage() {
    return {
        showEditModal: false,
        editForm: {
            nama: @json($currentUser?->name ?? 'Mahasiswa'),
            email: @json($currentUser?->email ?? ''),
            phone: @json($currentUser?->phone ?? ''),
            universitas: @json($currentUser?->university ?? '')
        },

        openEditModal() {
            this.editForm = {
                nama: @json($currentUser?->name ?? 'Mahasiswa'),
                email: @json($currentUser?->email ?? ''),
                phone: @json($currentUser?->phone ?? ''),
                universitas: @json($currentUser?->university ?? '')
            };
            this.showEditModal = true;
        },

        saveProfile() {
            const nameEl = document.querySelector('h1.text-2xl.font-bold');
            if (nameEl) nameEl.textContent = this.editForm.nama;

            const infoItems = document.querySelectorAll('.space-y-2.mt-4.text-sm.text-text-muted > div');
            if (infoItems.length >= 3) {
                infoItems[0].innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg> ${this.editForm.universitas}`;
                infoItems[1].innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> ${this.editForm.email}`;
                infoItems[2].innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> ${this.editForm.phone}`;
            }

            this.showEditModal = false;

            const toast = document.createElement('div');
            toast.className = 'fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-xl text-sm z-[9999]';
            toast.textContent = 'Profil berhasil diperbarui!';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }
    }
}
</script>
@endsection
