@extends('layouts.mahasiswa')

@section('title', 'Review Saya — KosCheck')

@section('topbar_left')
    <h1 class="text-xl font-bold text-text">Review Saya</h1>
@endsection

@section('topbar_right')
    <span class="badge bg-gray-100 text-gray-700">
        {{ $reviewCounts['total'] }} Review
    </span>
@endsection

@section('content')
<div class="max-w-5xl">
    <p class="text-sm text-text-muted mb-6">Daftar review yang telah kamu tulis untuk kos-kos yang pernah ditinggali.</p>

    {{-- Status Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6 pb-4 border-b border-border-light">
        <a href="{{ route('student.review') }}"
           class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors
              {{ !request()->input('status') ? 'bg-primary text-white' : 'bg-gray-100 text-text hover:bg-gray-200' }}">
            Semua ({{ $reviewCounts['total'] }})
        </a>
        <a href="{{ route('student.review', ['status' => 'pending']) }}"
           class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors
              {{ request()->input('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
            Pending ({{ $reviewCounts['pending'] }})
        </a>
        <a href="{{ route('student.review', ['status' => 'approved']) }}"
           class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors
              {{ request()->input('status') === 'approved' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
            Disetujui ({{ $reviewCounts['approved'] }})
        </a>
        <a href="{{ route('student.review', ['status' => 'rejected']) }}"
           class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors
              {{ request()->input('status') === 'rejected' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Ditolak ({{ $reviewCounts['rejected'] }})
        </a>
    </div>

    {{-- Reviews List --}}
    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="card bg-white border border-border-light p-5 rounded-2xl
                {{ $review->status === 'pending' ? 'border-l-4 border-l-amber-400' : '' }}
                {{ $review->status === 'rejected' ? 'border-l-4 border-l-red-400 opacity-75' : '' }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    {{-- Kos Image --}}
                    @if($review->kos && $review->kos->photos->first())
                        <div class="w-full sm:w-24 h-24 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/' . $review->kos->photos->first()->url) }}"
                                 alt="{{ $review->kos->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    {{-- Review Content --}}
                    <div class="flex-1">
                        {{-- Kos Name & Status Badge --}}
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-bold text-text">
                                    {{ $review->kos->name ?? 'Kos Dihapus' }}
                                </h3>
                                <p class="text-xs text-text-muted mt-1">
                                    {{ $review->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                                @if($review->status === 'pending') bg-amber-100 text-amber-700
                                @elseif($review->status === 'approved') bg-emerald-100 text-emerald-700
                                @elseif($review->status === 'rejected') bg-gray-200 text-gray-600
                                @endif">
                                @if($review->status === 'pending')
                                    Menunggu Review
                                @elseif($review->status === 'approved')
                                    Dipublikasikan
                                @elseif($review->status === 'rejected')
                                    Ditolak
                                @endif
                            </span>
                        </div>

                        {{-- Rating --}}
                        <div class="flex items-center gap-2 mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="text-sm text-text-muted">{{ $review->rating }}/5</span>
                        </div>

                        {{-- Comment --}}
                        <p class="mt-3 text-sm text-text leading-relaxed">{{ $review->comment }}</p>

                        {{-- Rejection Reason --}}
                        @if($review->status === 'rejected' && $review->rejection_reason)
                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-xl">
                                <p class="text-xs font-semibold text-red-700 mb-1">Alasan Penolakan:</p>
                                <p class="text-sm text-red-600">{{ $review->rejection_reason }}</p>
                            </div>
                        @endif

                        {{-- Pending Notice --}}
                        @if($review->status === 'pending')
                            <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-2">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-amber-700">Review sedang dalam proses moderasi</p>
                                    <p class="text-xs text-amber-600 mt-1">Tim kami akan meninjaunya dan mempublikasikan secepat mungkin.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap gap-2 justify-end">
                    @if($review->kos)
                        <a href="{{ route('student.kos.show', $review->kos->slug) }}"
                           class="btn btn-white btn-sm text-xs">
                            Lihat Kos
                        </a>
                    @endif
                    @if($review->status === 'rejected')
                        <a href="{{ route('kos.review.create', $review->kos) }}"
                           class="btn btn-primary btn-sm text-xs">
                            Tulis Ulang Review
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="text-text-muted">Belum ada review yang ditulis.</p>
                <p class="text-sm text-text-muted mt-2">Yuk, berikan review untuk kos yang pernah kamu tinggali!</p>
                <a href="{{ route('student.kos') }}" class="btn btn-primary btn-sm mt-4">
                    Cari Kos
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection