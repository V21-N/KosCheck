<?php

namespace Database\Seeders;

use App\Models\Kos;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $kosList = Kos::all();
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        $leadsData = [];
        $ipAddresses = ['127.0.0.1', '192.168.1.100', '10.0.0.1', '172.16.0.50', '203.0.113.42'];

        // Generate at least 3 leads per kos
        foreach ($kosList as $kos) {
            for ($i = 0; $i < 3; $i++) {
                $leadsData[] = [
                    'kos_id' => $kos->id,
                    'user_id' => $mahasiswas->random()->id,
                    'ip_address' => $ipAddresses[array_rand($ipAddresses)],
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'created_at' => now()->subDays(rand(1, 30)),
                ];
            }
        }

        foreach ($leadsData as $data) {
            Lead::create($data);
        }
    }
}
