<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AssessmentPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_submit_assessment(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $student = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $student->prakerinProfile()->create([
            'nisn' => '1234567890',
            'school' => 'SMK Negeri 1',
            'department' => 'RPL',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.prakerin.assessment', $student->id));
        $response->assertOk();
        $response->assertSee('Penilaian Prakerin');

        $response = $this->post(route('admin.prakerin.assessment.store', $student->id), [
            'discipline_score' => 90,
            'skill_score' => 88,
            'attitude_score' => 92,
            'notes' => 'Sangat baik',
        ]);

        $response->assertRedirect(route('admin.prakerin.assessment', $student->id));
        $this->assertDatabaseHas('assessments', [
            'user_id' => $student->id,
            'discipline_score' => 90,
        ]);
    }

    public function test_admin_can_submit_assessment_with_six_technical_scores(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $student = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $student->prakerinProfile()->create([
            'nisn' => '1234567891',
            'school' => 'SMK Negeri 2',
            'department' => 'TKJ',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.prakerin.assessment.store', $student->id), [
            'discipline_score' => 85,
            'attitude_score' => 90,
            'technical_scores' => [
                'os_installation' => 85,
                'troubleshooting' => 90,
                'pc_assembly' => 88,
                'lan_cabling' => 92,
                'network_config' => 86,
                'network_services' => 87,
            ],
            'notes' => 'Kompetensi TKJ sangat memuaskan.',
        ]);

        $response->assertRedirect(route('admin.prakerin.assessment', $student->id));
        $this->assertDatabaseHas('assessments', [
            'user_id' => $student->id,
            'discipline_score' => 85,
            'attitude_score' => 90,
            'skill_score' => 88, // average of (85+90+88+92+86+87)/6 = 88
        ]);
    }

    public function test_admin_can_submit_assessment_with_seven_non_technical_scores(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $student = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $student->prakerinProfile()->create([
            'nisn' => '1234567892',
            'school' => 'SMK Negeri 3',
            'department' => 'TKJ',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.prakerin.assessment.store', $student->id), [
            'technical_scores' => [
                'os_installation' => 90,
                'troubleshooting' => 90,
                'pc_assembly' => 90,
                'lan_cabling' => 90,
                'network_config' => 90,
                'network_services' => 90,
            ],
            'non_technical_scores' => [
                'attitude' => 95,
                'diligence' => 90,
                'discipline' => 85,
                'initiative_creativity' => 88,
                'responsibility' => 92,
                'honesty' => 96,
                'teamwork' => 91,
            ],
            'notes' => 'Sangat baik dalam aspek teknis dan sikap kerja.',
        ]);

        $response->assertRedirect(route('admin.prakerin.assessment', $student->id));
        $this->assertDatabaseHas('assessments', [
            'user_id' => $student->id,
            'discipline_score' => 85,
            'attitude_score' => 91, // average of 95,90,85,88,92,96,91 = 637/7 = 91
            'skill_score' => 90,
        ]);
    }

    public function test_admin_can_submit_assessment_with_six_rpl_technical_scores(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $student = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $student->prakerinProfile()->create([
            'nisn' => '1234567893',
            'school' => 'SMK Negeri 1',
            'department' => 'Rekayasa Perangkat Lunak',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.prakerin.assessment.store', $student->id), [
            'technical_scores' => [
                'system_design' => 88,
                'web_development' => 94,
                'database_management' => 90,
                'oop_programming' => 92,
                'testing_debugging' => 86,
                'git_deployment' => 90,
            ],
            'non_technical_scores' => [
                'attitude' => 90,
                'diligence' => 88,
                'discipline' => 92,
                'initiative_creativity' => 94,
                'responsibility' => 90,
                'honesty' => 95,
                'teamwork' => 89,
            ],
            'notes' => 'Siswa sangat kompeten dalam web development dan database.',
        ]);

        $response->assertRedirect(route('admin.prakerin.assessment', $student->id));
        $this->assertDatabaseHas('assessments', [
            'user_id' => $student->id,
            'skill_score' => 90, // average of (88+94+90+92+86+90)/6 = 90
            'discipline_score' => 92,
            'attitude_score' => 91,
        ]);
    }

    public function test_admin_can_view_assessment_page_with_dkv_detected(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $student = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $student->prakerinProfile()->create([
            'nisn' => '1234567894',
            'school' => 'SMK Negeri 4 Grafika',
            'department' => 'Desain Komunikasi Visual',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.prakerin.assessment', $student->id));
        $response->assertOk();
        $response->assertSee('Desain Komunikasi Visual (DKV)');
        $response->assertSee('Desain Grafis Berbasis Vektor');
        $response->assertSee('vector_design');
    }

    public function test_admin_can_submit_assessment_with_six_dkv_technical_scores(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $student = User::factory()->create([
            'role' => 'prakerin',
            'password' => Hash::make('password'),
        ]);

        $student->prakerinProfile()->create([
            'nisn' => '1234567895',
            'school' => 'SMK Negeri 4 Grafika',
            'department' => 'DKV',
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'status' => 'approved',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.prakerin.assessment.store', $student->id), [
            'technical_scores' => [
                'vector_design' => 92,
                'raster_editing' => 88,
                'typography_layout' => 90,
                'branding_identity' => 94,
                'digital_illustration' => 96,
                'audio_video_motion' => 86,
            ],
            'non_technical_scores' => [
                'attitude' => 90,
                'diligence' => 85,
                'discipline' => 95,
                'initiative_creativity' => 92,
                'responsibility' => 88,
                'honesty' => 95,
                'teamwork' => 90,
            ],
            'notes' => 'Siswa sangat kreatif dalam desain vektor, branding, dan ilustrasi digital.',
        ]);

        $response->assertRedirect(route('admin.prakerin.assessment', $student->id));
        $this->assertDatabaseHas('assessments', [
            'user_id' => $student->id,
            'skill_score' => 91, // average of (92+88+90+94+96+86)/6 = 546/6 = 91
            'discipline_score' => 95,
            'attitude_score' => 91, // average of (90+85+95+92+88+95+90)/7 = 635/7 = 91
        ]);
    }
}
