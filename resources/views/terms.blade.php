@extends('layouts.app')
@section('title', 'Syarat & Ketentuan — KosCheck')

@section('content')
<div class="min-h-screen bg-bg dark:bg-gray-900">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-primary to-primary-dark py-12">
        <div class="container-custom">
            <nav class="flex items-center gap-3 text-sm mb-6">
                <a href="{{ route('home') }}" class="text-white/90 hover:text-white transition-colors font-medium">Beranda</a>
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white font-semibold">Syarat & Ketentuan</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold text-white">Syarat & Ketentuan</h1>
            <p class="text-white/80 mt-2">Terakhir diperbarui: Juni 2026</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="container-custom py-12 max-w-3xl">
        <div class="prose prose-lg max-w-none">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-8 space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">1. Penerimaan Syarat</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        Dengan mengakses dan menggunakan platform KosCheck, Anda agree untuk terikat oleh
                        Syarat & Ketentuan ini. Jika Anda tidak setuju dengan syarat ini, mohon untuk tidak
                        menggunakan platform kami.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">2. Deskripsi Layanan</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        KosCheck adalah platform digital yang menghubungkan pemilik kos dengan mahasiswa
                        yang mencari hunian. Layanan kami meliputi:
                    </p>
                    <ul class="text-text-muted dark:text-gray-400 space-y-2 mt-4 list-disc list-inside">
                        <li>Pencarian dan penayangan properti kos</li>
                        <li>Manajemen booking dan lead tracking</li>
                        <li>Sistem review dan rating</li>
                        <li>Komunikasi antara penyewa dan pemilik kos</li>
                        <li>Moderasi konten dan verifikasi properti</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">3. Akun Pengguna</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">3.1 Registrasi</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Anda harus mendaftar dengan informasi yang akurat dan lengkap. Setiap pengguna
                                hanya boleh memiliki satu akun. Anda bertanggung jawab untuk menjaga kerahasiaan
                                password akun Anda.
                            </p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">3.2 Tipe Akun</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                KosCheck menyediakan dua tipe akun: <strong class="text-text dark:text-white">Mahasiswa</strong> untuk mencari kos
                                dan <strong class="text-text dark:text-white">Pemilik Kos</strong> untuk mengelola properti. Setiap tipe akun memiliki
                                fitur dan ketentuan penggunaan yang berbeda.
                            </p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">3.3 Kewajiban Pengguna</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Anda agree untuk tidak menggunakan akun untuk tujuan ilegal, tidak memberikan
                                informasi palsu, dan tidak mengganggu pengalaman pengguna lain.
                            </p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">4. Ketentuan untuk Pemilik Kos</h2>
                    <div class="space-y-4">
                        <div class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">4.1 Pendaftaran Properti</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Pemilik kos harus memastikan semua informasi properti yang didaftarkan adalah
                                akurat dan up-to-date. Foto harus sesuai dengan kondisi sebenarnya. Kos yang
                                terverifikasi akan mendapat badge khusus.
                            </p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">4.2 Proses Verifikasi</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Semua properti kos akan melalui proses verifikasi oleh tim KosCheck dalam 1-3 hari
                                kerja. Properti yang tidak memenuhi standar atau mengandung informasi palsu akan
                                ditolak.
                            </p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">4.3 Fitur Premium</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Paket Premium menawarkan fitur tambahan seperti prioritas tampilan, statistik
                                lengkap, dan batas properti yang lebih banyak. Detail paket Premium dapat
                                dilihat di dashboard atau dikontak ke tim kami.
                            </p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">5. Ketentuan untuk Mahasiswa</h2>
                    <div class="space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">5.1 Pencarian Kos</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Anda dapat menggunakan fitur pencarian dan filter untuk menemukan kos yang sesuai.
                                KosCheck tidak menjamin ketersediaan kamar yang ditampilkan.
                            </p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">5.2 Booking</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Booking melalui KosCheck adalah langkah awal untuk menghubungi pemilik kos.
                                Transaksi pembayaran dilakukan langsung antara penyewa dan pemilik di luar platform.
                            </p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">5.3 Review</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">
                                Review harus berdasarkan pengalaman nyata. Review yang mengandung SARA, spam,
                                atau tidak sesuai fakta akan dimoderasi dan dihapus.
                            </p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">6. Larangan</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed mb-4">
                        Pengguna dilarang untuk:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="text-sm text-text-muted dark:text-gray-400">Memposting informasi kos palsu</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="text-sm text-text-muted dark:text-gray-400">Meminta transfer di luar platform</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="text-sm text-text-muted dark:text-gray-400">Menyebarkan konten SARA</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="text-sm text-text-muted dark:text-gray-400">Spam atau iklan tidak relevan</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="text-sm text-text-muted dark:text-gray-400">Mencuri konten orang lain</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="text-sm text-text-muted dark:text-gray-400">Menggunakan akun untuk penipuan</span>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">7. Pelaporan dan Moderasi</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        KosCheck menyediakan fitur pelaporan untuk melaporkan konten yang melanggar ketentuan.
                        Tim moderasi kami akan menindaklanjuti laporan dalam 1x24 jam. Pengguna yang terbukti
                        melanggar dapat dikenakan suspend akun atau penghapusan permanen.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">8. Limitasi Tanggung Jawab</h2>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                        <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                            KosCheck berfungsi sebagai platform penghubung. Kami tidak bertanggung jawab atas:
                        </p>
                        <ul class="text-text-muted dark:text-gray-400 space-y-2 mt-3 list-disc list-inside">
                            <li>Transaksi pembayaran yang dilakukan di luar platform</li>
                            <li>Kondisi fisik properti kos yang sebenarnya</li>
                            <li>Perselisihan antara penyewa dan pemilik kos</li>
                            <li>Kerugian yang timbul dari penggunaan layanan pihak ketiga</li>
                        </ul>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">9. Perubahan Syarat</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        KosCheck berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan
                        diumumkan melalui email atau notifikasi di platform. Penggunaan berkelanjutan
                        setelah perubahan berarti Anda menerima syarat yang baru.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">10. Hukum yang Berlaku</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        Syarat dan ketentuan ini diatur oleh hukum yang berlaku di Republik Indonesia.
                        Setiap perselisihan akan diselesaikan melalui jalur yang berlaku.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">11. Hubungi Kami</h2>
                    <div class="bg-primary/5 dark:bg-primary/20 rounded-xl p-5 border-l-4 border-primary">
                        <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                            Untuk pertanyaan atau laporan pelanggaran, silakan hubungi kami:
                        </p>
                        <div class="mt-4 space-y-2 text-sm">
                            <p><strong class="text-text dark:text-white">Email:</strong> <span class="text-text-muted dark:text-gray-400">legal@koscheck.com</span></p>
                            <p><strong class="text-text dark:text-white">WhatsApp:</strong> <span class="text-text-muted dark:text-gray-400">+62 812-3456-7890</span></p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
