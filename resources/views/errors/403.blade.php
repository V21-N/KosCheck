@extends('layouts.app')
@section('title', 'Forbidden — KosCheck')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="mb-6">
            <svg class="w-24 h-24 mx-auto text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <h1 class="text-5xl font-extrabold text-text mb-3">403</h1>
        <h2 class="text-xl font-bold text-text mb-2">Akses Ditolak</h2>
        <p class="text-text-muted mb-6">Anda tidak memiliki izin untuk mengakses halaman ini. Role Anda tidak sesuai dengan kebutuhan halaman.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ session('user_role') === 'mahasiswa' ? route('student.dashboard') : (session('user_role') === 'owner' ? route('owner.dashboard') : route('home')) }}" class="btn btn-primary px-6">Kembali ke Dashboard</a>
            <a href="{{ route('home') }}" class="btn btn-white px-6">Ke Beranda</a>
        </div>
    </div>
</section>
@endsection