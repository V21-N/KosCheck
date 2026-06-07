<?php

namespace Database\Seeders;

use App\Models\Kos;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $kosList = Kos::with('owner')->get();
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        $comments = [
            'Kos sangat nyaman dan bersih. Pemilik ramah dan responsif.',
            'Lokasi strategis dan fasilitas lengkap. Harga sesuai dengan kualitas.',
            'Kamar luas dengan AC yang dingin. WiFi cepat dan stabil.',
            'Pelayanan sangat baik. Pemilik fast response. Sesuai dengan foto.',
            'Sudah tinggal 3 bulan di sini, sangat puas. Kamar mandi selalu bersih.',
            'Dekat dengan kampus dan akses transportasi mudah.',
            'Keamanan terjamin dengan akses kartu dan CCTV.',
            'Pemilik kos sangat helpful. Recomended!',
            'Nyaman untuk belajar. Suasana tenang dan tidak bising.',
        ];

        // Generate additional reviews per kos (skip if already exists)
        foreach ($kosList as $kos) {
            $existingReviews = Review::where('kos_id', $kos->id)->pluck('user_id')->toArray();
            $availableMahasiswas = $mahasiswas->whereNotIn('id', $existingReviews);

            if ($availableMahasiswas->count() > 0) {
                $reviewCount = min(3 - count($existingReviews), $availableMahasiswas->count());
                $usedMahasiswas = [];

                for ($i = 0; $i < $reviewCount; $i++) {
                    $mahasiswa = $availableMahasiswas->whereNotIn('id', $usedMahasiswas)->random();
                    if (!$mahasiswa) break;
                    $usedMahasiswas[] = $mahasiswa->id;

                    Review::firstOrCreate(
                        ['kos_id' => $kos->id, 'user_id' => $mahasiswa->id],
                        [
                            'rating' => rand(4, 5),
                            'rating_cleanliness' => rand(4, 5),
                            'rating_security' => rand(4, 5),
                            'rating_facilities' => rand(3, 5),
                            'comment' => $comments[array_rand($comments)],
                            'is_flagged' => false,
                            'is_visible' => true,
                        ]
                    );
                }
            }
        }
    }
}