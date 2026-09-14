<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['Hadir', 'Terlambat', 'Izin', 'Sakit']);

        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'time_in' => in_array($status, ['Izin', 'Sakit'], true)
                ? null
                : $this->faker->time('H:i:s', '08:30:00'),
            'time_out' => in_array($status, ['Izin', 'Sakit'], true)
                ? null
                : $this->faker->time('H:i:s', '17:30:00'),
            'status' => $status,
        ];
    }
}
