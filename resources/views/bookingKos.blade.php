@extends('layouts.mahasiswa')
@section('title', 'Formulir Booking — KosCheck')

@php
    $resolveImage = function (?string $path): string {
        $path = trim((string) $path);

        if ($path === '') {
            return asset('images/hero-illustration.png');
        }

        if (preg_match('/^(https?:|data:)/i', $path)) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $currentUser = $user ?? auth()->user();
    $owner = $owner ?? $kos->owner;
    $primaryPhoto = $kos->photos->first();
    $ownerName = $owner?->name ?? 'Pemilik Kos';
    $ownerAvatar = $owner?->avatar
        ? $resolveImage($owner->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($ownerName) . '&background=2ECC71&color=fff&size=128';
    $ownerOnline = (bool) ($owner?->is_online ?? false);
    $ownerStatusLabel = $ownerOnline ? 'Online' : 'Offline';
    $ownerStatusClass = $ownerOnline ? 'text-green-600' : 'text-gray-500';
    $price = number_format((int) ($kos->price ?? 0), 0, ',', '.');
    $address = $kos->address ?: '-';
    $genderLabel = match ($kos->gender) {
        'putra' => 'Putra',
        'putri' => 'Putri',
        default => 'Campur',
    };
    $userName = $currentUser?->name ?? session('user_name', '');
    $userUniversity = $currentUser?->university ?? session('user_institution', '');
    $userPhone = $currentUser?->phone ?? '';
@endphp

@section('topbar_left')
    <h1 class="text-xl font-bold text-text">Booking Kos</h1>
@endsection

@section('content')
<section class="bg-bg py-8 min-h-screen" data-reveal>
    <div class="container-custom max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <form class="card p-6 md:p-8" data-hover="lift" method="POST" action="{{ route('booking.store', ['slug' => $kos->slug]) }}">
                    @csrf
                    <h1 class="text-2xl font-bold text-text mb-2" data-reveal>Formulir Booking</h1>
                    <p class="text-sm text-text-muted mb-8">Lengkapi data kamu untuk mengajukan booking ke pemilik kos.</p>

                    @if(session('success'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-8">
                        <div class="flex items-center gap-2 text-text mb-6 pb-2 border-b border-border-light">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <h2 class="font-bold">Data Penyewa</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-text mb-2">Nama Lengkap</label>
                                <input type="text" value="{{ $userName }}" class="input-field bg-gray-50" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text mb-2">Nomor WhatsApp</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 border border-r-0 border-border bg-gray-50 text-text-muted text-sm rounded-l-lg">+62</span>
                                    <input type="tel" name="phone" value="{{ old('phone', ltrim(preg_replace('/\D+/', '', (string) $userPhone), '0')) }}" class="input-field rounded-l-none" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text mb-2">Jenis Kelamin</label>
                                <select name="gender" class="input-field appearance-none bg-no-repeat bg-[right_1rem_center]" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text mb-2">Asal Universitas</label>
                                <input type="text" name="university" value="{{ old('university', $userUniversity) }}" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text mb-2">Tanggal Masuk Kos</label>
                                <input type="date" name="move_in_date" value="{{ old('move_in_date') }}" class="input-field" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text mb-2">Durasi Sewa</label>
                                <select name="duration_months" class="input-field appearance-none bg-no-repeat bg-[right_1rem_center]" required>
                                    <option value="" disabled {{ old('duration_months') ? '' : 'selected' }}>Pilih Durasi</option>
                                    <option value="1" {{ old('duration_months') == '1' ? 'selected' : '' }}>1 Bulan</option>
                                    <option value="3" {{ old('duration_months') == '3' ? 'selected' : '' }}>3 Bulan</option>
                                    <option value="6" {{ old('duration_months') == '6' ? 'selected' : '' }}>6 Bulan</option>
                                    <option value="12" {{ old('duration_months') == '12' ? 'selected' : '' }}>1 Tahun</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 text-text mb-6 pb-2 border-b border-border-light">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h2 class="font-bold">Metode Komunikasi</h2>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 mb-8 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $ownerAvatar }}" alt="{{ $ownerName }}" class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover">
                                    <div id="owner-status-dot" class="absolute bottom-0 right-0 w-3.5 h-3.5 {{ $ownerOnline ? 'bg-green-500' : 'bg-gray-400' }} border-2 border-white rounded-full"></div>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <h4 class="font-bold text-sm">{{ $ownerName }}</h4>
                                        <span class="badge badge-verified bg-green-200 text-green-800 text-[0.6rem] px-1.5 py-0.5 uppercase">Pemilik Kos</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs">
                                        <span class="text-text-muted flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $ownerOnline ? 'Respon Cepat' : 'Sedang Tidak Aktif' }}
                                        </span>
                                        <span id="owner-status-label" class="{{ $ownerStatusClass }} font-medium">{{ $ownerStatusLabel }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ $owner?->phone ? 'https://wa.me/' . preg_replace('/^0/', '62', preg_replace('/\D+/', '', $owner->phone)) : '#' }}"
                               class="btn btn-dark flex-1 py-3 text-sm {{ $owner?->phone ? '' : 'pointer-events-none opacity-60' }}"
                               data-hover="lift"
                               target="_blank"
                               rel="noopener noreferrer">
                                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                            <button type="submit" class="btn btn-primary flex-1 py-3 text-sm flex items-center justify-center gap-2" data-hover="lift">
                                <svg class="w-4 h-4 transform -rotate-45 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim Permintaan Booking
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <div class="card overflow-hidden" data-hover="lift">
                        <div class="h-40 overflow-hidden">
                            <img src="{{ $resolveImage($primaryPhoto?->url) }}" alt="{{ $kos->name }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-base">{{ $kos->name }}</h3>
                                <span class="badge badge-verified bg-green-200 text-green-800 text-[0.6rem] px-2 py-0.5">
                                    <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            </div>
                            <div class="flex items-center gap-1 mt-1 text-text-muted mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="text-xs">{{ $address }}</span>
                            </div>
                            <div class="flex items-center gap-1 text-text-muted mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs">Tipe: {{ $genderLabel }}</span>
                            </div>
                            <div class="border-t border-border pt-4 flex items-center justify-between">
                                <span class="text-sm text-text-muted">Biaya Sewa</span>
                                <p class="font-bold text-lg text-primary">Rp {{ $price }} <span class="text-xs font-normal text-text-muted">/ bln</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="card p-5 bg-red-50 border-red-100" data-hover="lift">
                        <div class="flex items-center gap-2 text-red-600 mb-3 font-bold text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Peringatan Keamanan
                        </div>
                        <ul class="text-xs text-red-800 space-y-2 list-disc list-inside">
                            <li>Jangan transfer uang muka sebelum survey langsung ke lokasi.</li>
                            <li>Pastikan alamat kos sesuai dengan titik di peta yang disediakan.</li>
                            <li>Gunakan WhatsApp resmi untuk berkomunikasi dengan pemilik kos.</li>
                        </ul>
                    </div>

                    <div class="card p-5">
                        <h3 class="font-bold text-sm mb-5">Alur Booking</h3>
                        <div class="space-y-5 relative">
                            <div class="absolute left-[0.9375rem] top-2 bottom-6 w-px bg-gray-200"></div>
                            @php
                                $steps = [
                                    'Isi Formulir' => 'Lengkapi data diri dan rencana tanggal masuk.',
                                    'Hubungi Pemilik' => 'Chat pemilik kos untuk menanyakan ketersediaan kamar.',
                                    'Lakukan Survey' => 'Datang ke lokasi untuk mengecek kondisi fisik kamar.',
                                    'Konfirmasi Pemilik' => 'Pemilik akan menyetujui permintaan booking Anda.',
                                    'Pembayaran Langsung' => 'Selesaikan pembayaran sesuai kesepakatan.'
                                ];
                                $i = 1;
                            @endphp

                            @foreach($steps as $title => $desc)
                                <div class="flex items-start gap-4 relative">
                                    <div class="step-circle {{ $i == 1 ? 'bg-primary' : 'bg-primary-dark' }}">{{ $i }}</div>
                                    <div>
                                        <h4 class="font-bold text-sm">{{ $title }}</h4>
                                        <p class="text-xs text-text-muted mt-0.5">{{ $desc }}</p>
                                    </div>
                                </div>
                                @php $i++ @endphp
                            @endforeach
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
    (function () {
        const statusUrl = @json($owner ? route('owner.presence.show', $owner) : null);

        if (!statusUrl) return;

        const statusLabel = document.getElementById('owner-status-label');
        const statusDot = document.getElementById('owner-status-dot');

        const syncStatus = (isOnline) => {
            if (statusLabel) {
                statusLabel.textContent = isOnline ? 'Online' : 'Offline';
                statusLabel.classList.toggle('text-green-600', isOnline);
                statusLabel.classList.toggle('text-gray-500', !isOnline);
            }

            if (statusDot) {
                statusDot.classList.toggle('bg-green-500', isOnline);
                statusDot.classList.toggle('bg-gray-400', !isOnline);
            }
        };

        const refreshStatus = () => {
            fetch(statusUrl, { headers: { 'Accept': 'application/json' } })
                .then((response) => response.json())
                .then((data) => syncStatus(Boolean(data && data.is_online)))
                .catch(() => {});
        };

        refreshStatus();
        setInterval(refreshStatus, 30000);
    })();
</script>
@endpush
