@extends('layouts.admin')
@section('title', 'Iklan Lokal — Admin Panel')

@section('topbar_left')
    <div>
        <h1 class="text-xl font-bold text-text">Iklan Lokal</h1>
        <p class="text-xs text-text-muted mt-1">Slot partner laundry, catering, internet, dan jasa sekitar kos.</p>
    </div>
@endsection

@section('topbar_right')
    <span class="badge badge-verified bg-green-100 text-green-800 border border-green-200 hidden md:inline-flex">Frontend Only</span>
@endsection

@section('content')
<div x-data="adminIklan()" class="space-y-6">
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex gap-2 flex-wrap">
            <button @click="filter='semua'" :class="filter==='semua'?'bg-primary text-white':'bg-white border'" class="btn btn-sm px-4">Semua Iklan</button>
            <button @click="filter='aktif'" :class="filter==='aktif'?'bg-emerald-600 text-white':'bg-white border'" class="btn btn-sm px-4">Aktif</button>
            <button @click="filter='kadaluarsa'" :class="filter==='kadaluarsa'?'bg-gray-700 text-white':'bg-white border'" class="btn btn-sm px-4">Kadaluarsa</button>
        </div>
        <button @click="addSlot()" class="btn btn-primary btn-sm">Tambah Slot Iklan</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        <template x-for="ad in filteredAds" :key="ad.id">
            <div class="card border-none shadow-sm p-5">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-text" x-text="ad.name"></h3>
                    <span class="rounded-full px-3 py-0.5 text-[0.65rem] font-bold" 
                          :class="ad.status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600'"
                          x-text="ad.status"></span>
                </div>
                <p class="text-sm text-text-muted" x-text="ad.placement"></p>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm font-bold text-primary" x-text="ad.price"></span>
                    <div class="flex gap-2">
                        <button @click="editAd(ad)" class="btn btn-white btn-sm">Edit</button>
                        <button @click="toggleStatus(ad)" class="btn btn-sm" 
                                :class="ad.status === 'Aktif' ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600'"
                                x-text="ad.status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan'"></button>
                    </div>
                </div>
            </div>
        </template>
    </div>

</div>
@endsection

<script>
function adminIklan() {
    return {
        filter: 'semua',
        ads: [
            { id: 1, name: 'Laundry Express USU', placement: 'Detail Kos Medan', price: 'Rp 150.000/bln', status: 'Aktif' },
            { id: 2, name: 'Katering Anak Kampus', placement: 'Homepage rekomendasi', price: 'Rp 250.000/bln', status: 'Aktif' },
            { id: 3, name: 'WiFi Ngebut 100Mbps', placement: 'Sidebar hasil pencarian', price: 'Rp 300.000/bln', status: 'Aktif' },
            { id: 4, name: 'Laundry Cepat Bersih', placement: 'Detail Kos Bandung', price: 'Rp 120.000/bln', status: 'Aktif' },
            { id: 5, name: 'Catering Sehat', placement: 'Homepage', price: 'Rp 200.000/bln', status: 'Kadaluarsa' },
            { id: 6, name: 'Mitra Taksi Kampus', placement: 'Sidebar', price: 'Rp 180.000/bln', status: 'Aktif' },
        ],

        get filteredAds() {
            if (this.filter === 'semua') return this.ads;
            if (this.filter === 'aktif') return this.ads.filter(a => a.status === 'Aktif');
            return this.ads.filter(a => a.status === 'Kadaluarsa');
        },

        toggleStatus(ad) {
            ad.status = ad.status === 'Aktif' ? 'Kadaluarsa' : 'Aktif';
            this.showToast('Status iklan diperbarui.');
        },

        editAd(ad) {
            const newPrice = prompt('Ubah harga iklan:', ad.price);
            if (newPrice) ad.price = newPrice;
        },

        addSlot() {
            const name = prompt('Nama iklan baru:');
            if (name) {
                this.ads.unshift({ id: Date.now(), name, placement: 'Baru', price: 'Rp 0', status: 'Aktif' });
                this.showToast('Slot iklan baru ditambahkan.');
            }
        },

        showToast(msg) {
            const t = document.createElement('div');
            t.className = 'fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3 rounded-2xl text-sm z-[9999]';
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 2300);
        }
    }
}
</script>
