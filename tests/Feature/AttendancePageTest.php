<?php

namespace Tests\Feature;

use App\Models\PrakerinProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AttendancePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_prakerin_can_view_and_submit_attendance(): void
    {
        $user = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $user->prakerinProfile()->create([
            'nisn' => '1234567890',
            'school' => 'SMK Negeri 1',
            'department' => 'RPL',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('prakerin.attendance'));
        $response->assertOk();
        $response->assertSee('Absensi Prakerin');

        $response = $this->post(route('prakerin.attendance.store'), [
            'status' => 'present',
            'note' => 'Masuk tepat waktu',
        ]);

        $response->assertRedirect(route('prakerin.attendance'));
        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'status' => 'present',
        ]);
    }

    public function test_prakerin_can_submit_separate_sick_and_permission_statuses(): void
    {
        $user = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $user->prakerinProfile()->create([
            'nisn' => '1234567891',
            'school' => 'SMK Negeri 2',
            'department' => 'TKJ',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($user);

        $this->post(route('prakerin.attendance.store'), [
            'date' => now()->subDay()->toDateString(),
            'status' => 'sick',
            'note' => 'Sakit demam',
        ]);

        $this->post(route('prakerin.attendance.store'), [
            'date' => now()->toDateString(),
            'status' => 'permission',
            'note' => 'Izin keluarga',
        ]);

        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'status' => 'sick',
            'note' => 'Sakit demam',
            'date' => now()->subDay()->startOfDay()->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'status' => 'permission',
            'note' => 'Izin keluarga',
            'date' => now()->startOfDay()->format('Y-m-d H:i:s'),
        ]);
    }
}
