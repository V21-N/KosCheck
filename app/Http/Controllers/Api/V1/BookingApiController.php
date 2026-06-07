<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingApiController extends Controller
{
    /**
     * Mahasiswa: Create a booking request
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kos_id' => 'required|exists:kos,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $kosId = $request->kos_id;

        // Check existing booking
        $existing = Booking::where('user_id', $user->id)
            ->where('kos_id', $kosId)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return response()->json(['message' => 'You already have an active booking for this kos'], 409);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'kos_id' => $kosId,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking request submitted',
            'booking' => $booking->load('kos:id,name,slug'),
        ], 201);
    }

    /**
     * Mahasiswa: Get my bookings
     */
    public function myBookings(Request $request): JsonResponse
    {
        $bookings = $request->user()->bookings()
            ->with('kos:id,name,slug,address')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(compact('bookings'));
    }

    /**
     * Owner: Get incoming booking requests for their kos
     */
    public function ownerIndex(Request $request): JsonResponse
    {
        $bookings = Booking::forOwner($request->user()->id)
            ->with('mahasiswa:id,name,email,phone,university', 'kos:id,name,slug')
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($bookings);
    }

    /**
     * Owner: Approve or reject a booking
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|max:500',
        ], [
            'rejection_reason.required_if' => 'Rejection reason is required when rejecting a booking.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $booking = Booking::whereHas('kos', fn($q) => $q->where('user_id', $request->user()->id))
            ->findOrFail($id);

        if (!$booking->isPending()) {
            return response()->json(['message' => 'Booking already processed'], 400);
        }

        $booking->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        return response()->json([
            'message' => "Booking {$request->status} successfully",
            'booking' => $booking->load('mahasiswa:id,name,email', 'kos:id,name,slug'),
        ]);
    }

    /**
     * Admin: Global booking statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::pending()->count(),
            'approved' => Booking::approved()->count(),
            'rejected' => Booking::rejected()->count(),
            'approval_rate' => Booking::count() > 0
                ? round(Booking::approved()->count() / Booking::count() * 100, 1)
                : 0,
        ];

        return response()->json($stats);
    }

    /**
     * Admin: List all bookings with filters
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $bookings = Booking::with('mahasiswa:id,name,email,role', 'kos:id,name,slug,user_id')
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->owner_id, fn($q, $id) => $q->whereHas('kos', fn($qq) => $qq->where('user_id', $id)))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($bookings);
    }
}
