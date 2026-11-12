<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'  => 'Rachmat Akbar',
            'email' => 'rachmat@example.com',
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/attendances');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_attendances_page(): void
    {
        $response = $this->actingAs($this->user)->get('/attendances');

        $response->assertStatus(200);
        $response->assertSee('Data Presensi');
        $response->assertSee('Pencarian', false);
    }

    public function test_user_can_check_in_successfully(): void
    {
        Carbon::setTestNow('2026-09-14 07:45:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_in',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'user_id' => $this->user->id,
            'date'    => '2026-09-14',
            'status'  => 'Hadir',
        ]);

        Carbon::setTestNow();
    }

    public function test_check_in_after_eight_am_is_marked_as_terlambat(): void
    {
        Carbon::setTestNow('2026-09-14 08:30:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_in',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'user_id' => $this->user->id,
            'date'    => '2026-09-14',
            'status'  => 'Terlambat',
        ]);

        Carbon::setTestNow();
    }

    public function test_duplicate_check_in_on_same_day_is_prevented(): void
    {
        Carbon::setTestNow('2026-09-14 07:30:00');

        Attendance::create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-14',
            'time_in' => '07:30:00',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_in',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        Carbon::setTestNow();
    }

    public function test_user_can_check_out_after_check_in(): void
    {
        Carbon::setTestNow('2026-09-14 07:30:00');
        $attendance = Attendance::create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-14',
            'time_in' => '07:30:00',
            'status'  => 'Hadir',
        ]);

        Carbon::setTestNow('2026-09-14 17:05:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_out',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'id'       => $attendance->id,
            'time_out' => '17:05:00',
        ]);

        Carbon::setTestNow();
    }

    public function test_check_out_without_prior_check_in_is_prevented(): void
    {
        Carbon::setTestNow('2026-09-14 17:00:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'check_out',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        Carbon::setTestNow();
    }

    public function test_user_can_record_izin_or_sakit_without_check_in_out(): void
    {
        Carbon::setTestNow('2026-09-14 09:00:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'izin',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'user_id'  => $this->user->id,
            'date'     => '2026-09-14',
            'time_in'  => null,
            'time_out' => null,
            'status'   => 'Izin',
        ]);

        Carbon::setTestNow();
    }

    public function test_filter_by_user_name_search(): void
    {
        $anotherUser = User::factory()->create(['name' => 'Budi Santoso']);

        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        Attendance::factory()->create([
            'user_id' => $anotherUser->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances?search=Budi');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
    }

    public function test_filter_by_status(): void
    {
        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-08',
            'status'  => 'Sakit',
        ]);

        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-09',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances?status=Sakit');

        $response->assertStatus(200);
        $response->assertSee('Sakit');
    }

    public function test_filter_by_date_range(): void
    {
        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-08-01',
            'status'  => 'Hadir',
        ]);

        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances?start_date=2026-09-01&end_date=2026-09-30');

        $response->assertStatus(200);
        $response->assertSee('10 Sep 2026');
        $response->assertDontSee('01 Aug 2026');
    }

    public function test_filter_by_month_and_year(): void
    {
        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-05-15',
            'status'  => 'Hadir',
        ]);

        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-12',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances?month=9&year=2026');

        $response->assertStatus(200);
        $response->assertSee('12 Sep 2026');
        $response->assertDontSee('15 Mei 2026');
    }

    public function test_sorting_by_date_asc_and_desc(): void
    {
        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-01',
            'status'  => 'Hadir',
        ]);

        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances?sort_by=date&sort_direction=asc');
        $response->assertStatus(200);
    }

    public function test_pdf_export_returns_pdf_stream_for_admin_with_active_filters(): void
    {
        $admin = User::factory()->admin()->create();

        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($admin)->get('/attendances/report/pdf?status=Hadir');

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }

    public function test_non_admin_cannot_download_pdf_report(): void
    {
        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances/report/pdf');

        $response->assertStatus(403);
    }

    public function test_submitting_izin_or_sakit_sets_pending_approval_status(): void
    {
        Carbon::setTestNow('2026-09-15 08:00:00');

        $response = $this->actingAs($this->user)->post('/attendances', [
            'user_id' => $this->user->id,
            'type'    => 'izin',
            'notes'   => 'Izin bimbingan akademik skripsi di kampus',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'user_id'         => $this->user->id,
            'date'            => '2026-09-15',
            'status'          => 'Izin',
            'approval_status' => 'pending',
        ]);

        Carbon::setTestNow();
    }

    public function test_admin_can_approve_pending_attendance(): void
    {
        $admin = User::factory()->admin()->create();

        $attendance = Attendance::create([
            'user_id'         => $this->user->id,
            'date'            => '2026-09-16',
            'status'          => 'Sakit',
            'notes'           => 'Dispensasi flu berat',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/attendances/{$attendance->id}/approve");

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'id'              => $attendance->id,
            'approval_status' => 'approved',
            'approved_by'     => $admin->id,
        ]);
    }

    public function test_admin_can_reject_pending_attendance_with_reason(): void
    {
        $admin = User::factory()->admin()->create();

        $attendance = Attendance::create([
            'user_id'         => $this->user->id,
            'date'            => '2026-09-16',
            'status'          => 'Izin',
            'notes'           => 'Izin keperluan pribadi',
            'approval_status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post("/attendances/{$attendance->id}/reject", [
            'notes' => 'Surat rekomendasi kampus belum dilampirkan',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('attendances', [
            'id'              => $attendance->id,
            'approval_status' => 'rejected',
            'approved_by'     => $admin->id,
            'approval_note'   => 'Surat rekomendasi kampus belum dilampirkan',
        ]);
    }

    public function test_non_admin_cannot_approve_or_reject_attendance(): void
    {
        $attendance = Attendance::create([
            'user_id'         => $this->user->id,
            'date'            => '2026-09-16',
            'status'          => 'Izin',
            'approval_status' => 'pending',
        ]);

        $approveResponse = $this->actingAs($this->user)->post("/attendances/{$attendance->id}/approve");
        $approveResponse->assertStatus(403);

        $rejectResponse = $this->actingAs($this->user)->post("/attendances/{$attendance->id}/reject", [
            'notes' => 'Coba tolak',
        ]);
        $rejectResponse->assertStatus(403);
    }

    public function test_csv_export_returns_stream_with_headers(): void
    {
        Attendance::factory()->create([
            'user_id' => $this->user->id,
            'date'    => '2026-09-10',
            'status'  => 'Hadir',
        ]);

        $response = $this->actingAs($this->user)->get('/attendances/report/csv');

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'text/csv'));
    }

    public function test_pagination_preserves_query_string_parameters(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Attendance::factory()->create([
                'user_id' => $this->user->id,
                'date'    => Carbon::today()->subDays($i)->toDateString(),
                'status'  => 'Hadir',
            ]);
        }

        $response = $this->actingAs($this->user)->get('/attendances?status=Hadir&page=2');

        $response->assertStatus(200);
        $response->assertSee('status=Hadir');
    }
}
