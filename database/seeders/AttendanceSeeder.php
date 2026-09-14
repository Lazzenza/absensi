<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->call(UserSeeder::class);
            $users = User::all();
        }

        foreach ($users as $user) {
            // Ambil 7 hari acak dalam 14 hari terakhir untuk setiap user
            $dates = collect(range(0, 13))
                ->map(fn ($day) => Carbon::now()->subDays($day)->toDateString())
                ->shuffle()
                ->take(7);

            foreach ($dates as $date) {
                $status = fake()->randomElement(['Hadir', 'Hadir', 'Hadir', 'Terlambat', 'Izin', 'Sakit']);

                $timeIn = null;
                $timeOut = null;

                if ($status === 'Hadir') {
                    // Hadir: Check in antara 06:30 - 08:00
                    $timeIn = sprintf('0%d:%02d:00', fake()->numberBetween(6, 7), fake()->numberBetween(0, 59));
                    $timeOut = sprintf('1%d:%02d:00', fake()->numberBetween(7, 8), fake()->numberBetween(0, 59));
                } elseif ($status === 'Terlambat') {
                    // Terlambat: Check in setelah 08:00 (misal 08:05 - 09:30)
                    $timeIn = sprintf('08:%02d:00', fake()->numberBetween(5, 59));
                    $timeOut = sprintf('1%d:%02d:00', fake()->numberBetween(7, 8), fake()->numberBetween(0, 59));
                }

                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $date,
                    'time_in' => $timeIn,
                    'time_out' => $timeOut,
                    'status' => $status,
                ]);
            }
        }
    }
}