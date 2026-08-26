<?php

namespace Tests\Feature;

use App\Models\stp_career;
use App\Models\stp_personalityTestResult;
use App\Models\stp_student;
use Database\Seeders\CareerSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CareerMatchingApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.foreign_key_constraints' => true,
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');

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

        Schema::create('stp_careers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->unsignedTinyInteger('realistic');
            $table->unsignedTinyInteger('investigative');
            $table->unsignedTinyInteger('artistic');
            $table->unsignedTinyInteger('social');
            $table->unsignedTinyInteger('enterprising');
            $table->unsignedTinyInteger('conventional');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('stp_personality_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('score');
            $table->json('career_matches')->nullable();
            $table->unsignedInteger('career_match_version')->nullable();
            $table->integer('status')->default(1);
            $table->string('share_token', 64)->nullable()->unique();
            $table->timestamp('shared_at')->nullable();
            $table->timestamps();
        });

        $this->seed(CareerSeeder::class);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('stp_personality_test_results');
        Schema::dropIfExists('stp_careers');
        Schema::dropIfExists('stp_students');

        parent::tearDown();
    }

    public function test_submission_returns_and_persists_three_career_matches(): void
    {
        $student = $this->createStudent();

        $response = $this->actingAs($student, 'sanctum')->postJson(
            '/api/student/submitTestResult',
            ['scores' => $this->lowercaseScores()]
        );

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data.career_matches')
            ->assertJsonPath('data.scores.Investigative', 91);

        $result = stp_personalityTestResult::where('student_id', $student->id)->firstOrFail();
        $this->assertSame(1, $result->career_match_version);
        $this->assertCount(3, $result->career_matches);
        $this->assertArrayHasKey('riasec_profile', $result->career_matches[0]);
    }

    public function test_career_catalogue_contains_the_revised_thirty_roles(): void
    {
        $this->assertSame(30, stp_career::count());
        $this->assertSame(
            7,
            stp_career::whereIn('name', [
                'Physio',
                'Mechanic',
                'Programmer',
                'Statistician',
                'Economist',
                'Publicist',
                'Diplomat',
            ])->count()
        );
        $this->assertSame(
            0,
            stp_career::whereIn('name', [
                'Physiotherapist',
                'Surveyor',
                'Developer',
                'Analyst',
                'Marketer',
                'Recruiter',
            ])->count()
        );
    }

    public function test_rename_migration_updates_existing_roles_in_place(): void
    {
        stp_career::query()->delete();
        $oldNames = [
            'Physiotherapist',
            'Surveyor',
            'Developer',
            'Programmer',
            'Analyst',
            'Marketer',
            'Recruiter',
        ];

        foreach ($oldNames as $name) {
            stp_career::create([
                'slug' => str($name)->slug()->toString(),
                'name' => $name,
                'realistic' => 50,
                'investigative' => 50,
                'artistic' => 50,
                'social' => 50,
                'enterprising' => 50,
                'conventional' => 50,
                'status' => 1,
            ]);
        }

        $idsBefore = stp_career::pluck('id')->sort()->values()->all();
        $migration = require database_path('migrations/2026_08_20_000002_rename_career_roles.php');
        $migration->up();

        $this->assertSame($idsBefore, stp_career::pluck('id')->sort()->values()->all());
        $this->assertSame(
            ['Diplomat', 'Economist', 'Mechanic', 'Physio', 'Programmer', 'Publicist', 'Statistician'],
            stp_career::orderBy('name')->pluck('name')->all()
        );
    }

    public function test_saved_legacy_result_is_lazily_backfilled(): void
    {
        $student = $this->createStudent();
        $result = stp_personalityTestResult::create([
            'student_id' => $student->id,
            'score' => json_encode($this->lowercaseScores()),
            'status' => 1,
        ]);

        $this->actingAs($student, 'sanctum')
            ->getJson('/api/student/getTestResult')
            ->assertOk()
            ->assertJsonCount(3, 'data.career_matches')
            ->assertJsonMissingPath('data.career_matches.0.riasec_profile');

        $result->refresh();
        $this->assertSame(1, $result->career_match_version);
        $this->assertCount(3, $result->career_matches);
    }

    public function test_submission_rejects_an_unknown_dimension(): void
    {
        $student = $this->createStudent();
        $scores = $this->lowercaseScores();
        unset($scores['conventional']);
        $scores['unknown'] = 57;

        $this->actingAs($student, 'sanctum')
            ->postJson('/api/student/submitTestResult', ['scores' => $scores])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('scores');
    }

    private function createStudent(): stp_student
    {
        return stp_student::create([
            'student_userName' => 'Career Student',
            'student_password' => bcrypt('password'),
            'student_countryCode' => '+60',
            'student_contactNo' => '123456789',
            'student_status' => 1,
        ]);
    }

    private function lowercaseScores(): array
    {
        return [
            'realistic' => 72,
            'investigative' => 91,
            'artistic' => 46,
            'social' => 64,
            'enterprising' => 38,
            'conventional' => 57,
        ];
    }
}
