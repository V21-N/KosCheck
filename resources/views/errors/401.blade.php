@extends('layouts.app')
@section('title', 'Unauthorized — KosCheck')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="mb-6">
            <svg class="w-24 h-24 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h1 class="text-5xl font-extrabold text-text mb-3">401</h1>
        <h2 class="text-xl font-bold text-text mb-2">Unauthorized Access</h2>
        <p class="text-text-muted mb-6">Anda harus login terlebih dahulu untuk mengakses halaman ini.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('login') }}" class="btn btn-primary px-6">Login Sekarang</a>
            <a href="{{ route('home') }}" class="btn btn-white px-6">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection