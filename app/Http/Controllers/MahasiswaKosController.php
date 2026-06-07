<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\View\View;

class MahasiswaKosController extends Controller
{
    public function index(): View
    {
        $kosData = Kos::with(['facilities', 'photos'])->get()->map(function ($kos) {
            return [
                'id' => $kos->id,
                'name' => $kos->name,
                'slug' => $kos->slug,
                'price_number' => $kos->price_number,
                'rating' => $kos->rating,
                'loc' => $kos->location,
                'type' => ucfirst($kos->gender),  // Capitalize for filter match (Putra/Putri/Campur)
                'fac' => $kos->facilities->pluck('name')->toArray(),
                'img' => $kos->photos->first()?->url ?? 'https://picsum.photos/800/600',
                'verified' => (bool) $kos->is_verified,
                'stock' => $kos->stock,
                'campus' => $kos->campus ?? '',
                'whatsappNumber' => $kos->owner?->whatsapp ?? '',
            ];
        });

        return view('mahasiswaCariKos', compact('kosData'));
    }
}
