<?php

namespace Tests\Feature;

use App\Models\stp_personalityTestResult;
use App\Models\stp_student;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RiasecShareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('stp_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_userName');
            $table->string('student_password');
            $table->string('student_countryCode');
            $table->string('student_contactNo');
            $table->integer('student_status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('stp_personality_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('score');
            $table->integer('status');
            $table->string('share_token', 64)->nullable()->unique();
            $table->timestamp('shared_at')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('stp_personality_test_results');
        Schema::dropIfExists('stp_students');

        parent::tearDown();
    }

    private function createStudentWithResult(array $scores = ['Artistic' => 80, 'Social' => 20]): array
    {
        $student = stp_student::create([
            'student_userName' => 'Share Student',
            'student_password' => bcrypt('password'),
            'student_countryCode' => '+60',
            'student_contactNo' => '123456789',
            'student_status' => 1,
        ]);

        $result = stp_personalityTestResult::create([
            'student_id' => $student->id,
            'score' => json_encode($scores),
            'status' => 1,
        ]);

        return [$student, $result];
    }

    public function test_share_creation_requires_authentication(): void
    {
        $this->postJson('/api/student/createRiasecShare')->assertUnauthorized();
    }

    public function test_share_token_is_created_and_reused(): void
    {
        [$student] = $this->createStudentWithResult();

        $firstToken = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->json('data.share_token');

        $secondToken = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->assertOk()
            ->json('data.share_token');

        $this->assertSame($firstToken, $secondToken);
        $this->assertSame(64, strlen($firstToken));
    }

    public function test_public_lookup_returns_only_verified_result_data(): void
    {
        [$student] = $this->createStudentWithResult();
        $token = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->json('data.share_token');

        $this->getJson("/api/student/sharedRiasecResult/{$token}")
            ->assertOk()
            ->assertJsonPath('data.username', 'Share Student')
            ->assertJsonPath('data.scores.Artistic', 80)
            ->assertJsonMissingPath('data.student_id')
            ->assertJsonMissingPath('data.share_token');
    }

    public function test_invalid_or_revoked_tokens_return_not_found(): void
    {
        [$student] = $this->createStudentWithResult();
        $token = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->json('data.share_token');

        $this->getJson('/api/student/sharedRiasecResult/' . str_repeat('x', 64))
            ->assertNotFound();

        $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/revokeRiasecShare')
            ->assertOk();

        $this->getJson("/api/student/sharedRiasecResult/{$token}")
            ->assertNotFound();
    }

    public function test_shared_link_uses_latest_result_scores(): void
    {
        [$student, $result] = $this->createStudentWithResult();
        $token = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->json('data.share_token');

        $result->update([
            'score' => json_encode(['Realistic' => 95, 'Artistic' => 5]),
        ]);

        $this->getJson("/api/student/sharedRiasecResult/{$token}")
            ->assertOk()
            ->assertJsonPath('data.scores.Realistic', 95);
    }

    public function test_share_page_returns_crawler_friendly_og_tags(): void
    {
        [$student] = $this->createStudentWithResult(['Social' => 91, 'Realistic' => 8]);
        $token = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->json('data.share_token');

        $this->get("/share/{$token}")
            ->assertOk()
            ->assertSee("Share Student&#039;s Verified RIASEC Result - Social", false)
            ->assertSee("/api/student/riasecOgImage/{$token}", false)
            ->assertSee('og:image', false)
            ->assertSee('/share/' . $token, false);
    }

    public function test_og_image_endpoint_returns_png_for_valid_token(): void
    {
        if (!function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD is not available.');
        }

        [$student] = $this->createStudentWithResult(['Conventional' => 88, 'Social' => 10]);
        $token = $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/createRiasecShare')
            ->json('data.share_token');

        $response = $this->get("/api/student/riasecOgImage/{$token}");

        $response->assertOk();
        $this->assertSame('image/png', $response->headers->get('content-type'));
        $this->assertStringStartsWith("\x89PNG", $response->getContent());
    }
}
