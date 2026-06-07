<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kos;
use App\Models\Review;
use App\Services\KosService;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KosController extends Controller
{
    public function index(Request $request)
    {
        // Only show verified (active) kos
        $query = Kos::active()
            ->with([
                'photos' => fn($q) => $q->orderBy('order'),
                'facilities',
            ])
            ->premiumFirst();

        // Apply filters
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }
        if ($request->filled('gender')) {
            $query->byGender($request->input('gender'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (int) $request->input('price_max'));
        }

        $kos = $query->get();

        // Transform for Alpine.js
        $kosData = $kos->map(function($k) {
            $facilities = $k->facilities->pluck('name')->toArray();
            $primaryPhoto = $k->photos->first();
            return [
                'id' => $k->id,
                'slug' => $k->slug,
                'name' => $k->name,
                'price_number' => $k->price,
                'rating' => $k->average_rating ? number_format($k->average_rating, 1) : '0.0',
                'loc' => $k->address,
                'campus' => $k->address,
                'type' => ucfirst($k->gender),
                'fac' => $facilities,
                'verified' => $k->status === 'active' && $k->is_active,
                'image' => $this->resolveImageUrl($primaryPhoto?->url),
                'img' => $this->resolveImageUrl($primaryPhoto?->url),
                'stock' => $k->available_rooms ?? 0,
                'whatsappNumber' => $k->whatsapp ?? '',
            ];
        })->values();

        return view('mahasiswaCariKos', compact('kos', 'kosData'));
    }

    public function bookings(Request $request)
    {
        $status = $request->input('status');
        $search = trim((string) $request->input('search'));

        $query = Booking::with([
                'kos.photos' => fn ($query) => $query->orderBy('order'),
                'kos.owner',
            ])
            ->where('user_id', Auth::id())
            ->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($relation) use ($search) {
                $relation->whereHas('kos', fn ($kos) => $kos->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('kos', fn ($kos) => $kos->where('address', 'like', "%{$search}%"))
                    ->orWhereHas('kos.owner', fn ($owner) => $owner->where('name', 'like', "%{$search}%"));
            });
        }

        $bookings = $query->get();

        $bookingsData = $bookings->map(function (Booking $booking) {
            $kos = $booking->kos;
            $photo = $kos?->photos->first();

            return [
                'id' => $booking->id,
                'kos_slug' => $kos?->slug,
                'kos_name' => $kos?->name ?? '-',
                'kos_address' => $kos?->address ?? '-',
                'photo' => $this->resolveImageUrl($photo?->url),
                'status' => $booking->status,
                'status_label' => $this->bookingStatusLabel($booking->status),
                'status_class' => $this->bookingStatusClass($booking->status),
                'price' => $kos?->price ?? 0,
                'move_in_date' => $booking->move_in_date?->format('d M Y'),
                'duration_months' => $booking->duration_months,
                'owner_name' => $kos?->owner?->name ?? '-',
                'owner_phone' => $kos?->owner?->phone ?? '',
                'created_at' => $booking->created_at?->format('d M Y H:i'),
                'rejection_reason' => $booking->rejection_reason,
            ];
        })->values();

        return view('mahasiswaBooking', [
            'bookings' => $bookings,
            'bookingsData' => $bookingsData,
            'counts' => [
                'total' => $bookings->count(),
                'pending' => $bookings->where('status', 'pending')->count(),
                'approved' => $bookings->where('status', 'approved')->count(),
                'rejected' => $bookings->where('status', 'rejected')->count(),
            ],
            'filters' => [
                'status' => $status,
                'search' => $search,
            ],
        ]);
    }

    public function show(string $slug, KosService $kosService)
    {
        $kos = $kosService->getKosBySlug($slug);

        if (!$kos->is_active || $kos->status !== 'active') {
            abort(404);
        }

        $nearbyKos = $kosService->getNearbyKos($kos);

        return view('mahasiswaDetailKos', compact('kos', 'nearbyKos'));
    }

    protected function resolveImageUrl(?string $path): string
    {
        if (!$path) {
            return asset('images/kos-placeholder.png');
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    protected function bookingStatusLabel(string $status): string
    {
        return match ($status) {
            'approved' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }

    protected function bookingStatusClass(string $status): string
    {
        return match ($status) {
            'approved' => 'bg-emerald-100 text-emerald-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-orange-100 text-orange-700',
        };
    }

    public function reviews(Request $request, ReviewService $reviewService)
    {
        $userId = Auth::id();
        $status = $request->input('status');

        $query = Review::where('user_id', $userId)
            ->with(['kos.photos' => fn($q) => $q->orderBy('order')])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest();

        // Filter by status
        if ($status && in_array($status, [Review::STATUS_PENDING, Review::STATUS_APPROVED, Review::STATUS_REJECTED], true)) {
            $query->where('status', $status);
        }

        $reviews = $query->get();

        $reviewCounts = [
            'total' => Review::where('user_id', $userId)->count(),
            'pending' => Review::where('user_id', $userId)->where('status', Review::STATUS_PENDING)->count(),
            'approved' => Review::where('user_id', $userId)->where('status', Review::STATUS_APPROVED)->count(),
            'rejected' => Review::where('user_id', $userId)->where('status', Review::STATUS_REJECTED)->count(),
        ];

        return view('mahasiswaReview', [
            'reviews' => $reviews,
            'reviewCounts' => $reviewCounts,
        ]);
    }
}
