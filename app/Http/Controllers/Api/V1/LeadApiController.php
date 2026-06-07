<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\LeadCreated;
use App\Http\Controllers\Controller;
use App\Http\ApiRes\ApiResponse;
use App\Http\Resources\LeadResource;
use App\Models\Kos;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadApiController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected LeadService $leadService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kos_id' => 'nullable|integer|exists:kos,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Lead::with('kos');

        if (!empty($validated['kos_id'])) {
            $query->forKos($validated['kos_id']);
        }

        if (!empty($validated['from_date']) && !empty($validated['to_date'])) {
            $query->inDateRange($validated['from_date'], $validated['to_date']);
        }

        $leads = $query->latest()->paginate($validated['per_page'] ?? 15);

        return $this->paginate($leads);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kos_id' => 'required|integer|exists:kos,id',
        ]);

        $kos = Kos::findOrFail($validated['kos_id']);

        $userId = $request->user()?->id;
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        $lead = $this->leadService->trackLead($kos->id, $userId, $ipAddress, $userAgent);

        if (!$lead) {
            return $this->error('Gagal membuat lead. Kemungkinan quota tercapai atau rate limit.', 429);
        }

        $waUrl = $this->leadService->getWhatsAppUrl($kos);

        LeadCreated::dispatch($lead, $kos);

        return $this->success([
            'lead' => new LeadResource($lead),
            'redirect_url' => $waUrl,
        ], 'Lead berhasil dibuat', 201);
    }

    public function show(int $id): JsonResponse
    {
        $lead = Lead::with('kos', 'user')->findOrFail($id);

        return $this->success(new LeadResource($lead));
    }

    public function stats(Request $request, int $kosId): JsonResponse
    {
        $kos = Kos::findOrFail($kosId);

        $stats = $this->leadService->getLeadStats($kosId);
        $dailyCounts = $this->leadService->getDailyLeadCounts($kosId);

        return $this->success([
            'kos_id' => $kosId,
            'kos_name' => $kos->name,
            'stats' => $stats,
            'daily_counts' => $dailyCounts,
        ]);
    }

    public function markConverted(int $id): JsonResponse
    {
        $lead = Lead::findOrFail($id);

        $this->leadService->markAsConverted($lead);

        return $this->success(new LeadResource($lead->fresh()), 'Lead ditandai sebagai dikonversi');
    }
}