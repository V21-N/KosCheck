<?php

namespace Database\Seeders;

use App\Models\LocalBusiness;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LocalBusinessSeeder extends Seeder
{
    public function run(): void
    {
        $ownerUsers = User::where('role', 'owner')->get();

        $businesses = [
            [
                'user_id' => $ownerUsers->first()?->id,
                'name' => 'Laundry Kiloan Sehat',
                'category' => 'laundry',
                'description' => 'Laundry kiloan cepat dan bersih. Gratis antar jemput untuk area kos sekitar.',
                'whatsapp' => '6281234568001',
                'address' => 'Jl. Pancing No. 5, Medan',
                'latitude' => 3.5985,
                'longitude' => 98.6812,
                'is_verified' => true,
            ],
            [
                'user_id' => $ownerUsers->skip(1)->first()?->id,
                'name' => 'Warung Makan Bu Tini',
                'category' => 'catering',
                'description' => 'Catering masakan rumahan dengan harga terjangkau. Menu harian dan mingguan.',
                'whatsapp' => '6281234568002',
                'address' => 'Jl. Sisingamangaraja No. 15, Medan',
                'latitude' => 3.5912,
                'longitude' => 98.6756,
                'is_verified' => true,
            ],
            [
                'user_id' => $ownerUsers->skip(2)->first()?->id,
                'name' => 'Internet WiFi Cepat',
                'category' => 'internet',
                'description' => 'Paket internet unlimited untuk kos. Instalasi gratis dan support 24 jam.',
                'whatsapp' => '6281234568003',
                'address' => 'Jl. HM Jhoni No. 20, Medan',
                'latitude' => 3.5941,
                'longitude' => 98.6712,
                'is_verified' => true,
            ],
            [
                'user_id' => $ownerUsers->skip(3)->first()?->id,
                'name' => 'Jasa Pindahan Aman',
                'category' => 'moving_service',
                'description' => 'Jasa pindahan khusus kos mahasiswa. Harga bersahabat, hati-hati terhadap barang.',
                'whatsapp' => '6281234568004',
                'address' => 'Jl. Ahmad Yani No. 30, Medan',
                'latitude' => 3.5876,
                'longitude' => 98.6698,
                'is_verified' => true,
            ],
            [
                'user_id' => $ownerUsers->skip(4)->first()?->id,
                'name' => 'Apotek Sehat',
                'category' => 'pharmacy',
                'description' => 'Apotek lengkap dengan obat-obatan umum. Buka 24 jam untuk kebutuhan darurat.',
                'whatsapp' => '6281234568005',
                'address' => 'Jl. Sudirman No. 50, Medan',
                'latitude' => 3.5894,
                'longitude' => 98.6731,
                'is_verified' => true,
            ],
        ];

        foreach ($businesses as $business) {
            LocalBusiness::create($business);
        }
    }
}
