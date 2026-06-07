<?php

namespace Database\Seeders;

use App\Models\ReportType;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Data Tidak Akurat', 'slug' => 'inaccurate', 'description' => 'Informasi kos tidak sesuai dengan kenyataan'],
            ['name' => 'Review Palsu', 'slug' => 'fake', 'description' => 'Review yang diragukan kebenarannya'],
            ['name' => 'Konten Tidak Pantas', 'slug' => 'inappropriate', 'description' => 'Konten yang mengandung SARA atau tidak pantas'],
            ['name' => 'Spam', 'slug' => 'spam', 'description' => 'Konten spam atau tidak relevan'],
            ['name' => 'Lainnya', 'slug' => 'other', 'description' => 'Laporan lainnya'],
        ];

        foreach ($types as $type) {
            ReportType::firstOrCreate(['slug' => $type['slug']], $type);
        }
    }
}