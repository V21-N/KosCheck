@extends('layouts.app')
@section('title', 'Panduan Lengkap — KosCheck')

@section('content')
<div class="min-h-screen bg-bg dark:bg-gray-900">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-primary to-primary-dark py-12">
        <div class="container-custom">
            <nav class="flex items-center gap-3 text-sm mb-6">
                <a href="{{ route('home') }}" class="text-white/90 hover:text-white transition-colors font-medium">Beranda</a>
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('bantuan') }}" class="text-white/90 hover:text-white transition-colors font-medium">Bantuan</a>
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white font-semibold">Panduan Lengkap</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold text-white">Panduan Lengkap KosCheck</h1>
            <p class="text-white/80 mt-2">Step-by-step panduan penggunaan platform</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="container-custom py-12 max-w-4xl">
        {{-- Quick Navigation --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6 mb-8">
            <h2 class="text-lg font-bold text-text dark:text-white mb-4">Navigasi Cepat</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="#mahasiswa" class="flex items-center gap-2 p-3 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Mahasiswa</span>
                </a>
                <a href="#pemilik" class="flex items-center gap-2 p-3 bg-amber-50 dark:bg-amber-900/30 hover:bg-amber-100 dark:hover:bg-amber-900/50 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span class="text-sm font-medium text-amber-700 dark:text-amber-300">Pemilik Kos</span>
                </a>
                <a href="#pencarian" class="flex items-center gap-2 p-3 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="text-sm font-medium text-green-700 dark:text-green-300">Pencarian</span>
                </a>
                <a href="#booking" class="flex items-center gap-2 p-3 bg-purple-50 dark:bg-purple-900/30 hover:bg-purple-100 dark:hover:bg-purple-900/50 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Booking</span>
                </a>
            </div>
        </div>

        {{-- Guide for Mahasiswa --}}
        <section id="mahasiswa" class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-blue-500 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-text dark:text-white">Panduan untuk Mahasiswa</h2>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Daftar Akun</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Buat akun KosCheck dengan memilih tipe "Mahasiswa"</p>
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Langkah:</strong></p>
                                <ol class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-decimal list-inside">
                                    <li>Kunjungi halaman utama KosCheck</li>
                                    <li>Klik tombol "Daftar"</li>
                                    <li>Pilih tipe akun "Mahasiswa"</li>
                                    <li>Isi nama, email, password</li>
                                    <li>Verifikasi email Anda</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Cari Kos</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Gunakan filter untuk menemukan kos yang sesuai</p>
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Filter yang tersedia:</strong></p>
                                <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                    <li><strong>Jenis Kos:</strong> Putra, Putri, atau Campur</li>
                                    <li><strong>Lokasi:</strong> Area atau alamat</li>
                                    <li><strong>Harga:</strong> Range harga per bulan</li>
                                    <li><strong>Fasilitas:</strong> AC, WiFi, Kamar Mandi Dalam, dll</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Lihat Detail & Hubungi</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Review detail kos dan hubungi pemilik via WhatsApp</p>
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Yang bisa Anda lihat:</strong></p>
                                <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                    <li>Galeri foto kos</li>
                                    <li>Daftar fasilitas</li>
                                    <li>Harga dan ketersediaan kamar</li>
                                    <li>Review dari mahasiswa lain</li>
                                    <li>Rating dan lokasi di peta</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Booking Kos</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Kirim request booking ke pemilik kos</p>
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Langkah:</strong></p>
                                <ol class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-decimal list-inside">
                                    <li>Klik tombol "Booking Sekarang"</li>
                                    <li>Isi formulir booking</li>
                                    <li>Pilih tanggal mulai sewa</li>
                                    <li>Submit dan tunggu konfirmasi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold flex-shrink-0">5</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Tulis Review</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Bagikan pengalaman Anda tinggal di kos</p>
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Setelah入住, Anda bisa:</strong></p>
                                <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                    <li>Memberikan rating 1-5 bintang</li>
                                    <li>Menulis pengalaman tinggal di kos</li>
                                    <li>Membantu mahasiswa lain dalam keputusan mereka</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Guide for Pemilik --}}
        <section id="pemilik" class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-text dark:text-white">Panduan untuk Pemilik Kos</h2>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-300 flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Daftar & Setup Dashboard</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Buat akun Pemilik Kos dan akses dashboard</p>
                            <div class="bg-amber-50 dark:bg-amber-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Langkah:</strong></p>
                                <ol class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-decimal list-inside">
                                    <li>Daftar dengan tipe "Pemilik Kos"</li>
                                    <li>Lengkapi profil dan kontak WhatsApp</li>
                                    <li>Akses dashboard dari menu</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-300 flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Tambah Properti Kos</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Daftarkan kos Anda dengan informasi lengkap</p>
                            <div class="bg-amber-50 dark:bg-amber-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Data yang perlu diisi:</strong></p>
                                <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                    <li>Foto properti (maksimal 10 foto)</li>
                                    <li>Nama dan alamat lengkap kos</li>
                                    <li>Jenis kos (Putra/Putri/Campur)</li>
                                    <li>Harga per bulan dan deposit</li>
                                    <li>Daftar fasilitas yang tersedia</li>
                                    <li>Peraturan kos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-300 flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Proses Verifikasi</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Kos Anda akan diverifikasi oleh tim KosCheck</p>
                            <div class="bg-amber-50 dark:bg-amber-900/30 rounded-xl p-4">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold">1</div>
                                    <span class="text-sm text-text dark:text-gray-300">Submit kos untuk verifikasi</span>
                                </div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold">2</div>
                                    <span class="text-sm text-text dark:text-gray-300">Tim kami melakukan survei</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-bold">3</div>
                                    <span class="text-sm text-text dark:text-gray-300">Kos disetujui & tampil di pencarian</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-300 flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Kelola Booking & Lead</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Monitor dan respons booking masuk</p>
                            <div class="bg-amber-50 dark:bg-amber-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Di dashboard Anda bisa:</strong></p>
                                <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                    <li>Melihat daftar booking masuk</li>
                                    <li>Konfirmasi atau tolak booking</li>
                                    <li>Melihat data lead (minat mahasiswa)</li>
                                    <li>Mengirim notifikasi ke penyewa</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-300 flex items-center justify-center font-bold flex-shrink-0">5</div>
                        <div>
                            <h3 class="font-bold text-text dark:text-white mb-2">Upgrade Premium</h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm mb-4">Tingkatkan visibilitas kos Anda</p>
                            <div class="bg-amber-50 dark:bg-amber-900/30 rounded-xl p-4 space-y-2">
                                <p class="text-sm text-text dark:text-gray-300"><strong>Keuntungan Premium:</strong></p>
                                <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                    <li>Kos tampil di urutan teratas</li>
                                    <li>Badge Premium di kartu kos</li>
                                    <li>Batas properti lebih banyak</li>
                                    <li>Statistik lengkap</li>
                                </ul>
                                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20paket%20Premium%20KosCheck" target="_blank" class="inline-flex items-center gap-2 mt-3 text-sm text-primary font-medium hover:underline">
                                    Hubungi kami untuk info Premium →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tips --}}
        <section class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-2xl border border-green-200 dark:border-green-800 p-8">
            <h2 class="text-xl font-bold text-text dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                Tips Penting
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm text-text-muted dark:text-gray-400">Selalu visitasi langsung sebelum booking</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm text-text-muted dark:text-gray-400">Pastikan foto dan harga sesuai dengan kondisi</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm text-text-muted dark:text-gray-400">Baca kontrak dengan teliti sebelum menandatangani</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm text-text-muted dark:text-gray-400">Update data kos secara berkala</p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
