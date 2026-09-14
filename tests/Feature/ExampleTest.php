<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_user_detail_report(): void
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'reportuser@example.com',
        ]);

        \App\Models\Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => '2026-09-12',
            'status' => 'Hadir',
        ]);

        $response = $this->actingAs($user)->get('/reports/user/' . $user->id);

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }
}
