<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Services\PropertyAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(
        protected PropertyAnalyticsService $analyticsService
    ) {}

    /**
     * Track property view
     */
    public function trackView(Request $request, string $slug): JsonResponse
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();

        $this->analyticsService->trackView(
            $kos,
            $request->user(),
            $request->ip()
        );

        return response()->json(['success' => true]);
    }

    /**
     * Track property favorite
     */
    public function trackFavorite(Request $request, string $slug): JsonResponse
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();

        $favorite = $this->analyticsService->trackFavorite(
            $kos,
            $request->user(),
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'favorited' => true,
        ]);
    }

    /**
     * Remove favorite
     */
    public function removeFavorite(Request $request, string $slug): JsonResponse
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();

        $request->user()?->favoriteKos()->detach($kos->id);

        return response()->json([
            'success' => true,
            'favorited' => false,
        ]);
    }

    /**
     * Track WhatsApp click
     */
    public function trackWhatsapp(Request $request, string $slug): JsonResponse
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();

        $this->analyticsService->trackWhatsappClick(
            $kos,
            $request->user()
        );

        return response()->json(['success' => true]);
    }

    /**
     * Get analytics for a specific property
     */
    public function propertyStats(string $slug): JsonResponse
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();

        // Only allow owner to see detailed stats
        $user = auth()->user();
        if (!$user || ($user->id !== $kos->user_id && !$user->isAdmin())) {
            return response()->json([
                'views' => $this->analyticsService->getViewStats($kos, 30)['this_month'],
                'favorites' => $this->analyticsService->getFavoriteStats($kos)['this_month'],
                'whatsapp' => $this->analyticsService->getWhatsappClickStats($kos)['this_month'],
            ]);
        }

        return response()->json([
            'views' => $this->analyticsService->getViewStats($kos),
            'favorites' => $this->analyticsService->getFavoriteStats($kos),
            'whatsapp' => $this->analyticsService->getWhatsappClickStats($kos),
        ]);
    }
}
