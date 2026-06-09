<?php

namespace App\Http\Controllers\Web;

use App\Events\ReviewCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Kos;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function create($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan review.');
        }

        $kos = Kos::findOrFail($id);
        $existingReview = $this->reviewService->hasUserReviewed(Auth::id(), $kos->id);

        if ($existingReview) {
            return redirect()->route('student.kos.show', $kos->slug)
                ->with('error', 'Anda sudah memberikan review untuk kos ini.');
        }

        return view('reviewCreate', compact('kos'));
    }

    public function store(ReviewRequest $request, $id)
    {
        $kos = Kos::findOrFail($id);
        $validated = $request->validated();

        if ($this->reviewService->hasUserReviewed(Auth::id(), $kos->id)) {
            return redirect()->route('student.kos.show', $kos->slug)
                ->with('error', 'Anda sudah memberikan review untuk kos ini.');
        }

        $validated['kos_id'] = $kos->id;

        $review = $this->reviewService->createReview($validated, Auth::id());

        ReviewCreated::dispatch($review, $kos);

        return redirect()
            ->route('student.kos.show', $kos->slug)
            ->with('success', 'Review berhasil dikirim dan sedang dalam proses moderasi. Terima kasih atas masukan Anda!');
    }

    public function helpful(Review $review)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $review = $this->reviewService->markAsHelpful($review);

        return response()->json([
            'success' => true,
            'helpful_count' => $review->helpful_count,
        ]);
    }

    public function report(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $review->reports()->create([
            'user_id' => Auth::id(),
            'description' => $validated['reason'],
        ]);

        $review->flag();

        return redirect()->back()->with('success', 'Report berhasil dikirim. Tim kami akan meninjaunya.');
    }
}