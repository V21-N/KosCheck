@extends('layouts.admin')
@section('title', 'Manajemen User — Admin Panel')

@section('topbar_left')
    <div>
        <h1 class="text-xl font-bold text-text">Manajemen User</h1>
        <p class="text-xs text-text-muted mt-1">Kelola semua akun pengguna di platform KosCheck.</p>
    </div>
@endsection

@section('topbar_right')
    <span class="badge badge-verified bg-green-100 text-green-800 border border-green-200 hidden md:inline-flex">Frontend Only</span>
@endsection

@section('content')
<div x-data="adminUsers()" class="space-y-6">
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex gap-2 flex-wrap">
            <button @click="filter='semua'" :class="filter==='semua'?'bg-primary text-white':'bg-white border'" class="btn btn-sm px-4">Semua User</button>
            <button @click="filter='Mahasiswa'" :class="filter==='Mahasiswa'?'bg-blue-600 text-white':'bg-white border'" class="btn btn-sm px-4">Mahasiswa</button>
            <button @click="filter='Pemilik Kos'" :class="filter==='Pemilik Kos'?'bg-orange-600 text-white':'bg-white border'" class="btn btn-sm px-4">Pemilik Kos</button>
            <button @click="filter='Admin'" :class="filter==='Admin'?'bg-purple-600 text-white':'bg-white border'" class="btn btn-sm px-4">Admin</button>
        </div>
        <button @click="inviteAdmin()" class="btn btn-primary btn-sm">Undang Admin Baru</button>
    </div>

    <div class="card border-none shadow-sm divide-y divide-border-light">
        <template x-for="user in filteredUsers" :key="user.id">
            <div class="p-5 flex items-center justify-between gap-3" data-hover="lift">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm font-bold" x-text="user.name[0]"></div>
                    <div>
                        <p class="font-bold" x-text="user.name"></p>
                        <p class="text-xs text-text-muted" x-text="user.email"></p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs px-3 py-1 rounded-full" :class="user.role === 'Admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100'" x-text="user.role"></span>
                    <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700" x-text="user.status"></span>
                    <button @click="manageUser(user)" class="btn btn-white btn-sm">Kelola</button>
                </div>
            </div>
        </template>
    </div>

</div>
@endsection

<script>
function adminUsers() {
    return {
        filter: 'semua',
        users: [
            { id: 1, name: 'Budi Santoso', email: 'budi@kampus.id', role: 'Mahasiswa', status: 'Aktif' },
            { id: 2, name: 'Ibu Sarah Wijaya', email: 'sarah@email.com', role: 'Pemilik Kos', status: 'Terverifikasi' },
            { id: 3, name: 'Tim Moderasi 2', email: 'mod2@koscheck.com', role: 'Admin', status: 'Aktif' },
            { id: 4, name: 'Andi Pratama', email: 'andi@kampus.id', role: 'Mahasiswa', status: 'Aktif' },
            { id: 5, name: 'Pak Dodi Firmansyah', email: 'dodi@email.com', role: 'Pemilik Kos', status: 'Terverifikasi' },
            { id: 6, name: 'Siti Nurhaliza', email: 'siti@kampus.id', role: 'Mahasiswa', status: 'Aktif' },
        ],

        get filteredUsers() {
            if (this.filter === 'semua') return this.users;
            return this.users.filter(u => u.role === this.filter);
        },

        manageUser(user) {
            alert(`Mengelola user: ${user.name} (simulasi)`);
        },

        inviteAdmin() {
            const email = prompt('Email admin baru:');
            if (email) {
                this.users.push({ id: Date.now(), name: 'Admin Baru', email, role: 'Admin', status: 'Aktif' });
                alert('Undangan admin dikirim (simulasi).');
            }
        }
    }
}
</script>
