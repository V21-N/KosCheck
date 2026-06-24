<?php

namespace App\Services;

use App\Models\Kos;
use App\Models\Photo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class KosService
{
    protected int $cacheMinutes = 60;

    public function getActiveKos(?Request $request = null): LengthAwarePaginator
    {
        $query = Kos::active()
            ->with(['owner', 'photos' => fn($q) => $q->orderBy('is_primary', 'desc')->orderBy('order'), 'facilities', 'reviews']);

        $query = $this->applyFilters($query, $request);

        $query = $this->applySorting($query, $request);

        $perPage = $request?->input('per_page', 12);

        return $query->paginate($perPage)->withQueryString();
    }

    public function getFeaturedKos(int $limit = 8): Collection
    {
        $cacheKey = "featured_kos:{$limit}";

        $cached = Cache::get($cacheKey);
        if ($cached instanceof Collection) {
            return $cached;
        }

        $result = Kos::active()
            ->with(['photos' => fn($q) => $q->orderBy('is_primary', 'desc')->orderBy('order'), 'facilities', 'reviews'])
            ->premiumFirst()
            ->limit($limit)
            ->get();

        Cache::put($cacheKey, $result, now()->addMinutes($this->cacheMinutes));

        return $result;
    }

    public function getRecentKos(int $limit = 6): Collection
    {
        $cacheKey = "recent_kos:{$limit}";

        $cached = Cache::get($cacheKey);
        if ($cached instanceof Collection) {
            return $cached;
        }

        $result = Kos::active()
            ->with(['photos' => fn($q) => $q->orderBy('is_primary', 'desc')->orderBy('order'), 'facilities'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        Cache::put($cacheKey, $result, now()->addMinutes($this->cacheMinutes));

        return $result;
    }

    public function getKosBySlug(string $slug): Kos
    {
        return Kos::where('slug', $slug)
            ->orWhere('id', $slug)
            ->with([
                'photos' => fn($q) => $q->orderBy('order'),
                'facilities',
                'reviews' => fn($q) => $q->visible()->with('user')->latest()->limit(10),
                'owner',
            ])
            ->firstOrFail();
    }

    public function getNearbyKos(Kos $kos, int $limit = 4): Collection
    {
        if (is_null($kos->latitude) || is_null($kos->longitude)) {
            return new Collection();
        }

        $radius = 0.05;

        return Kos::active()
            ->where('id', '!=', $kos->id)
            ->whereBetween('latitude', [$kos->latitude - $radius, $kos->latitude + $radius])
            ->whereBetween('longitude', [$kos->longitude - $radius, $kos->longitude + $radius])
            ->with(['photos' => fn($q) => $q->orderBy('is_primary', 'desc')->orderBy('order')])
            ->limit($limit)
            ->get();
    }

    public function createKos(array $data, int $userId): Kos
    {
        $data['user_id'] = $userId;
        $data['slug'] = Kos::generateUniqueSlug($data['name']);
        $data['status'] = 'pending';

        $kos = Kos::create($data);

        if (!empty($data['facilities'])) {
            $kos->facilities()->attach($data['facilities']);
        }

        $this->clearKosCache();

        return $kos;
    }

    public function updateKos(Kos $kos, array $data): Kos
    {
        if (isset($data['name']) && $data['name'] !== $kos->name) {
            $data['slug'] = Kos::generateUniqueSlug($data['name']);
        }

        $kos->update($data);

        if (array_key_exists('facilities', $data)) {
            $kos->facilities()->sync($data['facilities'] ?? []);
        }

        $this->clearKosCache();

        return $kos;
    }

    public function deleteKos(Kos $kos): void
    {
        foreach ($kos->photos as $photo) {
            if ($photo->url) {
                Storage::disk('public')->delete($photo->url);
            }
        }

        $kos->facilities()->detach();
        $kos->reviews()->delete();
        $kos->leads()->delete();
        $kos->photos()->delete();

        $kos->delete();

        $this->clearKosCache();
    }

    public function toggleStatus(Kos $kos): Kos
    {
        $kos->update(['is_active' => !$kos->is_active]);

        $this->clearKosCache();

        return $kos;
    }

    public function approveKos(Kos $kos): Kos
    {
        $kos->update(['status' => 'active']);

        $this->clearKosCache();

        return $kos;
    }

    public function rejectKos(Kos $kos): Kos
    {
        $kos->update(['status' => 'rejected']);

        $this->clearKosCache();

        return $kos;
    }

    public function togglePremium(Kos $kos, ?\DateTimeInterface $expiresAt = null): Kos
    {
        $isPremium = !$kos->is_premium;

        $kos->update([
            'is_premium' => $isPremium,
            'premium_expires_at' => $isPremium ? ($expiresAt ?? now()->addMonth()) : null,
        ]);

        $this->clearKosCache();

        return $kos;
    }

    public function uploadPhotos(Kos $kos, array $files): \Illuminate\Support\Collection
    {
        $photos = collect();
        $hasExistingPhotos = $kos->getMedia('photos')->isNotEmpty();

        foreach ($files as $index => $file) {
            // Use Spatie Media Library for automatic compression and conversions
            $media = $kos->addMedia($file)
                ->preservingOriginal()
                ->toMediaCollection('photos');

            // Trigger conversions immediately (non-queued for simplicity)
            $media->markAsConversionGenerated('thumbnail');
            $media->markAsConversionGenerated('medium');
            $media->markAsConversionGenerated('large');
            $media->markAsConversionGenerated('placeholder');

            // Also create legacy Photo record for backward compatibility
            $photo = $kos->photos()->create([
                'url' => $media->getUrl(),
                'order' => $index,
                'is_primary' => !$hasExistingPhotos && $index === 0,
            ]);

            $photos->push($photo);
        }

        return $photos;
    }

    public function deletePhoto(Photo $photo): void
    {
        // Delete from Spatie Media Library if exists
        $media = $photo->getFirstMedia('photos');
        if ($media) {
            $media->delete();
        }

        // Also delete legacy file
        if ($photo->url) {
            Storage::disk('public')->delete($photo->url);
        }

        $photo->delete();
    }

    protected function applyFilters($query, ?Request $request)
    {
        if (!$request) {
            return $query;
        }

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        if ($request->filled('gender')) {
            $query->byGender($request->input('gender'));
        }

        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->byPriceRange(
                (int) $request->input('price_min'),
                (int) $request->input('price_max')
            );
        }

        if ($request->filled('facilities')) {
            $facilities = $request->input('facilities', []);
            $query->whereHas('facilities', fn($q) => $q->whereIn('facilities.id', $facilities));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('is_premium')) {
            $query->where('is_premium', $request->boolean('is_premium'));
        }

        return $query;
    }

    protected function applySorting($query, ?Request $request)
    {
        if (!$request) {
            return $query->premiumFirst();
        }

        if ($request->filled('sort')) {
            return match ($request->input('sort')) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'rating' => $query->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', 'desc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                default => $query->premiumFirst(),
            };
        }

        return $query->premiumFirst();
    }

    public function clearKosCache(): void
    {
        Cache::flush();
    }

    public function getKosStats(): array
    {
        $cacheKey = 'kos_stats';

        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }

        $result = [
            'total' => Kos::count(),
            'active' => Kos::active()->count(),
            'pending' => Kos::where('status', 'pending')->count(),
            'premium' => Kos::where('is_premium', true)->count(),
            'avg_price' => Kos::active()->avg('price'),
        ];

        Cache::put($cacheKey, $result, now()->addMinutes($this->cacheMinutes));

        return $result;
    }
}
