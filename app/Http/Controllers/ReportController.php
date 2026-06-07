<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with(['user', 'reportable'])
            ->latest()
            ->paginate(20);

        return view('adminReports', compact('reports'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'target_id' => 'nullable|integer',
            'target_type' => 'required|in:kos,review,user,listing',
            'report_type' => 'required|in:fraud,fake_photo,spam,inappropriate,fake_review,other',
            'description' => 'required|string|min:20|max:500',
            'contact_phone' => 'nullable|string|max:15',
            'evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:5120',
        ]);

        $reportId = 'RPT-' . strtoupper(substr(md5(uniqid()), 0, 8));

        $report = Report::create([
            'report_id' => $reportId,
            'user_id' => auth()->id(),
            'target_id' => $validated['target_id'],
            'target_type' => $validated['target_type'],
            'report_type' => $validated['report_type'],
            'description' => $validated['description'],
            'contact_phone' => $validated['contact_phone'] ?? null,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->hasFile('evidence')) {
            $files = $request->file('evidence');
            foreach ($files as $file) {
                $filename = $reportId . '_' . time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('reports', $filename, 'public');
                Log::info("Report file uploaded: {$path}");
            }
        }

        Log::info("Report submitted: {$reportId}", [
            'type' => $validated['report_type'],
            'target' => $validated['target_type'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim. Tim kami akan memproses dalam 1x24 jam.',
            'report_id' => $reportId,
        ]);
    }

    public function resolve(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => 'resolved',
            'admin_notes' => $validated['notes'] ?? null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', "Laporan #{$report->report_id} berhasil diselesaikan.");
    }

    public function dismiss(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => 'dismissed',
            'admin_notes' => $validated['notes'] ?? null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', "Laporan #{$report->report_id} ditolak/dismiss.");
    }
}
