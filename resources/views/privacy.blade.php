@extends('layouts.app')
@section('title', 'Kebijakan Privasi — KosCheck')

@section('content')
<div class="min-h-screen bg-bg dark:bg-gray-900">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-primary to-primary-dark py-12">
        <div class="container-custom">
            <nav class="flex items-center gap-3 text-sm mb-6">
                <a href="{{ route('home') }}" class="text-white/90 hover:text-white transition-colors font-medium">Beranda</a>
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white font-semibold">Kebijakan Privasi</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold text-white">Kebijakan Privasi</h1>
            <p class="text-white/80 mt-2">Terakhir diperbarui: Juni 2026</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="container-custom py-12 max-w-3xl">
        <div class="prose prose-lg max-w-none">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 p-8 space-y-8">
                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">1. Pendahuluan</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        KosCheck ("Platform kami") menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda.
                        Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda
                        saat Anda menggunakan platform KosCheck.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">2. Informasi yang Kami Kumpulkan</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">Data Akun</h3>
                            <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                <li>Nama lengkap dan foto avatar</li>
                                <li>Alamat email dan nomor WhatsApp</li>
                                <li>Password (terenkripsi)</li>
                                <li>Role akun (Mahasiswa/Pemilik Kos)</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">Data Kos (untuk Pemilik)</h3>
                            <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                <li>Informasi properti kos (nama, alamat, harga)</li>
                                <li>Foto dan video properti</li>
                                <li>Fasilitas dan peraturan kos</li>
                                <li>Data booking dan lead</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5">
                            <h3 class="font-semibold text-text dark:text-white mb-2">Data Penggunaan</h3>
                            <ul class="text-sm text-text-muted dark:text-gray-400 space-y-1 list-disc list-inside">
                                <li>Riwayat pencarian dan filter kos</li>
                                <li>Review dan rating yang Anda berikan</li>
                                <li>Data booking dan transaksi</li>
                                <li>Log aktivitas dan preferensi</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">3. Penggunaan Data</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed mb-4">
                        Kami menggunakan data Anda untuk:
                    </p>
                    <ul class="text-text-muted dark:text-gray-400 space-y-2 list-disc list-inside">
                        <li>Menyediakan dan mengelola layanan platform KosCheck</li>
                        <li>Memperkenalkan properti kos yang relevan dengan preferensi Anda</li>
                        <li>Memfasilitasi komunikasi antara penyewa dan pemilik kos</li>
                        <li>Mengirim notifikasi terkait booking, lead, dan aktivitas akun</li>
                        <li>Meningkatkan pengalaman pengguna dan fitur platform</li>
                        <li>Memenuhi kewajiban hukum dan peraturan yang berlaku</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">4. Perlindungan Data</h2>
                    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl p-5">
                        <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                            Kami menerapkan langkah-langkah keamanan yang ketat untuk melindungi data Anda, termasuk:
                        </p>
                        <ul class="text-text-muted dark:text-gray-400 space-y-2 mt-3 list-disc list-inside">
                            <li>Enkripsi data sensitif (password, informasi pembayaran)</li>
                            <li>Akses terbatas hanya untuk staf yang berwenang</li>
                            <li>Pemantauan sistem secara berkala untuk mendeteksi ancaman</li>
                            <li>Pencadangan data secara rutin</li>
                        </ul>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">5. Berbagi Data dengan Pihak Ketiga</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed mb-4">
                        Kami tidak menjual data pribadi Anda. Data hanya dibagikan kepada:
                    </p>
                    <ul class="text-text-muted dark:text-gray-400 space-y-2 list-disc list-inside">
                        <li><strong class="text-text dark:text-white">Pemilik Kos</strong> - Informasi kontak Anda saat Anda tertarik dengan kos mereka</li>
                        <li><strong class="text-text dark:text-white">Penyedia Layanan</strong> -Hubungi via (WhatsApp) untuk komunikasi langsung</li>
                        <li><strong class="text-text dark:text-white">Penyedia Hosting</strong> - Untuk infrastruktur teknis platform</li>
                        <li><strong class="text-text dark:text-white">Pihak Berwenang</strong> - Jika diperlukan oleh hukum</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">6. Hak Anda</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed mb-4">
                        Anda memiliki hak untuk:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="font-medium text-text dark:text-white text-sm">Akses Data</h4>
                            <p class="text-xs text-text-muted dark:text-gray-400 mt-1">Minta salinan data pribadi Anda</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="font-medium text-text dark:text-white text-sm">Koreksi Data</h4>
                            <p class="text-xs text-text-muted dark:text-gray-400 mt-1">Perbaiki informasi yang tidak akurat</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="font-medium text-text dark:text-white text-sm">Hapus Data</h4>
                            <p class="text-xs text-text-muted dark:text-gray-400 mt-1">Minta penghapusan akun dan data</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <h4 class="font-medium text-text dark:text-white text-sm">Penolakan</h4>
                            <p class="text-xs text-text-muted dark:text-gray-400 mt-1">Tolak penggunaan data untuk marketing</p>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">7. Cookie dan Teknologi Pelacakan</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        Kami menggunakan cookie untuk mengingat preferensi Anda, menganalisis traffic website,
                        dan menyediakan fitur yang dipersonalisasi. Anda dapat mengatur browser untuk menolak cookie,
                        namun beberapa fitur platform mungkin tidak berfungsi dengan optimal.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">8. Perubahan Kebijakan</h2>
                    <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                        Kami dapat memperbarui kebijakan privasi ini sewaktu-waktu. Perubahan akan diumumkan
                        melalui email atau notifikasi di platform. Kami mendorong Anda untuk reviewing kebijakan ini
                        secara berkala.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-text dark:text-white mb-4">9. Hubungi Kami</h2>
                    <div class="bg-primary/5 dark:bg-primary/20 rounded-xl p-5 border-l-4 border-primary">
                        <p class="text-text-muted dark:text-gray-400 leading-relaxed">
                            Jika Anda memiliki pertanyaan tentang kebijakan privasi ini atau ingin menggunakan hak Anda,
                            silakan hubungi kami:
                        </p>
                        <div class="mt-4 space-y-2 text-sm">
                            <p><strong class="text-text dark:text-white">Email:</strong> <span class="text-text-muted dark:text-gray-400">privacy@koscheck.com</span></p>
                            <p><strong class="text-text dark:text-white">WhatsApp:</strong> <span class="text-text-muted dark:text-gray-400">+62 812-3456-7890</span></p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
