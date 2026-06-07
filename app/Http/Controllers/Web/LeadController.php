<?php

namespace App\Http\Controllers\Web;

use App\Events\LeadCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Models\Kos;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class LeadController extends Controller
{
    public function __construct(
        protected LeadService $leadService
    ) {}

    public function track(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
        ]);

        $kos = Kos::findOrFail($validated['kos_id']);
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $userId = auth()->check() ? auth()->id() : null;

        $rateLimitKey = "lead_track:{$ipAddress}:{$kos->id}";

        if (RateLimiter::tooManyAttempts($rateLimitKey, 10)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'error' => 'Terlalu banyak request. Coba lagi dalam beberapa menit.',
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($rateLimitKey, 3600);

        $dedupeKey = "lead_dedupe:{$ipAddress}:{$kos->id}:" . now()->startOfHour()->timestamp;

        if (Cache::has($dedupeKey)) {
            return $this->redirectToWhatsApp($kos);
        }

        $lead = $this->leadService->trackLead($kos->id, $userId, $ipAddress, $userAgent);

        if ($lead) {
            LeadCreated::dispatch($lead, $kos);
        }

        Cache::put($dedupeKey, true, now()->addHour());

        return $this->redirectToWhatsApp($kos);
    }

    public function redirect(string $slug)
    {
        $kos = Kos::where('slug', $slug)->firstOrFail();
        $waUrl = $this->leadService->getWhatsAppUrl($kos);

        return redirect($waUrl);
    }

    protected function redirectToWhatsApp(Kos $kos): JsonResponse
    {
        $waUrl = $this->leadService->getWhatsAppUrl($kos);

        return response()->json([
            'success' => true,
            'redirect_url' => $waUrl,
        ]);
    }
}
