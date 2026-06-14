@extends('layouts.app')
@section('title', 'Pusat Bantuan — KosCheck')

@php
$faqCategories = [
    [
        'id' => 'akun',
        'title' => 'Akun & Registrasi',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
        'color' => 'bg-primary',
        'items' => [
            [
                'question' => 'Bagaimana cara daftar akun KosCheck?',
                'answer' => 'Klik tombol "Daftar" di halaman utama. Pilih tipe akun (Mahasiswa atau Pemilik Kos), isi data diri, dan verifikasi email. Proses registrasi hanya membutuhkan 1-2 menit.'
            ],
            [
                'question' => 'Saya lupa password akun saya',
                'answer' => 'Klik "Lupa Password" di halaman login. Masukkan email yang terdaftar, dan kami akan kirimkan link reset password ke inbox Anda.'
            ],
            [
                'question' => 'Bagaimana cara ubah profil dan foto avatar?',
                'answer' => 'Masuk ke menu "Profil" setelah login. Klik ikon edit pada bagian yang ingin diubah. Anda bisa mengubah nama, nomor WhatsApp, universitas, dan foto avatar.'
            ],
            [
                'question' => 'Berapa banyak kos yang bisa saya tambahkan sebagai pemilik?',
                'answer' => 'Pengguna gratis dapat menambahkan maksimal 2 properti kos. Pengguna Premium dapat menambahkan ilimit properti dengan fitur tambahan lainnya.'
            ],
        ]
    ],
    [
        'id' => 'pencarian',
        'title' => 'Pencarian & Booking',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
        'color' => 'bg-blue-500',
        'items' => [
            [
                'question' => 'Bagaimana cara mencari kos yang sesuai?',
                'answer' => 'Gunakan fitur pencarian di halaman utama atau menu "Cari Kos". Anda bisa memfilter berdasarkan: jenis kos (Putra/Putri/Campur), lokasi/area, range harga per bulan, dan fasilitas yang diinginkan seperti AC, WiFi, Kamar Mandi Dalam, dll.'
            ],
            [
                'question' => 'Apa perbedaan kos Premium dan reguler?',
                'answer' => 'Kos Premium ditampilkan diurutan teratas dalam pencarian dan memiliki badge khusus. Pemilik kos Premium juga mendapat fitur tambahan untuk mengelola properti lebih maksimal.'
            ],
            [
                'question' => 'Bagaimana cara booking kos melalui KosCheck?',
                'answer' => 'Pilih kos yang Anda minati, klik tombol "Booking Sekarang". Isi formulir booking dengan data diri dan tanggal mulai sewa. Tim KosCheck akan menghubungi pemilik kos untuk mengkonfirmasi ketersediaan.'
            ],
            [
                'question' => 'Apakah ada biaya admin untuk booking?',
                'answer' => 'KosCheck tidak memungut biaya admin dari penyewa. Semua transaksi pembayaran dilakukan langsung antara penyewa dan pemilik kos.'
            ],
            [
                'question' => 'Bagaimana cara melihat jadwal ketersediaan kamar?',
                'answer' => 'Setiap kartu kos menampilkan jumlah "Kamar Tersedia" yang diupdate secara real-time oleh pemilik. Jika menujukkan 0, berarti kamar sedang penuh.'
            ],
        ]
    ],
    [
        'id' => 'keamanan',
        'title' => 'Keamanan & Verifikasi',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'color' => 'bg-green-600',
        'items' => [
            [
                'question' => 'Bagaimana KosCheck memverifikasi kos?',
                'answer' => 'Tim kami melakukan survei fisik ke lokasi kos sebelum disetujui. Kos yang terverifikasi memiliki badge centang hijau. Namun, kami tetap menyarankan untuk melakukan visitasi langsung.'
            ],
            [
                'question' => 'Bagaimana menghindari penipuan kos?',
                'answer' => 'Jangan pernah transfer uang sebelum melihat lokasi secara langsung. Gunakan selalu jalur komunikasi resmi KosCheck. Laporkan kos mencurigakan melalui tombol "Laporkan" yang tersedia di setiap halaman kos.'
            ],
            [
                'question' => 'Apa yang harus saya lakukan jika menemukan kos penipuan?',
                'answer' => 'Klik tombol "Laporkan" di halaman detail kos. Pilih jenis laporan "Penipuan/Scam" dan jelaskan kronologi. Tim moderasi kami akan menindaklanjuti dalam 1x24 jam.'
            ],
        ]
    ],
    [
        'id' => 'pemilik',
        'title' => 'Pemilik Kos',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
        'color' => 'bg-amber-500',
        'items' => [
            [
                'question' => 'Bagaimana cara mendaftarkan kos saya?',
                'answer' => 'Daftar sebagai "Pemilik Kos", masuk ke dashboard, klik "Tambah Properti". Isi informasi kos lengkap termasuk foto, harga, dan fasilitas. Kos akan tampil setelah diverifikasi oleh tim kami.'
            ],
            [
                'question' => 'Berapa lama proses verifikasi kos?',
                'answer' => 'Proses verifikasi membutuhkan 1-3 hari kerja. Anda akan mendapat notifikasi via email dan WhatsApp setelah kos disetujui atau ditolak dengan alasan penolakan.'
            ],
            [
                'question' => 'Bagaimana cara upgrade ke Premium?',
                'answer' => 'Hubungi tim KosCheck melalui WhatsApp untuk informasi paket Premium. Paket Premium menawarkan fitur eksklusif untuk meningkatkan visibilitas dan manajemen kos Anda.'
            ],
            [
                'question' => 'Bagaimana cara mengelola booking masuk?',
                'answer' => 'Masuk ke menu "Kelola Booking" di dashboard pemilik. Anda bisa melihat daftar penyewa, status booking (pending/diterima/ditolak), dan riwayat komunikasi dengan penyewa.'
            ],
            [
                'question' => 'Apa itu Lead dan bagaimana fungsinya?',
                'answer' => 'Lead adalah data kontak mahasiswa yang tertarik dengan kos Anda. Setiap kali mahasiswa mengklik "Hubungi via WhatsApp", lead baru tercatat di dashboard Anda untuk pelacakan dan follow-up.'
            ],
        ]
    ],
    [
        'id' => 'pembayaran',
        'title' => 'Pembayaran & Transaksi',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
        'color' => 'bg-purple-500',
        'items' => [
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Pembayaran dilakukan langsung antara pemilik dan penyewa kos. KosCheck merekomendasikan transfer bank, e-wallet (OVO, Dana, GoPay), atau cash saat visitasi. Pembayaran pertama biasanya termasuk uang deposit.'
            ],
            [
                'question' => 'Bagaimana sistem deposit kos bekerja?',
                'answer' => 'Deposit adalah uang jaminan yang dibayarkan di awal sewa (biasanya 1-2 bulan sewa). Deposit akan dikembalikan saat akhir kontrak jika tidak ada kerusakan atau tunggakan.'
            ],
            [
                'question' => 'Apakah ada biaya tersembunyi?',
                'answer' => 'Tidak ada biaya tersembunyi di KosCheck. Pastikan tanyakan ke pemilik tentang biaya tambahan seperti listrik token, air, parking, atau biaya laundry yang mungkin tidak termasuk dalam harga listed.'
            ],
        ]
    ],
    [
        'id' => 'review',
        'title' => 'Review & Ulasan',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
        'color' => 'bg-rose-500',
        'items' => [
            [
                'question' => 'Bagaimana cara menulis review kos?',
                'answer' => 'Setelah Anda booking dan Check-in  (move in) di sebuah kos, menu "Tulis Review" akan tersedia di halaman detail kos atau menu mahasiswa. Berikan rating 1-5 bintang dan cerita pengalaman Anda.'
            ],
            [
                'question' => 'Bagaimana review dimoderasi?',
                'answer' => 'Semua review akan melalui proses moderasi sebelum ditampilkan. Review yang mengandung SARA, spam, atau tidak berdasarkan pengalaman nyata akan ditolak.'
            ],
            [
                'question' => 'Apakah saya bisa edit atau hapus review saya?',
                'answer' => 'Ya, masuk ke menu "Review Saya" di dashboard mahasiswa. Anda bisa mengedit atau menghapus review Anda kapan saja sebelum dimoderasi.'
            ],
        ]
    ],
];

