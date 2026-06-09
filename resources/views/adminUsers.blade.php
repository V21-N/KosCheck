@extends('layouts.admin')
@section('title', 'Manajemen User — Admin Panel')

@section('topbar_left')
    <div>
        <h1 class="text-xl font-bold text-text">Manajemen User</h1>
        <p class="text-xs text-text-muted mt-1">Kelola semua akun pengguna di platform KosCheck.</p>
    </div>
@endsection

@section('topbar_right')
    <span class="badge badge-verified bg-green-100 text-green-800 border border-green-200 hidden md:inline-flex">Database Connected</span>
@endsection

@section('content')
<div x-data="adminUsers()" class="space-y-6">
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex gap-2 flex-wrap">
            <button @click="filter='semua'" :class="filter==='semua'?'bg-primary text-white':'bg-white border'" class="btn btn-sm px-4">Semua User</button>
            <button @click="filter='Mahasiswa'" :class="filter==='Mahasiswa'?'bg-blue-600 text-white':'bg-white border'" class="btn btn-sm px-4">Mahasiswa</button>
            <button @click="filter='Owner'" :class="filter==='Owner'?'bg-orange-600 text-white':'bg-white border'" class="btn btn-sm px-4">Pemilik Kos</button>
            <button @click="filter='Admin'" :class="filter==='Admin'?'bg-purple-600 text-white':'bg-white border'" class="btn btn-sm px-4">Admin</button>
        </div>
        <form action="{{ route('admin.users') }}" method="GET" class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." class="border rounded-l-lg px-3 py-1 text-sm outline-none">
            <button type="submit" class="bg-primary text-white px-3 py-1 rounded-r-lg text-sm">Cari</button>
        </form>
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
                    <span class="text-xs px-3 py-1 rounded-full" :class="user.status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="user.status"></span>
                    <button @click="manageUser(user)" class="btn btn-white btn-sm">Ganti Status</button>
                    
                    <form :action="`/admin/users/${user.id}/toggle`" method="POST" :id="`toggle-form-${user.id}`" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </template>
    </div>
    
    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>
@endsection

<script>
function adminUsers() {
    return {
        filter: 'semua',
        users: {!! json_encode(collect($users->items())->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => ucfirst($user->role),
                'status' => $user->is_active ? 'Aktif' : 'Nonaktif',
            ];
        })) !!},

        get filteredUsers() {
            if (this.filter === 'semua') return this.users;
            return this.users.filter(u => u.role === this.filter);
        },

        manageUser(user) {
            if (confirm(`Ubah status aktif user ${user.name}?`)) {
                document.getElementById(`toggle-form-${user.id}`).submit();
            }
        }
    }
}
</script>
