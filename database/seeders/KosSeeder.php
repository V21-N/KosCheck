<?php

namespace Database\Seeders;

use App\Models\Kos;
use App\Models\Photo;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class KosSeeder extends Seeder
{
    public function run(): void
    {
        $owners = User::where('role', 'owner')->get();
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        $kosData = [
            [
                'name' => 'Kos Melati Indah',
                'address' => 'Jl. Merdeka No. 15, Medan',
                'latitude' => 3.5952,
                'longitude' => 98.6722,
                'price' => 800000,
                'gender' => 'putri',
                'description' => 'Kos nyaman dengan suasana tenang, cocok untuk mahasiswa. Lokasi strategis dekat kampus USU dan UNIMED. Akses jalan mudah, lingkungan aman dengan keamanan 24 jam.',
                'whatsapp' => '6281234567890',
                'is_premium' => true,
                'premium_expires_at' => now()->addMonths(3),
            ],
            [
                'name' => 'Kos Anggrek Residence',
                'address' => 'Jl. Sudirman No. 42, Medan',
                'latitude' => 3.5894,
                'longitude' => 98.6731,
                'price' => 650000,
                'gender' => 'putra',
                'description' => 'Kos putra minimalis dengan fasilitas lengkap. Dilengkapi AC, WiFi, dan kamar mandi dalam. Lokasi strategis di pusat kota Medan.',
                'whatsapp' => '6281234567891',
                'is_premium' => true,
                'premium_expires_at' => now()->addMonths(2),
            ],
            [
                'name' => 'Kos Cemara Asri',
                'address' => 'Jl. Pancing No. 8, Medan',
                'latitude' => 3.5985,
                'longitude' => 98.6812,
                'price' => 550000,
                'gender' => 'campur',
                'description' => 'Kos campur dengan harga terjangkau. Fasilitas dasar tersedia: WiFi, parkir, dan dapur bersama. Lingkungan asri dan nyaman.',
                'whatsapp' => '6281234567892',
            ],
            [
                'name' => 'Kos Kenanga Family',
                'address' => 'Jl. Ahmad Yani No. 25, Medan',
                'latitude' => 3.5876,
                'longitude' => 98.6698,
                'price' => 1200000,
                'gender' => 'putri',
                'description' => 'Kos premium untuk mahasiswa dengan standar hotel. Fasilitas lengkap termasuk AC, WiFi, TV, dan laundry. Keamanan terjamin dengan CCTV.',
                'whatsapp' => '6281234567893',
                'is_premium' => true,
                'premium_expires_at' => now()->addMonths(4),
            ],
            [
                'name' => 'Kos Mawar Bersinar',
                'address' => 'Jl. Sisingamangaraja No. 11, Medan',
                'latitude' => 3.5912,
                'longitude' => 98.6756,
                'price' => 450000,
                'gender' => 'putra',
                'description' => 'Kos putra ekonomis dekat kampus. Fasilitas: WiFi, akses 24 jam, parkir luas. Lingkungan aman dan bersih.',
                'whatsapp' => '6281234567894',
            ],
            [
                'name' => 'Kos Flamboyan Premium',
                'address' => 'Jl. HM Jhoni No. 33, Medan',
                'latitude' => 3.5941,
                'longitude' => 98.6712,
                'price' => 950000,
                'gender' => 'campur',
                'description' => 'Kos premium campur dengan lokasi strategis. Dekat dengan pusat perbelanjaan dan akses transportasi umum. Fasilitas lengkap.',
                'whatsapp' => '6281234567895',
                'is_premium' => true,
                'premium_expires_at' => now()->addMonths(2),
            ],
            [
                'name' => 'Kos Teratai Hijau',
                'address' => 'Jl. Imam Bonjol No. 7, Medan',
                'latitude' => 3.5968,
                'longitude' => 98.6689,
                'price' => 700000,
                'gender' => 'putri',
                'description' => 'Kos putri dengan nuansa asri dan tenang. Dilengkapi WiFi, AC, dan kamar mandi dalam. Keamanan 24 jam dengan akses kartu.',
                'whatsapp' => '6281234567896',
                'is_premium' => true,
                'premium_expires_at' => now()->addMonths(3),
            ],
            [
                'name' => 'Kos Dahlia Residence',
                'address' => 'Jl. S. Parman No. 56, Medan',
                'latitude' => 3.5923,
                'longitude' => 98.6778,
                'price' => 580000,
                'gender' => 'putra',
                'description' => 'Kos putra nyaman dengan fasilitas lengkap. Lokasi sangat strategis dekat dengan rumah sakit dan universitas.',
                'whatsapp' => '6281234567897',
            ],
        ];

        foreach ($kosData as $index => $data) {
            $owner = $owners->get($index % $owners->count());

            $kos = Kos::create([
                'user_id' => $owner->id,
                'name' => $data['name'],
                'slug' => Kos::generateUniqueSlug($data['name']),
                'address' => $data['address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'price' => $data['price'],
                'gender' => $data['gender'],
                'description' => $data['description'],
                'whatsapp' => $data['whatsapp'],
                'status' => 'active',
                'is_premium' => $data['is_premium'] ?? false,
                'premium_expires_at' => $data['premium_expires_at'] ?? null,
                'is_active' => true,
            ]);

            // Add default facilities
            $facilityIds = [1, 2, 3, 5, 6]; // WiFi, AC, Kamar Mandi Dalam, Akses 24 Jam, Parkir Motor
            $kos->facilities()->attach($facilityIds);

            // Create sample photos
            for ($i = 1; $i <= 3; $i++) {
                Photo::create([
                    'kos_id' => $kos->id,
                    'url' => "https://picsum.photos/seed/{$kos->id}_{$i}/800/600",
                    'order' => $i,
                    'is_primary' => $i === 1,
                ]);
            }

            // Create sample reviews
            foreach ($mahasiswas->random(2) as $mahasiswa) {
                Review::create([
                    'kos_id' => $kos->id,
                    'user_id' => $mahasiswa->id,
                    'rating' => rand(4, 5),
                    'rating_cleanliness' => rand(4, 5),
                    'rating_security' => rand(4, 5),
                    'rating_facilities' => rand(3, 5),
                    'comment' => $this->getRandomComment(),
                    'is_visible' => true,
                ]);
            }
        }
    }

    private function getRandomComment(): string
    {
        $comments = [
            'Kos sangat nyaman dan bersih. Pemilik ramah dan responsif. Sangat direkomendasikan!',
            'Lokasi strategis dan fasilitas lengkap. Harga sesuai dengan kualitas. Mantap!',
            'Kamar luas dengan AC yang dingin. WiFi cepat dan stabil. Lingkungan aman dan tenang.',
            'Pelayanan sangat baik. Pemilik fast response. Kos-nya sesuai dengan foto di aplikasi.',
            'Sudah tinggal 3 bulan di sini, sangat puas. Kamar mandi selalu bersih dan tidak ada masalah.',
            'Dekat dengan kampus dan akses transportasi mudah. Harga terjangkau untuk fasilitas yang diberikan.',
            'Keamanan terjamin dengan akses kartu dan CCTV. Parkir luas untuk motor maupun mobil.',
            'Pemilik kos sangat helpful dan mau membantu kalau ada masalah. Recomended!',
            'Nyaman untuk belajar. Suasana tenang dan tidak bising. WiFi juga kencang untuk kerja.',
        ];

        return $comments[array_rand($comments)];
    }
}