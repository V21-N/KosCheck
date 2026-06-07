<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with('advertiser');

        if ($request->filled('status')) {
            match ($request->input('status')) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'expired' => $query->where('end_date', '<', now()),
                default => null,
            };
        }

        $ads = $query->latest()->paginate(20);

        return view('adminIklan', compact('ads'));
    }

    public function approve(Ad $ad)
    {
        $ad->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Iklan berhasil diaktifkan.');
    }

    public function reject(Ad $ad)
    {
        $ad->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Iklan berhasil dinonaktifkan.');
    }
}
