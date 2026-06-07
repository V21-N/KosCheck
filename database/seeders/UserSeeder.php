<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin KosCheck',
            'email' => 'admin@koscheck.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Owners
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'owner@email.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti.owner@email.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.owner@email.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Rina Wulandari',
            'email' => 'rina.owner@email.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567893',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'dedi.owner@email.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567894',
            'email_verified_at' => now(),
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Andi Wijaya',
            'email' => 'mahasiswa@usu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'university' => 'Universitas Sumatera Utara',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@unimed.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'university' => 'Universitas Negeri Medan',
            'email_verified_at' => now(),
        ]);
    }
}