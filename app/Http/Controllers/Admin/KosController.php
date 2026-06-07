<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Services\NotificationService;
use App\Services\KosService;
use Illuminate\Http\Request;

class KosController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService,
        protected KosService $kosService
    ) {}

    public function index(Request $request)
    {
        $query = Kos::with(['owner', 'photos', 'facilities']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('address', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $kos = $query->latest()->paginate(20);

        // Get status counts for tabs
        $statusCounts = [
            'total' => Kos::count(),
            'pending' => Kos::where('status', 'pending')->count(),
            'active' => Kos::where('status', 'active')->count(),
            'rejected' => Kos::where('status', 'rejected')->count(),
        ];

        return view('adminVerifikasi', compact('kos', 'statusCounts'));
    }

    public function approve(Kos $kos, NotificationService $notificationService)
    {
        $previousStatus = $kos->status;

        $kos->update([
            'status' => 'active',
            'is_active' => true,
        ]);

        // Send notification to owner
        if ($previousStatus === 'pending') {
            $notificationService->createNotification(
                $kos->owner,
                'kos_approved',
                'Kos Diterima! 🎉',
                "Properti kos '{$kos->name}' telah diverifikasi dan kini bisa dilihat oleh mahasiswa.",
                [
                    'kos_id' => $kos->id,
                    'kos_slug' => $kos->slug,
                    'kos_name' => $kos->name,
                    'status' => 'active',
                ]
            );
        }

        $this->kosService->clearKosCache();

        return redirect()
            ->back()
            ->with('success', "Kos '{$kos->name}' berhasil disetujui dan dipublikasikan!");
    }

    public function reject(Request $request, Kos $kos, NotificationService $notificationService)
    {
        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $previousStatus = $kos->status;

        $kos->update([
            'status' => 'rejected',
        ]);

        // Send notification to owner
        if ($previousStatus === 'pending') {
            $notificationService->createNotification(
                $kos->owner,
                'kos_rejected',
                'Kos Ditolak',
                "Mohon maaf, properti kos '{$kos->name}' tidak memenuhi syarat verifikasi. " . ($validated['reason'] ? "Alasan: {$validated['reason']}" : "Silakan perbaiki data dan ajukan ulang."),
                [
                    'kos_id' => $kos->id,
                    'kos_slug' => $kos->slug,
                    'kos_name' => $kos->name,
                    'status' => 'rejected',
                    'rejection_reason' => $validated['reason'] ?? null,
                ]
            );
        }

        $this->kosService->clearKosCache();

        return redirect()
            ->back()
            ->with('success', "Kos '{$kos->name}' ditolak. " . ($validated['reason'] ? "Owner akan diberi tahu." : ""));
    }

    public function togglePremium(Kos $kos)
    {
        $newStatus = !$kos->is_premium;
        $kos->update([
            'is_premium' => $newStatus,
            'premium_expires_at' => $newStatus ? now()->addMonth() : null,
        ]);

        $this->kosService->clearKosCache();

        $message = $newStatus
            ? "Kos '{$kos->name}' kini menjadi Premium."
            : "Status Premium kos '{$kos->name}' dicabut.";

        return redirect()->back()->with('success', $message);
    }
}
