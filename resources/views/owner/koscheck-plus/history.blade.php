@extends('layouts.owner')
@section('title', 'Riwayat Langganan KosCheck+')

@section('topbar_left')
<h1 class="text-lg font-bold text-text hidden sm:block">Riwayat Langganan</h1>
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('koscheck-plus.index') }}" class="inline-flex items-center gap-2 text-sm text-primary hover:text-primary-dark transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke KosCheck+
    </a>
</div>

@if($subscriptions->isEmpty())
{{-- Empty State --}}
<div class="card p-12 text-center">
    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
    </div>
    <h3 class="text-lg font-bold text-text mb-2">Belum Ada Riwayat</h3>
    <p class="text-sm text-text-muted mb-6">Anda belum pernah berlangganan KosCheck+ Premium</p>
    <a href="{{ route('koscheck-plus.checkout') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold rounded-xl transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
        Upgrade ke KosCheck+
    </a>
</div>
@else
{{-- Subscriptions List --}}
<div class="space-y-4">
    @foreach($subscriptions as $subscription)
    <div class="card p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full {{ $subscription->isActive() ? 'bg-gradient-to-r from-orange-500 to-amber-500' : 'bg-gray-200' }} flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $subscription->isActive() ? 'text-white' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-text">
                        KosCheck+ Premium
                        @if($subscription->isActive())
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Aktif
                        </span>
                        @else
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                            {{ ucfirst($subscription->status) }}
                        </span>
                        @endif
                    </h3>
                    <p class="text-sm text-text-muted">
                        {{ $subscription->started_at->format('d M Y') }} - {{ $subscription->expired_at->format('d M Y') }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-bold text-text">Rp {{ number_format($subscription->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-text-muted">{{ $subscription->duration_days }} hari</p>
                </div>
            </div>
        </div>

        {{-- Transactions --}}
        @if($subscription->transactions->isNotEmpty())
        <div class="mt-4 pt-4 border-t border-border-light">
            <p class="text-xs text-text-muted mb-2">Transaksi:</p>
            <div class="space-y-2">
                @foreach($subscription->transactions as $transaction)
                <div class="flex items-center justify-between text-sm">
                    <span class="font-mono text-text-muted">{{ $transaction->order_id }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
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
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $subscriptions->links() }}
</div>
@endif
@endsection