$quickLinks = [
    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Panduan Lengkap', 'desc' => 'Baca panduan penggunaan step-by-step', 'route' => 'guide'],
    ['icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'title' => 'Kebijakan Privasi', 'desc' => 'Pelajari cara kami melindungi data Anda', 'route' => 'privacy'],
    ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Syarat & Ketentuan', 'desc' => 'Ketentuan penggunaan platform', 'route' => 'terms'],
    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Menjadi Partner', 'desc' => 'Gabung sebagai partner galon atau bisnis lokal', 'route' => null, 'disabled' => true, 'coming_soon' => true],
];
@endphp

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-green-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 py-16 md:py-24" data-reveal>
    {{-- Decorative elements --}}
    <div class="absolute top-10 left-10 w-32 h-32 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-green-500/5 dark:bg-green-500/10 rounded-full blur-3xl"></div>

    <div class="container-custom max-w-4xl mx-auto text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 dark:bg-primary/20 text-primary text-sm font-semibold rounded-full mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pusat Bantuan
        </div>

        <h1 class="text-3xl md:text-5xl font-extrabold text-text dark:text-white mb-4 leading-tight" data-reveal>
            Ada yang bisa kami<br class="hidden md:block">bantu?
        </h1>

        <p class="text-base md:text-lg text-text-muted dark:text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed" data-reveal>
            Selamat datang di pusat bantuan KosCheck. Temukan jawaban cepat atau hubungi tim kami untuk bantuan lebih lanjut.
        </p>

        {{-- Search Bar --}}
        <div class="relative max-w-2xl mx-auto" x-data="{ search: '' }">
            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-text-muted dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input
                type="text"
                x-model="search"
                placeholder="Cari pertanyaan atau topik bantuan..."
                class="w-full pl-14 pr-6 py-4 bg-white dark:bg-gray-800 border border-border-light dark:border-gray-700 rounded-2xl shadow-lg shadow-gray-100 dark:shadow-gray-900/50 focus:ring-2 focus:ring-primary/20 focus:border-primary text-text dark:text-white text-base placeholder:text-text-muted dark:placeholder:text-gray-500 transition-all"
            >
        </div>
    </div>
</section>

{{-- Quick Links --}}
<section class="bg-white dark:bg-gray-800 border-b border-border-light dark:border-gray-700 py-10">
    <div class="container-custom">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($quickLinks as $link)
                @if(isset($link['disabled']) && $link['disabled'])
                {{-- Disabled button with Coming Soon --}}
                <div class="group flex items-center gap-4 p-4 bg-gray-100 dark:bg-gray-700/50 rounded-xl transition-all border border-transparent opacity-60 cursor-not-allowed">
                    <div class="w-12 h-12 rounded-xl bg-gray-200 dark:bg-gray-600 shadow-sm flex items-center justify-center text-gray-400 dark:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/></svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-sm text-gray-500 dark:text-gray-400">{{ $link['title'] }}</h4>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $link['desc'] }}</p>
                        <span class="inline-block mt-2 text-[10px] font-bold px-3 py-1 bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 rounded-full uppercase tracking-wide">
                            <svg class="w-3 h-3 inline mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Coming Soon
                        </span>
                    </div>
                </div>
                @else
                <a href="{{ route($link['route']) }}" class="group flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 hover:bg-primary/5 dark:hover:bg-primary/20 rounded-xl transition-all border border-transparent hover:border-primary/20">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-gray-600 shadow-sm flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/></svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-semibold text-sm text-text dark:text-white group-hover:text-primary transition-colors">{{ $link['title'] }}</h4>
                        <p class="text-xs text-text-muted dark:text-gray-400 mt-0.5">{{ $link['desc'] }}</p>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- Main FAQ Content --}}
