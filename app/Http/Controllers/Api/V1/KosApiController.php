<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\ApiRes\ApiResponse;
use App\Http\Resources\KosResource;
use App\Models\Kos;
use App\Services\KosService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KosApiController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected KosService $kosService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $kos = $this->kosService->getActiveKos($request);

        return $this->paginate($kos);
    }

    public function show(string $slug): JsonResponse
    {
        $kos = $this->kosService->getKosBySlug($slug);

        return $this->success(new KosResource($kos));
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => 'required|string|min:2',
            'gender' => 'nullable|string|in:putra,putri,campur',
            'price_min' => 'nullable|integer|min:0',
            'price_max' => 'nullable|integer|min:0',
            'facilities' => 'nullable|array',
            'sort' => 'nullable|string|in:price_asc,price_desc,rating,newest',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $request->merge($validated);

        $kos = $this->kosService->getActiveKos($request);

        return $this->paginate($kos);
    }

    public function featured(): JsonResponse
    {
        $featured = $this->kosService->getFeaturedKos(8);

        return $this->success(KosResource::collection($featured));
    }

    public function nearby(string $slug): JsonResponse
    {
        $kos = $this->kosService->getKosBySlug($slug);
        $nearby = $this->kosService->getNearbyKos($kos);

        return $this->success(KosResource::collection($nearby));
    }

    public function stats(): JsonResponse
    {
        $stats = $this->kosService->getKosStats();

        return $this->success($stats);
    }
}