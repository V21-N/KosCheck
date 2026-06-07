<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ReviewCreated;
use App\Http\Controllers\Controller;
use App\Http\ApiRes\ApiResponse;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Kos;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function index(Request $request, string $slug): JsonResponse
    {
        $validated = $request->validate([
            'sort' => 'nullable|string|in:latest,highest,lowest,helpful',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $kos = Kos::where('slug', $slug)->firstOrFail();

        $request->merge($validated);
        $reviews = $this->reviewService->getReviewsForKos($kos, $request);

        return $this->paginate($reviews);
    }

    public function store(ReviewRequest $request, string $slug): JsonResponse
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();

        $userId = $request->user()?->id;

        if (!$userId) {
            return $this->error('Unauthorized', 401);
        }

        if ($this->reviewService->hasUserReviewed($userId, $kos->id)) {
            return $this->error('Anda sudah memberikan review untuk kos ini', 422);
        }

        $validated = $request->validated();
        $validated['kos_id'] = $kos->id;

        $review = $this->reviewService->createReview($validated, $userId);

        ReviewCreated::dispatch($review, $kos);

        return $this->success(new ReviewResource($review), 'Review berhasil dibuat', 201);
    }

    public function show(string $slug, int $id): JsonResponse
    {
        $review = Review::with(['user', 'kos'])
            ->where('id', $id)
            ->firstOrFail();

        return $this->success(new ReviewResource($review));
    }

    public function helpful(int $id): JsonResponse
    {
        $review = Review::findOrFail($id);

        $review = $this->reviewService->markAsHelpful($review);

        return $this->success([
            'id' => $review->id,
            'helpful_count' => $review->helpful_count,
        ], 'Review ditandai sebagai helpful');
    }

    public function myReviews(Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        if (!$userId) {
            return $this->error('Unauthorized', 401);
        }

        $reviews = $this->reviewService->getUserReviews($userId);

        return $this->success(ReviewResource::collection($reviews));
    }
}