<section class="bg-bg dark:bg-gray-900 py-12 md:py-16">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-text dark:text-white mb-3">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-text-muted dark:text-gray-400 max-w-xl mx-auto">Klik pada pertanyaan untuk melihat jawabannya</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-6">
            @foreach($faqCategories as $category)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-border-light dark:border-gray-700 shadow-sm overflow-hidden" data-category="{{ $category['id'] }}">
                {{-- Category Header --}}
                <div class="flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 border-b border-border-light dark:border-gray-700">
                    <div class="w-10 h-10 rounded-xl {{ $category['color'] }} text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $category['icon'] !!}</svg>
                    </div>
                    <h3 class="text-lg font-bold text-text dark:text-white">{{ $category['title'] }}</h3>
                </div>

                {{-- FAQ Items --}}
                <div class="divide-y divide-border-light dark:divide-gray-700">
                    @foreach($category['items'] as $index => $item)
                    <div x-data="{ open: false }" class="faq-item">
                        <button
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                        >
                            <span class="font-medium text-sm text-text dark:text-white pr-4">{{ $item['question'] }}</span>
                            <svg
                                class="w-5 h-5 text-text-muted dark:text-gray-400 flex-shrink-0 transition-all duration-300"
                                :class="open ? 'rotate-180 text-primary' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-collapse
                            x-cloak
                            class="overflow-hidden"
                        >
                            <div class="px-6 pb-5 pt-2">
                                <div class="bg-primary/5 dark:bg-primary/20 rounded-xl p-4 border-l-4 border-primary">
                                    <p class="text-sm text-text-muted dark:text-gray-300 leading-relaxed">{{ $item['answer'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Tips Section --}}
<section class="bg-white dark:bg-gray-800 py-12 md:py-16 border-t border-border-light dark:border-gray-700">
    <div class="container-custom">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-text dark:text-white mb-2">Tips Penting</h2>
            <p class="text-text-muted dark:text-gray-400">Beberapa hal yang perlu diperhatikan saat menggunakan KosCheck</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-2xl border border-green-100 dark:border-green-800">
                <div class="w-16 h-16 bg-green-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-text dark:text-white mb-2">Visitasi Langsung</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Selalu lakukan visitasi ke lokasi kos sebelum memutuskan untuk booking.</p>
            </div>

            <div class="text-center p-6 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 rounded-2xl border border-amber-100 dark:border-amber-800">
                <div class="w-16 h-16 bg-amber-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-bold text-text dark:text-white mb-2">Waspada Penipuan</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Jangan transfer uang sebelum bertemu pemilik secara langsung.</p>
            </div>

            <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl border border-blue-100 dark:border-blue-800">
                <div class="w-16 h-16 bg-blue-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-text dark:text-white mb-2">Baca Kontrak</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Pastikan semua aturan dan biaya tercantum jelas di kontrak sewa.</p>
            </div>
        </div>
    </div>
</section>

{{-- Still Need Help CTA --}}
<section class="bg-gradient-to-br from-primary/5 via-white to-green-50/30 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 py-16 md:py-20">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-primary/10 overflow-hidden border border-border-light dark:border-gray-700">
            {{-- Header with pattern --}}
            <div class="relative bg-gradient-to-r from-primary to-primary-dark px-8 py-10 text-center overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-4 left-8 w-20 h-20 border-2 border-white rounded-full"></div>
                    <div class="absolute bottom-4 right-12 w-32 h-32 border-2 border-white rounded-full"></div>
                    <div class="absolute top-1/2 left-1/4 w-16 h-16 border-2 border-white rounded-full"></div>
                </div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Still Need Help?</h2>
                    <p class="text-white/80 text-sm">Tim Customer Excellence kami siap membantu Anda</p>
                </div>
            </div>

            {{-- Content --}}
            <div class="px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Email Support --}}
                    <a href="mailto:support@koscheck.com" class="group flex items-start gap-4 p-5 bg-gray-50 dark:bg-gray-700 hover:bg-primary/5 dark:hover:bg-primary/20 rounded-2xl border border-gray-100 dark:border-gray-600 hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/30 text-primary flex items-center justify-center flex-shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text dark:text-white group-hover:text-primary transition-colors">Email Support</h4>
                            <p class="text-sm text-text-muted dark:text-gray-400 mt-1">support@koscheck.com</p>
                            <p class="text-xs text-text-muted dark:text-gray-500 mt-1">Respon dalam 1x24 jam</p>
                        </div>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/6281234567890?text=Halo%20KosCheck,%20saya%20butuh%20bantuan" target="_blank" class="group flex items-start gap-4 p-5 bg-green-50 dark:bg-green-900/30 hover:bg-green-100/50 dark:hover:bg-green-900/50 rounded-2xl border border-green-100 dark:border-green-800 hover:border-green-500/30 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-green-500 text-white flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-text dark:text-white group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors">WhatsApp</h4>
                            <p class="text-sm text-text-muted dark:text-gray-400 mt-1">+62 812-3456-7890</p>
                            <p class="text-xs text-text-muted dark:text-gray-500 mt-1">Senin - Minggu, 08:00 - 20:00 WIB</p>
                        </div>
                    </a>
                </div>

                {{-- Operating Hours --}}
                <div class="mt-6 p-4 bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800 rounded-xl">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Jam Operasional</p>
                            <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">
                                Tim support KosCheck beroperasi <strong>setiap hari</strong> dari pukul <strong>08:00 - 20:00 WIB</strong>.
                                Untuk pertanyaan di luar jam operasional, silakan tinggalkan pesan dan kami akan menghubungi Anda keesokan harinya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
