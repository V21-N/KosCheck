<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $ads = [
            [
                'name' => "Laundry Kiloan Medan",
                'image_url' => 'https://picsum.photos/seed/laundry1/400/200',
                'target_url' => 'https://wa.me/6281234567001',
                'position' => 'homepage',
                'area' => 'medan',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth()->addMonths(3),
                'is_active' => true,
            ],
            [
                'name' => 'Catering Masakan Rumahan',
                'image_url' => 'https://picsum.photos/seed/catering1/400/200',
                'target_url' => 'https://wa.me/6281234567002',
                'position' => 'homepage',
                'area' => 'medan',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth()->addMonths(2),
                'is_active' => true,
            ],
            [
                'name' => 'Internet WiFi Unlimited',
                'image_url' => 'https://picsum.photos/seed/wifi1/400/200',
                'target_url' => 'https://wa.me/6281234567003',
                'position' => 'search_result',
                'area' => 'medan',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth()->addMonths(1),
                'is_active' => true,
            ],
            [
                'name' => 'Jasa Pindahan Kos',
                'image_url' => 'https://picsum.photos/seed/pindahan1/400/200',
                'target_url' => 'https://wa.me/6281234567004',
                'position' => 'kos_detail',
                'area' => 'medan',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth()->addMonths(2),
                'is_active' => true,
            ],
            [
                'name' => 'Minimarket Dekat Kos',
                'image_url' => 'https://picsum.photos/seed/minimart1/400/200',
                'target_url' => 'https://wa.me/6281234567005',
                'position' => 'search_result',
                'area' => 'medan',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth()->addMonths(3),
                'is_active' => true,
            ],
        ];

        foreach ($ads as $ad) {
            Ad::create($ad);
        }
    }
}
