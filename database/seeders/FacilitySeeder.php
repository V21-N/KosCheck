<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['name' => 'WiFi', 'icon' => 'wifi', 'slug' => 'wifi'],
            ['name' => 'AC', 'icon' => 'ac', 'slug' => 'ac'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'bathroom', 'slug' => 'bathroom_in'],
            ['name' => 'Kamar Mandi Luar', 'icon' => 'bathroom', 'slug' => 'bathroom_out'],
            ['name' => 'Akses 24 Jam', 'icon' => 'clock', 'slug' => '24_hour'],
            ['name' => 'Parkir Motor', 'icon' => 'parking', 'slug' => 'parking_motor'],
            ['name' => 'Parkir Mobil', 'icon' => 'parking', 'slug' => 'parking_car'],
            ['name' => 'Dapur', 'icon' => 'kitchen', 'slug' => 'kitchen'],
            ['name' => 'Laundry', 'icon' => 'laundry', 'slug' => 'laundry'],
            ['name' => 'CCTV', 'icon' => 'cctv', 'slug' => 'cctv'],
            ['name' => 'Keamanan 24 Jam', 'icon' => 'security', 'slug' => 'security'],
            ['name' => 'TV', 'icon' => 'tv', 'slug' => 'tv'],
            ['name' => 'Kipas Angin', 'icon' => 'fan', 'slug' => 'fan'],
            ['name' => 'Spring Bed', 'icon' => 'bed', 'slug' => 'bed'],
            ['name' => 'Lemari Pakaian', 'icon' => 'wardrobe', 'slug' => 'wardrobe'],
            ['name' => 'Meja Belajar', 'icon' => 'desk', 'slug' => 'desk'],
            ['name' => 'Air PAM', 'icon' => 'water', 'slug' => 'water'],
            ['name' => 'Air Galon', 'icon' => 'water', 'slug' => 'water_gallon'],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate(['slug' => $facility['slug']], $facility);
        }
    }
}