<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['reportType', 'reporter', 'reviewable'])
            ->pending()
            ->latest()
            ->paginate(20);

        return view('adminReports', compact('reports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type_id' => 'required|exists:report_types,id',
            'reportable_type' => 'required|string',
            'reportable_id' => 'required|integer',
            'description' => 'nullable|string|max:500',
        ]);

        Report::create([
            'report_type_id' => $validated['report_type_id'],
            'reportable_type' => $validated['reportable_type'],
            'reportable_id' => $validated['reportable_id'],
            'user_id' => auth()->id(),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Report berhasil dikirim. Tim kami akan meninjaunya.');
    }

    public function resolve(Report $report)
    {
        $report->resolve();

        return redirect()->back()->with('success', 'Report berhasil diselesaikan.');
    }

    public function dismiss(Report $report)
    {
        $report->dismiss();

        return redirect()->back()->with('success', 'Report berhasil ditolak.');
    }
}
