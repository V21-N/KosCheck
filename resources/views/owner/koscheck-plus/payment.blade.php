@extends('layouts.owner')
@section('title', 'Pembayaran KosCheck+')

@section('topbar_left')
<h1 class="text-lg font-bold text-text hidden sm:block">Pembayaran</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Transaction Status --}}
    <div class="card p-6 mb-6">
        <div class="text-center mb-6">
            @if($transaction->isPending())
            <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-text mb-2">Menunggu Pembayaran</h2>
            <p class="text-sm text-text-muted">Selesaikan pembayaran untuk mengaktifkan KosCheck+ Premium</p>
            @elseif($transaction->isSuccess())
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-text mb-2">Pembayaran Berhasil!</h2>
            <p class="text-sm text-text-muted">KosCheck+ Premium telah aktif</p>
            @else
            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-text mb-2">Pembayaran Gagal</h2>
            <p class="text-sm text-text-muted">Silakan coba lagi</p>
            @endif
        </div>

        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-text-muted">Order ID</p>
                    <p class="font-mono font-medium text-text">{{ $transaction->order_id }}</p>
                </div>
                <div>
                    <p class="text-text-muted">Total Bayar</p>
                    <p class="font-bold text-orange-500">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-text-muted">Status</p>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        @if($transaction->isSuccess())
                        bg-green-100 text-green-700
                        @elseif($transaction->isPending())
                        bg-yellow-100 text-yellow-700
                        @else
                        bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($transaction->transaction_status) }}
                    </span>
                </div>
                <div>
                    <p class="text-text-muted">Tanggal</p>
                    <p class="font-medium text-text">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        @if($transaction->isPending())
        <button type="button" id="pay-button" class="w-full py-4 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold rounded-xl transition-all transform hover:scale-[1.02] shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Bayar Sekarang
        </button>
        @else
        <div class="flex gap-3">
            <a href="{{ route('koscheck-plus.index') }}" class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-text font-bold rounded-xl transition-colors text-center">
                Kembali ke Dashboard
            </a>
            @if($transaction->isPending())
            <a href="{{ route('koscheck-plus.checkout') }}" class="flex-1 py-4 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold rounded-xl transition-all text-center">
                Coba Lagi
            </a>
            @endif
        </div>
        @endif
    </div>

    {{-- Help --}}
    <div class="card p-6">
        <h3 class="font-bold text-text mb-3">Butuh Bantuan?</h3>
        <p class="text-sm text-text-muted mb-3">
            Jika Anda sudah melakukan pembayaran tetapi status belum berubah, tunggu beberapa menit dan refresh halaman ini.
        </p>
        <p class="text-sm text-text-muted">
            Hubungi kami di <a href="mailto:support@koscheck.id" class="text-primary hover:underline">support@koscheck.id</a>
        </p>
    </div>
</div>

@if($transaction->isPending())
{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('pay-button');

    if (payButton) {
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route('payment.midtrans.finish', ['order_id' => '']) }}' + result.order_id;
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    // User closed the popup
                }
            });
        });
    }
});
</script>
@endif
@endsection
