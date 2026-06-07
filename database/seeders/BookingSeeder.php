<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Get sample users and kos
        $mahasiswa = User::where('role', 'mahasiswa')->first();
        $owner = User::where('role', 'owner')->first();
        $kos = Kos::where('user_id', $owner?->id)->first();

        if (!$mahasiswa || !$kos) {
            $this->command->warn('Skipping BookingSeeder: mahasiswa or kos not found.');
            return;
        }

        // 1. Pending booking
        Booking::firstOrCreate(
            ['user_id' => $mahasiswa->id, 'kos_id' => $kos->id],
            [
                'status' => 'pending',
                'rejection_reason' => null,
            ]
        );

        // 2. Rejected booking (find different mahasiswa or create dummy)
        $mahasiswa2 = User::where('role', 'mahasiswa')
            ->where('id', '!=', $mahasiswa->id)
            ->first();

        if ($mahasiswa2 && $mahasiswa2->id !== $mahasiswa->id) {
            Booking::firstOrCreate(
                ['user_id' => $mahasiswa2->id, 'kos_id' => $kos->id],
                [
                    'status' => 'rejected',
                    'rejection_reason' => 'Maaf, kamar sudah terisi. Silakan pilih kos lain.',
                ]
            );
        }

        $this->command->info('BookingSeeder: Created 2 dummy bookings (1 pending, 1 rejected).');
    }
}
