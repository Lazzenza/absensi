<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StitchIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'  => 'Rachmat Akbar',
            'email' => 'rachmat.akbar@jakarta.go.id',
        ]);
    }

    public function test_authenticated_user_can_access_presensi_create_page(): void
    {
        $response = $this->actingAs($this->user)->get('/presensi');

        $response->assertStatus(200);
        $response->assertSee('Presensi Masuk');
        $response->assertSee('Bappeda Provinsi DKI Jakarta');
    }

    public function test_user_can_submit_check_in_with_notes(): void
    {
        Carbon::setTestNow('2026-10-24 07:45:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_in',
            'notes'   => 'Tepat waktu - Balai Kota Blok G',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'user_id' => $this->user->id,
            'status'  => 'Hadir',
            'notes'   => 'Tepat waktu - Balai Kota Blok G',
        ]);
    }

    public function test_user_can_submit_check_out_with_notes(): void
    {
        Carbon::setTestNow('2026-10-24 07:45:00');
        $attendance = Attendance::create([
            'user_id' => $this->user->id,
            'date'    => '2026-10-24',
            'time_in' => '07:45:00',
            'status'  => 'Hadir',
        ]);

        Carbon::setTestNow('2026-10-24 16:30:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_out',
            'notes'   => 'Tugas harian selesai',
        ]);

        $response->assertRedirect();
        $attendance->refresh();
        $this->assertEquals('16:30:00', $attendance->time_out);
        $this->assertEquals('Tugas harian selesai', $attendance->notes);
    }

    public function test_user_can_submit_special_attendance_izin_and_sakit(): void
    {
        Carbon::setTestNow('2026-10-25 08:00:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'izin',
            'notes'   => 'Izin bimbingan tugas akhir di kampus',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'user_id' => $this->user->id,
            'date'    => '2026-10-25',
            'status'  => 'Izin',
            'notes'   => 'Izin bimbingan tugas akhir di kampus',
        ]);
    }

    public function test_authenticated_user_can_access_report_preview_page(): void
    {
        $response = $this->actingAs($this->user)->get('/reports/preview');

        $response->assertStatus(200);
        $response->assertSee('LAPORAN PRESENSI PESERTA MAGANG');
        $response->assertSee('BADAN PERENCANAAN PEMBANGUNAN DAERAH');
    }
}

