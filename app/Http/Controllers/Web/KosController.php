<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Booking;
use App\Services\NotificationService;
use App\Services\KosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KosController extends Controller
{
    public function __construct(
        protected KosService $kosService
    ) {}

    public function index(Request $request)
    {
        $kos = $this->kosService->getActiveKos($request);

        $ads = Ad::activeForPosition('search_result')
            ->byArea($request->query('area'))
            ->limit(5)
            ->get();

        // Transform for Alpine.js - handle both paginated and collection
        $kosData = collect($kos->items())->map(function($k) {
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
                'is_premium' => $k->isPremium(),
                'image' => $this->resolveImageUrl($primaryPhoto?->url),
                'img' => $this->resolveImageUrl($primaryPhoto?->url),
                'stock' => $k->available_rooms ?? 0,
                'whatsappNumber' => $k->whatsapp ?? '',
            ];
        })->values();

        return view('cariKos', compact('kos', 'kosData', 'ads'));
    }

    public function show(string $slug)
    {
        $kos = $this->kosService->getKosBySlug($slug);

        if (!$kos->is_active && !auth()->check()) {
            abort(404);
        }

        $nearbyKos = $this->kosService->getNearbyKos($kos);

        return view('detailKos', compact('kos', 'nearbyKos'));
    }

    public function booking(string $slug)
    {
        $kos = $this->kosService->getKosBySlug($slug);
        $kos->load(['photos', 'facilities', 'owner']);

        if (!$kos->is_active && !auth()->check()) {
            abort(404);
        }

        return view('bookingKos', [
            'kos' => $kos,
            'owner' => $kos->owner,
            'user' => auth()->user(),
        ]);
    }

    public function bookingStore(Request $request, string $slug, NotificationService $notificationService)
    {
        $kos = $this->kosService->getKosBySlug($slug);
        $user = $request->user();

        if (!$user || !$user->isMahasiswa()) {
            abort(403);
        }

        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:20'],
            'university' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'in:L,P'],
            'move_in_date' => ['required', 'date', 'after_or_equal:today'],
            'duration_months' => ['required', 'in:1,3,6,12'],
        ]);

        [$booking, $created] = DB::transaction(function () use ($kos, $user, $validated) {
            $existing = Booking::where('user_id', $user->id)
                ->where('kos_id', $kos->id)
                ->first();

            if ($existing) {
                $existing->update([
                    'phone' => $validated['phone'] ?? $user->phone,
                    'university' => $validated['university'] ?? $user->university,
                    'gender' => $validated['gender'],
                    'move_in_date' => $validated['move_in_date'],
                    'duration_months' => (int) $validated['duration_months'],
                ]);

                return [$existing, false];
            }

            return [Booking::create([
                'user_id' => $user->id,
                'kos_id' => $kos->id,
                'status' => 'pending',
                'phone' => $validated['phone'] ?? $user->phone,
                'university' => $validated['university'] ?? $user->university,
                'gender' => $validated['gender'],
                'move_in_date' => $validated['move_in_date'],
                'duration_months' => (int) $validated['duration_months'],
            ]), true];
        });

        $owner = $kos->owner;
        if ($created && $owner) {
            $notificationService->createNotification(
                $owner,
                'booking',
                'Booking Baru',
                $user->name . ' mengajukan booking untuk ' . $kos->name,
                [
                    'booking_id' => $booking->id,
                    'kos_id' => $kos->id,
                    'kos_slug' => $kos->slug,
                    'mahasiswa_id' => $user->id,
                    'mahasiswa_name' => $user->name,
                    'mahasiswa_phone' => $validated['phone'] ?? $user->phone,
                    'mahasiswa_university' => $validated['university'] ?? $user->university,
                    'mahasiswa_gender' => $validated['gender'],
                    'move_in_date' => $validated['move_in_date'],
                    'duration_months' => $validated['duration_months'],
                    'status' => $booking->status,
                ]
            );
        }

        return redirect()
            ->route('student.booking')
            ->with('success', $created
                ? 'Permintaan booking berhasil dikirim ke pemilik kos.'
                : 'Kamu sudah pernah mengajukan booking untuk kos ini.');
    }

    protected function resolveImageUrl(?string $path): string
    {
        return resolve_image_url($path);
    }
}
