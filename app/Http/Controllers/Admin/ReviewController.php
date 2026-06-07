<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'kos', 'moderator']);

        // Filter by status
        if ($request->filled('filter')) {
            match ($request->input('filter')) {
                'pending' => $query->where('status', Review::STATUS_PENDING),
                'approved' => $query->where('status', Review::STATUS_APPROVED),
                'rejected' => $query->where('status', Review::STATUS_REJECTED),
                'flagged' => $query->where('is_flagged', true),
                default => null,
            };
        }

        $reviews = $query->latest()->paginate(20);

        // Stats for badges
        $pendingCount = Review::where('status', Review::STATUS_PENDING)->count();
        $flaggedCount = Review::where('is_flagged', true)->count();

        return view('adminModerasi', compact('reviews', 'pendingCount', 'flaggedCount'));
    }

    public function approve(Review $review)
    {
        $review->approve(Auth::id());

        return redirect()->back()->with('success', 'Review berhasil disetujui dan ditampilkan ke publik.');
    }

    public function reject(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $review->reject(Auth::id(), $validated['rejection_reason']);

        return redirect()->back()->with('success', 'Review berhasil ditolak.');
    }

    public function hide(Review $review)
    {
        $review->update([
            'is_visible' => false,
            'moderated_by' => Auth::id(),
            'moderated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review berhasil disembunyikan.');
    }

    public function unflag(Review $review)
    {
        $review->update(['is_flagged' => false]);

        return redirect()->back()->with('success', 'Review berhasil di-unflag.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }
}