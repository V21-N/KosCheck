<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Kos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReviewService
{
    public function createReview(array $data, int $userId): Review
    {
        $review = Review::create([
            'kos_id' => $data['kos_id'],
            'user_id' => $userId,
            'rating' => $data['rating'],
            'rating_cleanliness' => $data['rating_cleanliness'] ?? null,
            'rating_security' => $data['rating_security'] ?? null,
            'rating_facilities' => $data['rating_facilities'] ?? null,
            'comment' => $data['comment'],
            'status' => Review::STATUS_PENDING, // Review baru berstatus pending
            'is_visible' => false, // Tidak visible sampai disetujui
        ]);

        $review->load(['user', 'kos']);

        return $review;
    }

    public function getReviewsForKos(Kos $kos, ?Request $request = null): LengthAwarePaginator
    {
        $query = $kos->reviews()
            ->visible()
            ->with('user');

        $query = $this->applySorting($query, $request);

        return $query->paginate(10)->withQueryString();
    }

    public function getLatestReviews(int $limit = 10): Collection
    {
        return Review::visible()
            ->with(['user', 'kos'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getUserReviews(int $userId): Collection
    {
        return Review::where('user_id', $userId)
            ->with(['kos'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 WHEN status = 'approved' THEN 2 WHEN status = 'rejected' THEN 3 ELSE 4 END")
            ->latest()
            ->get();
    }

    public function markAsHelpful(Review $review): Review
    {
        $review->incrementHelpful();

        return $review->fresh();
    }

    public function flagReview(Review $review): Review
    {
        $review->flag();

        return $review->fresh();
    }

    public function unflagReview(Review $review): Review
    {
        $review->unflag();

        return $review->fresh();
    }

    public function hideReview(Review $review): Review
    {
        $review->hide();

        return $review->fresh();
    }

    public function showReview(Review $review): Review
    {
        $review->show();

        return $review->fresh();
    }

    public function deleteReview(Review $review): void
    {
        $review->reports()->delete();
        $review->delete();
    }

    public function hasUserReviewed(int $userId, int $kosId): bool
    {
        return Review::where('user_id', $userId)
            ->where('kos_id', $kosId)
            ->exists();
    }

    public function getAverageRating(Kos $kos): ?float
    {
        return $kos->reviews()->visible()->avg('rating');
    }

    public function getRatingBreakdown(Kos $kos): array
    {
        $reviews = $kos->reviews()->visible()->get();

        $breakdown = [
            'cleanliness' => [],
            'security' => [],
            'facilities' => [],
        ];

        foreach ($reviews as $review) {
            if ($review->rating_cleanliness) {
                $breakdown['cleanliness'][] = $review->rating_cleanliness;
            }
            if ($review->rating_security) {
                $breakdown['security'][] = $review->rating_security;
            }
            if ($review->rating_facilities) {
                $breakdown['facilities'][] = $review->rating_facilities;
            }
        }

        return [
            'overall' => $reviews->avg('rating'),
            'cleanliness_avg' => count($breakdown['cleanliness']) > 0
                ? array_sum($breakdown['cleanliness']) / count($breakdown['cleanliness'])
                : null,
            'security_avg' => count($breakdown['security']) > 0
                ? array_sum($breakdown['security']) / count($breakdown['security'])
                : null,
            'facilities_avg' => count($breakdown['facilities']) > 0
                ? array_sum($breakdown['facilities']) / count($breakdown['facilities'])
                : null,
            'total_reviews' => $reviews->count(),
        ];
    }

    public function getFlaggedReviews(int $limit = 50): Collection
    {
        return Review::flagged()
            ->with(['user', 'kos'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getHiddenReviews(int $limit = 50): Collection
    {
        return Review::where('is_visible', false)
            ->with(['user', 'kos'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    protected function applySorting($query, ?Request $request)
    {
        if (!$request) {
            return $query->latest();
        }

        return match ($request->input('sort', 'latest')) {
            'highest' => $query->orderBy('rating', 'desc'),
            'lowest' => $query->orderBy('rating', 'asc'),
            'helpful' => $query->orderBy('helpful_count', 'desc'),
            default => $query->latest(),
        };
    }
}