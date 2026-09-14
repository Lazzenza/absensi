<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Spesifik untuk Pengujian Login
        User::create([
            'name'              => 'Admin Presensi',
            'email'             => 'admin@presensi.com',
            'password'          => Hash::make('password123'), // Terenkripsi Bcrypt
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Karyawan Magang',
            'email'             => 'intern@presensi.com',
            'password'          => Hash::make('password123'), // Terenkripsi Bcrypt
            'email_verified_at' => now(),
        ]);

        // 2. Buat 10 User Dummy Otomatis Menggunakan Factory
        User::factory(10)->create();
    }
}