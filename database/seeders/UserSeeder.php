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
            'name'              => 'Rachmat Akbar',
            'email'             => 'rachmat.akbar@jakarta.go.id',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

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

        // 2. Daftar 10 Karyawan (Silakan ganti nama dan email di bawah ini sesuai keinginan Anda)
        $employees = [
            ['name' => 'Ahmad Fauzi',       'email' => 'ahmad.fauzi@presensi.com'],
            ['name' => 'Budi Santoso',      'email' => 'budi.santoso@presensi.com'],
            ['name' => 'Citra Lestari',     'email' => 'citra.lestari@presensi.com'],
            ['name' => 'Dewi Anggraini',    'email' => 'dewi.anggraini@presensi.com'],
            ['name' => 'Eko Prasetyo',      'email' => 'eko.prasetyo@presensi.com'],
            ['name' => 'Fajar Hidayat',     'email' => 'fajar.hidayat@presensi.com'],
            ['name' => 'Gita Permata',      'email' => 'gita.permata@presensi.com'],
            ['name' => 'Hendra Wijaya',     'email' => 'hendra.wijaya@presensi.com'],
            ['name' => 'Indah Kusuma',      'email' => 'indah.kusuma@presensi.com'],
            ['name' => 'Joko Susilo',       'email' => 'joko.susilo@presensi.com'],
        ];

        foreach ($employees as $emp) {
            User::create([
                'name'              => $emp['name'],
                'email'             => $emp['email'],
                'password'          => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
    }
}