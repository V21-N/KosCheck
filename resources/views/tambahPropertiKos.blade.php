@extends('layouts.owner')

@php
    $isEditMode = request()->routeIs('dashboard.kos.edit');
    if (!isset($kos)) {
        $kos = null;
    }
@endphp

@section('title', ($isEditMode ? 'Edit Properti' : 'Tambah Properti') . ' — KosCheck Manager')

@section('topbar_left')
    <h1 class="text-2xl font-bold text-text">{{ $isEditMode ? 'Edit Properti' : 'Tambah Properti' }}</h1>
@endsection

@section('content')
<div class="max-w-6xl mx-auto" x-data="{ jenis: null }">

    {{-- ==================== PILIHAN JENIS PROPERTI ==================== --}}
    @if(!$isEditMode)
    <div x-show="jenis === null" class="mb-10" data-reveal>
        <h2 class="text-2xl font-bold text-text mb-2">Pilih Jenis Properti</h2>
        <p class="text-text-muted mb-8">Silakan pilih jenis properti yang ingin kamu tambahkan.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Pilihan Kos --}}
            <button type="button" @click="jenis = 'kos'"
                    class="group p-8 border-2 border-border-light hover:border-primary rounded-2xl text-left transition-all hover:shadow-lg bg-white">
                <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center mb-5 group-hover:bg-primary/20 transition-colors">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1v-5m-2.5-2.5L15 12m-5 5l-5-5"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-text mb-2">Properti Kos</h3>
                <p class="text-sm text-text-muted">Kos, kontrakan, atau rumah kos untuk mahasiswa.</p>
            </button>

            {{-- Pilihan Galon --}}
            <button type="button" disabled
                    class="group relative p-8 border-2 border-border-light rounded-2xl text-left transition-all bg-gray-50 opacity-75 cursor-not-allowed overflow-hidden">
                <div class="absolute top-4 right-4">
                    <span class="text-[10px] font-bold tracking-widest uppercase px-3 py-1 bg-blue-100 text-blue-700 rounded-full">Coming Soon</span>
                </div>
                <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Partner Lainnya</h3>
                <p class="text-sm text-gray-500">Tahap pengembangan selanjutnya.</p>
            </button>
        </div>
    </div>
    @endif

    {{-- ==================== FORM PROPERTI KOS (SUPER CREATIVE & LENGKAP) ==================== --}}
    <div x-show="jenis === 'kos' || {{ $isEditMode ? 'true' : 'false' }}" x-data="kosFormData()" x-init="init()">
        @if(!$isEditMode)
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Form Properti Kos</h2>
                <button type="button" @click="jenis = null" class="text-sm text-text-muted hover:text-text">← Kembali Pilih</button>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            
            {{-- FORM UTAMA --}}
            <div class="xl:col-span-7 space-y-8">
                <form method="POST" action="{{ $isEditMode ? route('dashboard.kos.update', $kos) : route('dashboard.kos.store') }}" enctype="multipart/form-data" class="space-y-8" @submit.prevent="submitKos($event)">
                    @csrf
                    @if($isEditMode)
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <input type="hidden" name="gender" :value="form.gender">
                    <input type="hidden" name="whatsapp" :value="'{{ auth()->user()->phone ?? '' }}'">
                    <input type="hidden" name="total_rooms" :value="form.totalRooms">
                    <input type="hidden" name="available_rooms" :value="form.availableRooms">
                    <input type="hidden" name="room_size" :value="form.roomSize">
                    <input type="hidden" name="deposit" :value="form.deposit">
                    <input type="hidden" name="long_stay_discount" :value="form.longStayDiscount ? 1 : 0">

                    {{-- 1. FOTO & MEDIA --}}
                    <div class="bg-white rounded-2xl border border-border-light p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-sm font-bold">1</span>
                                    Foto Properti
                                </h3>
                                <p class="text-sm text-text-muted mt-1">Upload foto berkualitas tinggi. Maksimal 10 foto.</p>
                            </div>
                            <div class="text-xs px-3 py-1 bg-orange-100 text-orange-700 rounded-full font-semibold">Wajib</div>
                        </div>

                        {{-- Drag & Drop Area --}}
                        <div 
                            @click="$refs.fileInput.click()"
                            @drop.prevent="handleDrop($event)"
                            @dragover.prevent="dragOver = true"
                            @dragleave.prevent="dragOver = false"
                            :class="{ 'border-primary bg-primary/5': dragOver }"
                            class="border-2 border-dashed border-border-light hover:border-primary rounded-2xl p-10 text-center cursor-pointer transition-all group">
                            <input type="file" x-ref="fileInput" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,image/heic" class="hidden" @change="handleFileSelect($event)">
                            
                            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-orange-100 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-text">Tarik foto ke sini atau <span class="text-primary">klik untuk upload</span></p>
                            <p class="text-xs text-text-muted mt-1">Format: JPEG, PNG, JPG, GIF, WebP, HEIC • Maks 5MB per foto • Rekomendasi: 1200×800px</p>
                        </div>

                        {{-- Preview Gambar --}}
                        <div x-show="form.images.length > 0" class="mt-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-semibold text-text">Foto Terunggah (<span x-text="form.images.length"></span>/10)</span>
                                <button type="button" @click="clearAllImages" class="text-xs text-red-500 hover:text-red-600 font-medium">Hapus Semua</button>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <template x-for="(img, index) in form.images" :key="index">
                                    <div class="group relative rounded-xl overflow-hidden border border-border-light aspect-video bg-gray-100">
                                        <img :src="img.preview" class="w-full h-full object-cover">
                                        
                                        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
                                        
                                        {{-- Cover Badge --}}
                                        <div class="absolute top-2 left-2">
                                            <button type="button" 
                                                    @click="setCoverImage(index)"
                                                    class="text-[10px] px-2 py-0.5 rounded-full font-bold transition"
                                                    :class="img.isCover ? 'bg-emerald-500 text-white' : 'bg-white/90 text-text hover:bg-white'">
                                                <span x-text="img.isCover ? 'COVER' : 'Jadikan Cover'"></span>
                                            </button>
                                        </div>

                                        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <button type="button" @click="removeImage(index)" 
                                                    class="w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6h12v12"/></svg>
                                            </button>
                                        </div>

                                        <div class="absolute bottom-2 left-2 text-white text-[10px] font-medium bg-black/50 px-1.5 rounded">
                                            <span x-text="img.name"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <p class="text-[10px] text-emerald-600 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                                Foto pertama otomatis menjadi cover jika belum dipilih
                            </p>
                        </div>
                    </div>

                    {{-- 2. INFORMASI DASAR --}}
                    <div class="bg-white rounded-2xl border border-border-light p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">2</span>
                            <h3 class="text-xl font-bold">Informasi Dasar</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Nama Properti Kos <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="form.name" placeholder="Kos Mentari Indah • Medan"
                                       class="w-full px-4 py-3 border border-border-light rounded-xl focus:border-primary">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-2">Alamat Lengkap</label>
                                <textarea name="address" x-model="form.address" rows="2" placeholder="Jl. Dr. Mansyur No. 45, Medan Baru, Sumatera Utara 20154"
                                          class="w-full px-4 py-3 border border-border-light rounded-xl"></textarea>
                            </div>

                            {{-- Jenis Kos - Kreatif dengan Kartu --}}
                            <div>
                                <label class="block text-sm font-semibold mb-3">Jenis Kos <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-3 gap-3">
                                    <button type="button" @click="form.gender = 'putra'"
                                            :class="form.gender === 'putra' ? 'border-primary ring-2 ring-primary/20 bg-primary/5' : 'border-border-light hover:border-gray-300'"
                                            class="flex flex-col items-center justify-center gap-2 p-4 border rounded-2xl transition-all">
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                                        </div>
                                        <span class="font-semibold text-sm">Putra</span>
                                        <span class="text-[10px] text-text-muted">Pria / Mahasiswa</span>
                                    </button>
                                    
                                    <button type="button" @click="form.gender = 'putri'"
                                            :class="form.gender === 'putri' ? 'border-pink-500 ring-2 ring-pink-500/20 bg-pink-50' : 'border-border-light hover:border-gray-300'"
                                            class="flex flex-col items-center justify-center gap-2 p-4 border rounded-2xl transition-all">
                                        <div class="w-9 h-9 rounded-full bg-pink-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                                        </div>
                                        <span class="font-semibold text-sm">Putri</span>
                                        <span class="text-[10px] text-text-muted">Wanita / Mahasiswi</span>
                                    </button>
                                    
                                    <button type="button" @click="form.gender = 'campur'"
                                            :class="form.gender === 'campur' ? 'border-purple-500 ring-2 ring-purple-500/20 bg-purple-50' : 'border-border-light hover:border-gray-300'"
                                            class="flex flex-col items-center justify-center gap-2 p-4 border rounded-2xl transition-all">
                                        <div class="w-9 h-9 rounded-full bg-purple-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 01-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 01-2 2v1a2 2 0 01-2 2H7a2 2 0 01-2-2v-1a2 2 0 01-2-2"/></svg>
                                        </div>
                                        <span class="font-semibold text-sm">Campur</span>
                                        <span class="text-[10px] text-text-muted">Pria & Wanita</span>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold mb-2">Total Kamar</label>
                                    <input type="number" x-model="form.totalRooms" class="w-full px-4 py-3 border border-border-light rounded-xl">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-2">Kamar Tersedia</label>
                                    <input type="number" x-model="form.availableRooms" class="w-full px-4 py-3 border border-border-light rounded-xl">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-2">Luas Kamar (m²)</label>
                                    <div class="relative">
                                        <input type="number" x-model="form.roomSize" class="w-full px-4 py-3 border border-border-light rounded-xl pr-12">
                                        <span class="absolute right-4 top-3.5 text-sm text-text-muted">m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. HARGA & PAKET --}}
                    <div class="bg-white rounded-2xl border border-border-light p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">3</span>
                            <h3 class="text-xl font-bold">Harga & Paket</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Harga per Bulan</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-text-muted">Rp</span>
                                    <input type="text" name="price" x-model="form.price" class="w-full pl-10 pr-4 py-3 border border-border-light rounded-xl font-semibold text-lg">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Uang Muka / Deposit</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-text-muted">Rp</span>
                                    <input type="text" x-model="form.deposit" class="w-full pl-10 pr-4 py-3 border border-border-light rounded-xl">
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex items-center gap-3 text-sm">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="form.longStayDiscount" class="accent-primary">
                                <span>Berikan diskon 10% untuk sewa ≥ 6 bulan</span>
                            </label>
                        </div>
                    </div>

                    {{-- 4. DESKRIPSI & HIGHLIGHTS --}}
                    <div class="bg-white rounded-2xl border border-border-light p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center text-sm font-bold">4</span>
                                <h3 class="text-xl font-bold">Deskripsi & Highlights</h3>
                            </div>
                            <button type="button" @click="generateAISuggestion" 
                                    class="text-xs flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-violet-200 hover:bg-violet-50 text-violet-600 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Saran AI
                            </button>
                        </div>

                        <textarea name="description" x-model="form.description" rows="4" placeholder="Ceritakan keunggulan kos Anda..." 
                                  class="w-full px-4 py-3 border border-border-light rounded-xl text-sm"></textarea>
                        
                        <div class="mt-3 flex flex-wrap gap-2">
                            <template x-for="tag in ['Dekat USU', 'WiFi Super Cepat', 'Parkir Luas', 'Bebas Banjir', 'Area Aman 24 Jam']" :key="tag">
                                <button type="button" @click="addHighlight(tag)"
                                        class="text-xs px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-full transition">#<span x-text="tag"></span></button>
                            </template>
                        </div>
                    </div>

                    {{-- 5. FASILITAS (PALING KREATIF) --}}
                    <div class="bg-white rounded-2xl border border-border-light p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold">5</span>
                            <h3 class="text-xl font-bold">Fasilitas & Kenyamanan</h3>
                        </div>

                        <div class="mb-4">
                            <input type="text" x-model="facilitySearch" placeholder="Cari fasilitas (AC, WiFi, Parkir...)" 
                                   class="w-full px-4 py-2 border border-border-light rounded-xl text-sm">
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            <template x-for="fas in filteredFacilities" :key="fas.id">
                                <button type="button" @click="toggleFacility(fas.id)"
                                        class="flex items-center gap-3 px-4 py-3 rounded-2xl border text-left transition-all"
                                        :class="form.facilities.includes(fas.id) ? 'border-primary bg-primary/5 ring-1 ring-primary/20' : 'border-border-light hover:border-gray-300'">
                                    <input type="checkbox" name="facilities[]" :value="fas.id" x-model="form.facilities" class="hidden">
                                    <div class="w-8 h-8 flex-shrink-0 rounded-full flex items-center justify-center"
                                         :class="form.facilities.includes(fas.id) ? 'bg-primary text-white' : 'bg-gray-100 text-text-muted'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-html="fas.icon"></svg>
                                    </div>
                                    <span class="text-sm font-medium" x-text="fas.label"></span>
                                </button>
                            </template>
                        </div>

                        <div x-show="form.facilities.length > 0" class="mt-4 text-xs text-text-muted">
                            <span x-text="form.facilities.length"></span> fasilitas dipilih
                        </div>
                    </div>

                    {{-- 6. PERATURAN & KEAMANAN --}}
                    <div class="bg-white rounded-2xl border border-border-light p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm font-bold">6</span>
                            <h3 class="text-xl font-bold">Peraturan & Keamanan</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <template x-for="rule in rulesList" :key="rule.id">
                                <label class="flex items-center gap-3 p-3 border border-border-light rounded-2xl cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" :value="rule.id" x-model="form.rules" class="accent-red-500">
                                    <span class="text-sm" x-text="rule.label"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" 
                                class="w-full sm:w-auto justify-center px-8 py-3.5 bg-primary hover:bg-primary-dark active:scale-[0.985] transition-all text-white font-bold rounded-2xl shadow-lg flex items-center gap-2">
                            <span x-text="'{{ $isEditMode ? 'Perbarui Properti' : 'Publikasikan Properti Kos' }}'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- LIVE PREVIEW PANEL (KREATIF) --}}
            <div class="xl:col-span-5 hidden xl:block">
                <div class="sticky top-6">
                    <div class="bg-white border border-border-light rounded-3xl shadow-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-5 py-3 text-white flex items-center justify-between">
                            <div class="font-bold text-sm tracking-wide">PREVIEW LISTING</div>
                            <div class="text-[10px] px-2 py-0.5 bg-white/20 rounded-full">LIVE</div>
                        </div>

                        <div class="p-5">
                            <div class="aspect-video bg-gray-100 rounded-2xl overflow-hidden relative mb-4">
                                <template x-if="form.images.length > 0">
                                    <img :src="form.images.find(i => i.isCover)?.preview || form.images[0].preview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="form.images.length === 0">
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">Belum ada foto</div>
                                </template>
                                
                                <div class="absolute top-3 left-3">
                                    <span class="badge bg-white/95 text-text text-[10px] px-2 py-0.5 shadow">Terverifikasi</span>
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span class="badge bg-emerald-500 text-white text-[10px]">Baru</span>
                                </div>
                            </div>

                            <div class="font-bold text-lg leading-tight mb-0.5" x-text="form.name || 'Nama Kos Belum Diisi'"></div>
                            
                            <div class="text-xs text-text-muted flex items-center gap-1 mb-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span x-text="form.address || 'Alamat belum diisi'"></span>
                            </div>

                            <div class="flex items-baseline gap-2 mb-4">
                                <span class="text-2xl font-extrabold text-primary" x-text="'Rp ' + (Number(form.price.toString().replace(/\\D/g, '')) || 0).toLocaleString('id-ID')"></span>
                                <span class="text-xs text-text-muted">/ bulan</span>
                            </div>

                            <div class="flex items-center gap-2 text-xs mb-4">
                                <span class="px-2.5 py-1 rounded-full font-bold" 
                                      :class="{
                                          'bg-blue-100 text-blue-700': form.gender === 'putra',
                                          'bg-pink-100 text-pink-700': form.gender === 'putri',
                                          'bg-purple-100 text-purple-700': form.gender === 'campur'
                                      }"
                                      x-text="form.gender.toUpperCase()"></span>
                                <span class="text-text-muted">•</span>
                                <span class="font-medium" x-text="form.availableRooms + ' kamar tersedia'"></span>
                            </div>

                            <div x-show="form.facilities.length > 0" class="border-t pt-4">
                                <div class="text-[10px] font-bold tracking-wider text-text-muted mb-2">FASILITAS UTAMA</div>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="fid in topFacilities" :key="fid">
                                        <span class="text-[10px] px-2 py-0.5 bg-gray-100 rounded-full text-text-muted" x-text="getFacilityLabel(fid)"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center text-[10px] text-text-muted">
                        Preview ini akan muncul di halaman pencarian kos
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== FORM PARTNER GALON ==================== --}}
    <div x-show="jenis === 'galon'">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Form Partner Galon</h2>
            <button type="button" @click="jenis = null" class="text-sm text-text-muted hover:text-text">← Kembali Pilih</button>
        </div>

        <form class="space-y-8" data-validate>
            <div class="bg-white rounded-xl border border-border-light p-8 shadow-sm">
                <h2 class="text-xl font-bold text-text mb-6">Informasi Usaha Galon</h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Nama Usaha / Brand</label>
                        <input type="text" placeholder="Contoh: GalonKu Medan" class="w-full px-4 py-3 border border-border-light rounded-lg">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Jenis Layanan Utama</label>
                            <select class="w-full px-4 py-3 border border-border-light rounded-lg">
                                <option>Isi Ulang Air Mineral</option>
                                <option>Air RO / Reverse Osmosis</option>
                                <option>Galon Baru + Isi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Area Operasional</label>
                            <select class="w-full px-4 py-3 border border-border-light rounded-lg">
                                <option>Medan Baru</option>
                                <option>Medan Tuntungan</option>
                                <option>Medan Selayang</option>
                                <option>Seluruh Medan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Kapasitas per Hari</label>
                            <input type="text" placeholder="300 galon/hari" class="w-full px-4 py-3 border border-border-light rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-text mb-2">Harga Isi Ulang (19L)</label>
                            <input type="text" placeholder="Rp 18.000" class="w-full px-4 py-3 border border-border-light rounded-lg">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-text mb-2">Nomor WhatsApp Bisnis</label>
                        <input type="tel" placeholder="081234567890" class="w-full px-4 py-3 border border-border-light rounded-lg">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                    Simpan Data Partner Galon
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function kosFormData() {
    return {
        dragOver: false,
        facilitySearch: '',
        
        form: {
            images: [],
            name: {!! json_encode(old('name', $kos->name ?? '')) !!},
            address: {!! json_encode(old('address', $kos->address ?? '')) !!},
            gender: {!! json_encode(old('gender', $kos->gender ?? 'putra')) !!},
            totalRooms: {!! json_encode(old('totalRooms', $kos->total_rooms ?? '')) !!},
            availableRooms: {!! json_encode(old('availableRooms', $kos->available_rooms ?? '')) !!},
            roomSize: {!! json_encode(old('roomSize', $kos->room_size ?? '')) !!},
            price: {!! json_encode(old('price', $kos->price ?? '')) !!},
            deposit: {!! json_encode(old('deposit', $kos->deposit ?? '')) !!},
            longStayDiscount: {{ old('longStayDiscount', $kos->long_stay_discount ?? 'false') ? 'true' : 'false' }},
            description: {!! json_encode(old('description', $kos->description ?? '')) !!},
            facilities: {!! isset($kos) ? json_encode(
                $kos->facilities->map(function($f) {
                    $slugToKey = [
                        'wifi' => 'wifi',
                        'ac' => 'ac',
                        'bathroom_in' => 'km-dalam',
                        'bed' => 'kasur',
                        'wardrobe' => 'lemari',
                        'parking_motor' => 'parkir',
                        'kitchen' => 'dapur',
                        'cctv' => 'cctv',
                        'laundry' => 'laundry',
                        'electricity_token' => 'listrik',
                        'water_supply' => 'air',
                        'security' => 'keamanan',
                        '24_hour' => '24-jam',
                    ];
                    return $slugToKey[$f->slug] ?? $f->slug;
                })->values()->all()
            ) : '[]' !!},
            rules: {!! json_encode(old('rules', $kos->rules ?? [])) !!}
        },

        init() {
            @if(isset($kos))
                let existingImages = [];
                @foreach($kos->photos->sortBy('order') as $photo)
                    existingImages.push({
                        id: {!! json_encode($photo->id) !!},
                        file: null,
                        name: {!! json_encode($photo->id) !!},
                        preview: {!! json_encode(resolve_image_url($photo->url)) !!},
                        isCover: {{ $photo->is_primary ? 'true' : 'false' }},
                    });
                @endforeach
                this.form.images = existingImages;
            @endif
        },

        // Daftar fasilitas super lengkap + ikon kreatif
        facilitiesList: [
            { id: 'wifi', label: 'WiFi Super Cepat', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M20.188 10.937l-7.09 7.09M3.75 6.75l16.5-16.5" />' },
            { id: 'ac', label: 'AC', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />' },
            { id: 'km-dalam', label: 'Kamar Mandi Dalam', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />' },
            { id: 'kasur', label: 'Kasur Springbed', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />' },
            { id: 'lemari', label: 'Lemari Pakaian', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />' },
            { id: 'parkir', label: 'Parkir Dalam', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />' },
            { id: 'dapur', label: 'Dapur Bersama', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M8 12h8M8 8h8M8 16h4" />' },
            { id: 'cctv', label: 'CCTV 24 Jam', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />' },
            { id: 'laundry', label: 'Laundry', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />' },
            { id: 'listrik', label: 'Listrik Token', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />' },
            { id: 'air', label: 'Air PAM + Galon', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2" />' },
            { id: 'keamanan', label: 'Penjaga 24 Jam', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 8.944 11.922a12.02 12.02 0 00.944.078 11.955 11.955 0 01-8.944-3.04" />' },
            { id: '24-jam', label: 'Akses 24 Jam', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />' },
        ],

        rulesList: [
            { id: 'no-pets', label: 'Tidak boleh membawa hewan peliharaan' },
            { id: 'no-loud', label: 'Dilarang gaduh setelah jam 22.00' },
            { id: 'tamu-lapor', label: 'Tamu menginap wajib lapor pengelola' },
            { id: 'jam-malaman', label: 'Pintu gerbang ditutup pukul 23.00' },
            { id: 'bersih', label: 'Wajib menjaga kebersihan area bersama' },
            { id: 'no-merokok', label: 'Dilarang merokok di dalam kamar' },
        ],

        get filteredFacilities() {
            if (!this.facilitySearch) return this.facilitiesList;
            const q = this.facilitySearch.toLowerCase();
            return this.facilitiesList.filter(f => f.label.toLowerCase().includes(q));
        },

        getFacilityLabel(id) {
            const f = this.facilitiesList.find(x => x.id === id);
            return f ? f.label : id;
        },

        // === IMAGE HANDLING (Super Kreatif) ===
        handleFileSelect(e) {
            const files = Array.from(e.target.files);
            this.addImages(files);
            e.target.value = '';
        },

        handleDrop(e) {
            this.dragOver = false;
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            this.addImages(files);
        },

        addImages(files) {
            files.forEach(file => {
                if (this.form.images.length >= 10) return;
                const reader = new FileReader();
                reader.onload = (ev) => {
                    this.form.images.push({
                        id: null, // New photos don't have ID yet
                        file,
                        name: file.name.split('.')[0].substring(0, 12),
                        preview: ev.target.result,
                        isCover: this.form.images.length === 0
                    });
                };
                reader.readAsDataURL(file);
            });
        },

        removeImage(index) {
            const wasCover = this.form.images[index].isCover;
            // If it's an existing photo (has ID), track it for deletion
            const photoId = this.form.images[index].id;
            if (photoId !== null && photoId !== undefined) {
                // Track this photo ID to be deleted on server
                if (!this.deletedPhotoIds) {
                    this.deletedPhotoIds = [];
                }
                this.deletedPhotoIds.push(photoId);
            }
            this.form.images.splice(index, 1);
            if (wasCover && this.form.images.length > 0) {
                this.form.images[0].isCover = true;
            }
        },

        setCoverImage(index) {
            this.form.images.forEach((img, i) => img.isCover = i === index);
        },

        clearAllImages() {
            // Track all existing photos for deletion
            this.form.images.forEach(img => {
                if (img.id !== null && img.id !== undefined) {
                    if (!this.deletedPhotoIds) {
                        this.deletedPhotoIds = [];
                    }
                    this.deletedPhotoIds.push(img.id);
                }
            });
            this.form.images = [];
        },

        // === FASILITAS & RULES ===
        get topFacilities() {
            return this.form.facilities.slice(0, 5);
        },

        toggleFacility(id) {
            if (this.form.facilities.includes(id)) {
                this.form.facilities = this.form.facilities.filter(fid => fid !== id);
            } else {
                this.form.facilities = [...this.form.facilities, id];
            }
        },

        addHighlight(text) {
            if (!this.form.description.includes(text)) {
                this.form.description += (this.form.description ? ' • ' : '') + text;
            }
        },

        // === AI SUGGESTION (Kreatif) ===
        generateAISuggestion() {
            const suggestions = {
                putra: "Kos premium khusus putra dengan suasana tenang, WiFi kencang, dan dekat kampus USU serta banyak warung makan 24 jam.",
                putri: "Kos putri yang aman dan nyaman, dilengkapi CCTV, penjaga 24 jam, serta lingkungan yang asri dekat Universitas Sumatera Utara.",
                campur: "Kos campur modern dengan fasilitas lengkap, cocok untuk mahasiswa yang ingin fleksibel dan dekat pusat kota Medan."
            };
            this.form.description = suggestions[this.form.gender] || suggestions.putra;
            
            // Auto tambah beberapa fasilitas bagus
            const autoAdd = ['wifi', 'keamanan', 'parkir'];
            let newFacilities = [...this.form.facilities];
            autoAdd.forEach(f => {
                if (!newFacilities.includes(f)) newFacilities.push(f);
            });
            this.form.facilities = newFacilities;
        },

        // === SUBMIT ===
        async submitKos(event) {
            const form = event.target;
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                || form.querySelector('input[name="_token"]')?.value
                || '';

            // Get actual form method (supports PUT for edit mode)
            const method = form.querySelector('input[name="_method"]')?.value || form.method.toUpperCase() || 'POST';

            // Remove existing hidden rules input and re-add as proper array
            formData.delete('rules');

            // Send rules as array (rules[] = item1, rules[] = item2, etc.)
            if (this.form.rules && this.form.rules.length > 0) {
                this.form.rules.forEach((rule) => {
                    formData.append('rules[]', rule);
                });
            }

            // Send deleted photo IDs
            if (this.deletedPhotoIds && this.deletedPhotoIds.length > 0) {
                this.deletedPhotoIds.forEach((id) => {
                    formData.append('deleted_photos[]', id);
                });
            }

            // Send photo order data (for all photos - both new and existing)
            this.form.images.forEach((image, index) => {
                // Send photo ID if exists (for existing photos)
                if (image.id !== null && image.id !== undefined) {
                    formData.append('photo_order[]', image.id);
                } else {
                    // For new photos, use negative index to distinguish from existing
                    formData.append('photo_order[]', 'new_' + index);
                }
                // Send is_cover flag
                formData.append('is_cover[]', image.isCover ? '1' : '0');
            });

            // Manually set other Alpine.js values to ensure they're sent
            formData.set('gender', this.form.gender);
            formData.set('whatsapp', '{{ auth()->user()->phone ?? '' }}');
            formData.set('total_rooms', this.form.totalRooms);
            formData.set('available_rooms', this.form.availableRooms);
            formData.set('room_size', this.form.roomSize);
            formData.set('deposit', this.form.deposit);
            formData.set('long_stay_discount', this.form.longStayDiscount ? 1 : 0);

            // Append new photos only
            this.form.images.forEach((image) => {
                if (image.file) {
                    formData.append('photos[]', image.file);
                }
            });

            try {
                const response = await fetch(form.action, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    const message = data.message || Object.values(data.errors || {}).flat()[0] || 'Terjadi kesalahan. Silakan coba lagi.';
                    throw new Error(message);
                }

                window.location.href = data.redirect || '/owner/properti';
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan. Silakan coba lagi.');
            }
        }
    }
}
</script>

@endsection
