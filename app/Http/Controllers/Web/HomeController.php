<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Services\KosService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected KosService $kosService
    ) {}

    public function index(Request $request)
    {
        $featuredKos = $this->kosService->getFeaturedKos(8);
        $recentKos = $this->kosService->getRecentKos(6);

        $stats = $this->kosService->getKosStats();

        $ads = Ad::activeForPosition('homepage')
            ->byArea($request->query('area'))
            ->limit(3)
            ->get();

        return view('landingPage', compact('featuredKos', 'recentKos', 'stats', 'ads'));
    }
}