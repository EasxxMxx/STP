<?php

namespace Tests\Feature;

use App\Models\stp_mascot_guide;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MascotGuideApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', ':memory:');
        Config::set(
            'filesystems.disks.public.root',
            sys_get_temp_dir().'/studypal-mascot-guide-tests-'.getmypid()
        );
        DB::purge();
        DB::reconnect();
        Storage::forgetDisk('public');

        Schema::create('stp_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_role');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('stp_core_metas', function (Blueprint $table) {
            $table->id();
            $table->string('core_metaType');
            $table->string('core_metaName');
            $table->integer('core_metaStatus')->default(1);
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });

        $migration = require database_path(
            'migrations/2026_07_24_000000_create_stp_mascot_guides_table.php'
        );
        $migration->up();
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('stp_mascot_guides');
        Schema::dropIfExists('stp_core_metas');
        Schema::dropIfExists('stp_users');
        Storage::disk('public')->deleteDirectory('mascot-guides');
        Storage::forgetDisk('public');
        DB::purge();

        parent::tearDown();
    }

    public function test_migration_has_expected_columns_defaults_and_rolls_back(): void
    {
        $this->assertTrue(Schema::hasColumns('stp_mascot_guides', [
            'guide_key',
            'page_patterns',
            'publication_status',
            'visit_condition',
            'data_status',
            'priority',
        ]));

        $guide = stp_mascot_guide::create(['guide_key' => 'defaults-test'])->refresh();
        $this->assertSame('draft', $guide->publication_status);
        $this->assertSame('any', $guide->visit_condition);
        $this->assertSame(1, $guide->data_status);
        $this->assertSame(0, $guide->priority);

        $migration = require database_path(
            'migrations/2026_07_24_000000_create_stp_mascot_guides_table.php'
        );
        $migration->down();
        $this->assertFalse(Schema::hasTable('stp_mascot_guides'));
    }

    public function test_public_list_returns_only_active_published_guides_in_priority_order(): void
    {
        $high = $this->createCompleteGuide([
            'guide_key' => 'high-priority',
            'priority' => 300,
            'image_path' => 'mascot-guides/high.webp',
        ]);
        $this->createCompleteGuide([
            'guide_key' => 'low-priority',
            'priority' => 10,
        ]);
        $this->createCompleteGuide([
            'guide_key' => 'draft-guide',
            'publication_status' => 'draft',
            'priority' => 500,
        ]);
        $this->createCompleteGuide([
            'guide_key' => 'archived-guide',
            'data_status' => 0,
            'priority' => 600,
        ]);

        $response = $this->getJson('/api/student/mascotGuideList')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.id', $high->guide_key)
            ->assertJsonPath('data.0.trigger.type', 'delay')
            ->assertJsonPath('data.0.trigger.delayMs', 1000)
            ->assertJsonPath('data.0.visitCondition', 'any')
            ->assertJsonPath(
                'data.0.imageSrc',
                url('/api/student/mascotGuideImage/high.webp')
            )
            ->assertJsonMissingPath('data.0.guide_key');

        $this->assertSame(
            ['high-priority', 'low-priority'],
            collect($response->json('data'))->pluck('id')->all()
        );
    }

    public function test_mascot_image_endpoint_serves_only_known_stored_images(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('mascot-guides/known.webp', 'image-content');
        $this->createCompleteGuide([
            'guide_key' => 'known-image',
            'image_path' => 'mascot-guides/known.webp',
        ]);

        $this->get('/api/student/mascotGuideImage/known.webp')
            ->assertOk()
            ->assertHeader('content-type', 'image/webp');

        Storage::disk('public')->put('mascot-guides/unreferenced.webp', 'private');
        $this->get('/api/student/mascotGuideImage/unreferenced.webp')
            ->assertNotFound();
    }

    public function test_admin_routes_require_authentication_and_admin_role(): void
    {
        $this->postJson('/api/admin/mascotGuideList')->assertUnauthorized();

        $this->actingAs($this->userWithRole(4), 'sanctum')
            ->postJson('/api/admin/mascotGuideList')
            ->assertForbidden()
            ->assertJsonPath('success', false);

        $this->actingAs($this->userWithRole(1), 'sanctum')
            ->postJson('/api/admin/mascotGuideList')
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function test_global_status_defaults_off_and_only_admin_can_update_it(): void
    {
        $this->getJson('/api/student/mascotGuideStatus')
            ->assertOk()
            ->assertJsonPath('data.enabled', false);

        $this->postJson('/api/admin/updateMascotGuideStatus', ['enabled' => true])
            ->assertUnauthorized();

        $this->actingAs($this->userWithRole(4), 'sanctum')
            ->postJson('/api/admin/updateMascotGuideStatus', ['enabled' => true])
            ->assertForbidden();

        $this->actingAs($this->userWithRole(1), 'sanctum')
            ->postJson('/api/admin/updateMascotGuideStatus', ['enabled' => true])
            ->assertOk()
            ->assertJsonPath('data.enabled', true);

        $this->getJson('/api/student/mascotGuideStatus')
            ->assertOk()
            ->assertJsonPath('data.enabled', true);
    }

    public function test_admin_can_create_edit_publish_unpublish_and_archive_a_guide(): void
    {
        $admin = $this->userWithRole(1);

        $id = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/addMascotGuide', [
                'guide_key' => 'new-guide',
            ])
            ->assertCreated()
            ->assertJsonPath('data.publication_status', 'draft')
            ->json('data.id');

        $completeData = [
            ...$this->completePayload(),
            'visit_condition' => 'first',
        ];
        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/editMascotGuide', ['id' => $id, ...$completeData])
            ->assertOk()
            ->assertJsonPath('data.title', $completeData['title'])
            ->assertJsonPath('data.visit_condition', 'first');

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/publishMascotGuide', ['id' => $id])
            ->assertOk()
            ->assertJsonPath('data.publication_status', 'published');

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/unpublishMascotGuide', ['id' => $id])
            ->assertOk()
            ->assertJsonPath('data.publication_status', 'draft');

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/archiveMascotGuide', ['id' => $id])
            ->assertOk()
            ->assertJsonPath('data.data_status', 0)
            ->assertJsonPath('data.publication_status', 'draft');
    }

    public function test_incomplete_draft_cannot_be_published(): void
    {
        $guide = stp_mascot_guide::create(['guide_key' => 'incomplete']);

        $this->actingAs($this->userWithRole(1), 'sanctum')
            ->postJson('/api/admin/publishMascotGuide', ['id' => $guide->id])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'body', 'cta_label', 'cta_path']);
    }

    public function test_invalid_configuration_is_rejected(): void
    {
        $admin = $this->userWithRole(1);

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/addMascotGuide', [
                'guide_key' => 'invalid-guide',
                'cta_path' => 'https://example.com',
                'page_patterns' => ['/courses/*/invalid'],
                'trigger_type' => 'unknown',
                'anchor_target' => '#arbitrary-selector',
                'visit_condition' => 'sometimes',
            ])
            ->assertUnprocessable()
            ->assertJsonPath('success', false)
            ->assertJsonValidationErrors([
                'cta_path',
                'page_patterns.0',
                'trigger_type',
                'anchor_target',
                'visit_condition',
            ]);

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/addMascotGuide', [
                'guide_key' => 'bad-parameters',
                'cta_path' => '/universities/:schoolSlug',
                'path_param_pattern' => '/courses/:courseSlug',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['cta_path']);
    }

    public function test_replacing_an_image_deletes_the_old_file_after_success(): void
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD is required for fake image generation.');
        }

        Storage::disk('public')->put('mascot-guides/old.png', 'old');
        $guide = $this->createCompleteGuide([
            'guide_key' => 'image-guide',
            'image_path' => 'mascot-guides/old.png',
            'publication_status' => 'draft',
        ]);

        $this->actingAs($this->userWithRole(1), 'sanctum')
            ->post('/api/admin/editMascotGuide', [
                'id' => $guide->id,
                'image' => UploadedFile::fake()->image('new.png', 40, 40),
            ], ['Accept' => 'application/json'])
            ->assertOk();

        Storage::disk('public')->assertMissing('mascot-guides/old.png');
        Storage::disk('public')->assertExists($guide->refresh()->image_path);
    }

    private function userWithRole(int $role): User
    {
        $user = new User;
        $user->forceFill([
            'id' => $role,
            'user_role' => $role,
            'name' => "Role {$role}",
        ]);

        return $user;
    }

    private function completePayload(): array
    {
        return [
            'title' => 'Helpful guide',
            'body' => 'This is a helpful guide.',
            'cta_label' => 'Continue',
            'cta_path' => '/courses',
            'page_patterns' => ['/courses', '/courses/*'],
            'path_param_pattern' => null,
            'trigger_type' => 'delay',
            'trigger_delay_ms' => 1000,
            'trigger_threshold' => null,
            'anchor_target' => 'articles',
            'priority' => 100,
            'dismiss_scope' => 'session',
            'visit_condition' => 'any',
        ];
    }

    private function createCompleteGuide(array $overrides = []): stp_mascot_guide
    {
        return stp_mascot_guide::create([
            'guide_key' => 'guide-'.uniqid(),
            ...$this->completePayload(),
            'publication_status' => 'published',
            'data_status' => 1,
            ...$overrides,
        ]);
    }
}
