<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            FacilitySeeder::class,
            KosSeeder::class,
            ReviewSeeder::class,
            LeadSeeder::class,
            ReportTypeSeeder::class,
            AdSeeder::class,
            LocalBusinessSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
