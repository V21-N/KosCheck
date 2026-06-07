@extends('layouts.admin')
@section('title', 'Moderasi Review — Admin Panel')

@section('topbar_left')
    <div>
        <h1 class="text-xl font-bold text-text">Moderasi Review</h1>
        <p class="text-xs text-text-muted mt-1">Tinjau dan kelola review dari mahasiswa.</p>
    </div>
@endsection

@section('topbar_right')
    <div class="flex items-center gap-3">
        @if($pendingCount > 0)
            <span class="badge badge-pending bg-amber-100 text-amber-800 border border-amber-200">
                {{ $pendingCount }} Pending
            </span>
        @endif
        @if($flaggedCount > 0)
            <span class="badge badge-flagged bg-red-100 text-red-800 border border-red-200">
                {{ $flaggedCount }} Dilaporkan
            </span>
        @endif
    </div>
@endsection

@section('content')
<div x-data="adminModerasi()" class="space-y-6">

    {{-- Filter Buttons --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div class="flex flex-wrap gap-2">
        
        <a href="{{ route('admin.moderasi', ['filter' => 'all']) }}"
           class="btn btn-sm px-4 {{ !request()->filled('filter') || request()->query('filter') === 'all' ? 'bg-primary text-white' : 'bg-white border' }}">
            Semua
        </a>
        
        <a href="{{ route('admin.moderasi', ['filter' => 'pending']) }}"
           class="btn btn-sm px-4 {{ request()->query('filter') === 'pending' ? 'bg-amber-500 text-white' : 'bg-white border' }}">
            Pending
        </a>
        
        <a href="{{ route('admin.moderasi', ['filter' => 'approved']) }}"
           class="btn btn-sm px-4 {{ request()->query('filter') === 'approved' ? 'bg-emerald-600 text-white' : 'bg-white border' }}">
            Disetujui
        </a>
        
        <a href="{{ route('admin.moderasi', ['filter' => 'rejected']) }}"
           class="btn btn-sm px-4 {{ request()->query('filter') === 'rejected' ? 'bg-red-600 text-white' : 'bg-white border' }}">
            Ditolak
        </a>

        </div>
    </div>

    {{-- Reviews Grid --}}
    @forelse($reviews as $review)
        <article class="rounded-2xl border border-border-light p-5 bg-bg" data-hover="lift">
            {{-- Header: Status Badge --}}
            <div class="flex items-start justify-between">
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                    @if($review->status === 'pending') bg-amber-100 text-amber-700
                    @elseif($review->status === 'approved') bg-emerald-100 text-emerald-700
                    @elseif($review->status === 'rejected') bg-gray-200 text-gray-600
                    @elseif($review->is_flagged) bg-red-100 text-red-600
                    @endif">
                    @if($review->status === 'pending')
                        Pending Review
                    @elseif($review->status === 'approved')
                        Disetujui
                    @elseif($review->status === 'rejected')
                        Ditolak
                    @elseif($review->is_flagged)
                        Dilaporkan
                    @endif
                </span>
                <span class="text-xs text-text-muted">
                    {{ $review->created_at->diffForHumans() }}
                </span>
            </div>

            {{-- Review Info --}}
            <div class="mt-4">
                <h3 class="font-bold text-text">{{ $review->kos->name ?? 'Kos Dihapus' }}</h3>
                <p class="text-sm text-text-muted mt-1">
                    {{ $review->user->name ?? 'Pengguna Dihapus' }}
                    @if($review->user)
                        <span class="text-xs">({{ $review->user->email }})</span>
                    @endif
                </p>
            </div>

            {{-- Rating Display --}}
            <div class="mt-3 flex items-center gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
                <span class="text-sm text-text-muted ml-1">{{ $review->rating }}/5</span>
            </div>

            {{-- Comment --}}
            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-text">{{ $review->comment }}</p>
            </div>

            {{-- Rejection Reason (if rejected) --}}
            @if($review->status === 'rejected' && $review->rejection_reason)
                <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-xs font-semibold text-red-700 mb-1">Alasan Penolakan:</p>
                    <p class="text-sm text-red-600">{{ $review->rejection_reason }}</p>
                </div>
            @endif

            {{-- Moderation Info --}}
            @if($review->moderated_at)
                <p class="text-xs text-text-muted mt-3">
                    Ditinjau oleh {{ $review->moderator->name ?? 'Admin' }}
                    pada {{ $review->moderated_at->format('d M Y, H:i') }}
                </p>
            @endif

            {{-- Action Buttons --}}
            <div class="mt-4 flex flex-wrap gap-2">
                @if($review->status === 'pending' || $review->is_flagged)
                    {{-- Approve Button --}}
                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Setujui
                        </button>
                    </form>

                    {{-- Reject Button --}}
                    <button type="button" onclick="openRejectModal({{ $review->id }})" class="btn btn-white btn-sm px-4 border-red-300 text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak
                    </button>
                @endif

                @if($review->status === 'approved')
                    {{-- Hide Button --}}
                    <form action="{{ route('admin.reviews.hide', $review) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-white btn-sm px-4 border-gray-300">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                            Sembunyikan
                        </button>
                    </form>
                @endif

                @if($review->is_flagged && $review->status !== 'pending')
                    {{-- Unflag Button --}}
                    <form action="{{ route('admin.reviews.unflag', $review) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-white btn-sm px-4 border-amber-300 text-amber-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                            </svg>
                            Hapus Flag
                        </button>
                    </form>
                @endif

                @if($review->status === 'rejected')
                    {{-- Re-approve Button --}}
                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-white btn-sm px-4 border-emerald-300 text-emerald-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Setujui Ulang
                        </button>
                    </form>
                @endif

                {{-- Delete Button --}}
                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-white btn-sm px-4 border-red-300 text-red-600 hover:bg-red-50">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </article>
    @empty
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p class="text-text-muted">Tidak ada review untuk dimoderasi.</p>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($reviews->hasPages())
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    @endif

</div>

{{-- Rejection Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl">
        <h3 class="text-lg font-bold text-text mb-4">Tolak Review</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-text mb-2">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                    class="w-full px-4 py-2 border border-border-light rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Jelaskan alasan penolakan review ini..."></textarea>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeRejectModal()" class="btn btn-white btn-sm px-4">Batal</button>
                <button type="submit" class="btn btn-red btn-sm px-4">Tolak Review</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openRejectModal(reviewId) {
    const form = document.getElementById('rejectForm');
    form.action = '/admin/reviews/' + reviewId + '/reject';
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
    document.getElementById('rejection_reason').focus();
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
    document.getElementById('rejection_reason').value = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeRejectModal();
});

// Close modal on backdrop click
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endpush