@extends('layouts.owner')
@section('title', 'Checkout KosCheck+ - Premium Subscription')

@section('topbar_left')
<h1 class="text-lg font-bold text-text hidden sm:block">Checkout KosCheck+</h1>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Order Summary Card --}}
    <div class="card p-6 mb-6">
        <h2 class="text-lg font-bold text-text mb-4">Ringkasan Pesanan</h2>

        <div class="flex items-center gap-4 p-4 bg-orange-50 rounded-xl border border-orange-200 mb-4">
            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-orange-500 to-amber-500 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-text">KosCheck+ Premium</h3>
                <p class="text-sm text-text-muted">Berlangganan 30 hari</p>
            </div>
        </div>

        <div class="space-y-3 border-t border-border-light pt-4">
            <div class="flex justify-between text-sm">
                <span class="text-text-muted">KosCheck+ Premium (30 hari)</span>
                <span class="text-text">Rp {{ number_format($price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-text-muted">Biaya layanan</span>
                <span class="text-text">Rp 0</span>
            </div>
            <div class="flex justify-between font-bold text-lg pt-3 border-t border-border-light">
                <span>Total</span>
                <span class="text-orange-500">Rp {{ number_format($price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Payment Method Info --}}
    <div class="card p-6 mb-6">
        <h2 class="text-lg font-bold text-text mb-4">Metode Pembayaran</h2>

        <div class="space-y-3">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Midtrans.png" alt="Midtrans" class="h-25 object-contain">
                <span class="text-sm text-text">Pembayaran aman via Midtrans</span>
            </div>

            <p class="text-xs text-text-muted">
                Anda akan dialihkan ke halaman pembayaran Midtrans yang mendukung berbagai metode pembayaran:
                Kartu Kredit/Debit, Transfer Bank, E-Wallet (GoPay, OVO, Dana), dan lainnya.
            </p>
        </div>
    </div>

    {{-- Pay Button --}}
    <div class="card p-6">
        <button type="button" id="pay-button" class="w-full py-4 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold rounded-xl transition-all transform hover:scale-[1.02] shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Bayar Sekarang
        </button>

        <p class="text-xs text-center text-text-muted mt-4">
            Dengan melanjutkan, Anda menyetujui
            <a href="{{ route('terms') }}" class="text-primary hover:underline">Syarat & Ketentuan</a>
            dan
            <a href="{{ route('privacy') }}" class="text-primary hover:underline">Kebijakan Privasi</a>
            KosCheck.
        </p>
    </div>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('pay-button');

    payButton.addEventListener('click', function() {
        payButton.disabled = true;
        payButton.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;

        // Initiate payment
        fetch('{{ route('koscheck-plus.initiate-payment') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.snap_token) {
                // Open Midtrans Snap popup
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        // Payment successful - redirect to finish
                        window.location.href = '{{ route('payment.midtrans.finish', ['order_id' => '']) }}' + result.order_id;
                    },
                    onPending: function(result) {
                        // Payment pending - redirect to payment page
                        window.location.href = data.redirect_url;
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        payButton.disabled = false;
                        payButton.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        `;
                    },
                    onClose: function() {
                        payButton.disabled = false;
                        payButton.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        `;
                    }
                });
            } else {
                alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                payButton.disabled = false;
                payButton.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Bayar Sekarang
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
            payButton.disabled = false;
            payButton.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Bayar Sekarang
            `;
        });
    });
});
</script>
@endsection
