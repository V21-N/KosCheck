<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kos;
use App\Models\Lead;
use App\Models\Review;
use App\Models\User;
use App\Models\Report;
use App\Models\Ad;
use App\Models\LocalBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_kos' => Kos::count(),
            'active_kos' => Kos::where('is_active', true)->where('status', 'active')->count(),
            'pending_kos' => Kos::where('status', 'pending')->count(),
            'total_leads' => Lead::count(),
            'leads_this_month' => Lead::thisMonth()->count(),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::where('is_flagged', true)->orWhere('is_visible', false)->count(),
            'total_reports' => Report::count(),
            'pending_reports' => Report::pending()->count(),
        ];

        // Recent Kos for verification (5 latest)
        $recentKos = Kos::with(['owner', 'photos'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent pending reports
        $recentReports = Report::with(['reportType', 'reporter'])
            ->pending()
            ->latest()
            ->limit(5)
            ->get();

        // Flagged reviews needing moderation
        $recentReviews = Review::with(['user', 'kos'])
            ->where(function($query) {
                $query->where('is_flagged', true)
                    ->orWhere('is_visible', false);
            })
            ->latest()
            ->limit(5)
            ->get();

        // Top Kos by leads
        $topKos = Kos::with(['owner', 'photos'])
            ->withCount('leads')
            ->orderBy('leads_count', 'desc')
            ->limit(5)
            ->get();

        return view('adminDashboard', compact(
            'stats',
            'recentKos',
            'recentReports',
            'recentReviews',
            'topKos'
        ));
    }
}
