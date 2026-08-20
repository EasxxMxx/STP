<?php

namespace Database\Seeders;

use App\Models\stp_core_meta;
use App\Models\stp_mascot_guide;
use App\Services\MascotGuideService;
use Illuminate\Database\Seeder;

class MascotGuideSeeder extends Seeder
{
    public function run(): void
    {
        stp_core_meta::firstOrCreate(
            [
                'core_metaType' => MascotGuideService::GLOBAL_SETTING_TYPE,
                'core_metaName' => MascotGuideService::GLOBAL_SETTING_NAME,
            ],
            [
                'core_metaStatus' => 0,
            ]
        );

        $guides = [
            [
                'guide_key' => 'course-count',
                'title' => 'Still deciding?',
                'body' => 'Try Find Your Path to discover courses that match your RIASEC type.',
                'cta_label' => 'Find Your Path',
                'cta_path' => '/studentStudyPath',
                'page_patterns' => ['/', '/courses', '/courses/*', '/course-details/*'],
                'path_param_pattern' => null,
                'trigger_type' => 'courseViewCount',
                'trigger_delay_ms' => null,
                'trigger_threshold' => 2,
                'anchor_target' => 'find-path',
                'image_path' => null,
                'priority' => 300,
                'dismiss_scope' => 'session',
                'visit_condition' => 'any',
                'publication_status' => 'published',
                'data_status' => 1,
            ],
            [
                'guide_key' => 'course-school',
                'title' => 'Want to know the school?',
                'body' => 'Visit the university profile to explore details, photos, and more programs from this school.',
                'cta_label' => 'Explore School',
                'cta_path' => '/university-details/:schoolSlug',
                'page_patterns' => ['/course-details/*'],
                'path_param_pattern' => '/course-details/:schoolSlug/:courseSlug',
                'trigger_type' => 'delay',
                'trigger_delay_ms' => 4500,
                'trigger_threshold' => null,
                'anchor_target' => null,
                'image_path' => null,
                'priority' => 200,
                'dismiss_scope' => 'session',
                'visit_condition' => 'any',
                'publication_status' => 'published',
                'data_status' => 1,
            ],
            [
                'guide_key' => 'idle-articles',
                'title' => 'Taking a break?',
                'body' => 'Explore the latest education tips and campus updates in Articles.',
                'cta_label' => 'Read Articles',
                'cta_path' => '/articles',
                'page_patterns' => ['/', '/courses'],
                'path_param_pattern' => null,
                'trigger_type' => 'idle',
                'trigger_delay_ms' => 3000,
                'trigger_threshold' => null,
                'anchor_target' => 'articles',
                'image_path' => null,
                'priority' => 100,
                'dismiss_scope' => 'session',
                'visit_condition' => 'any',
                'publication_status' => 'published',
                'data_status' => 1,
            ],
        ];

        foreach ($guides as $guide) {
            stp_mascot_guide::updateOrCreate(
                ['guide_key' => $guide['guide_key']],
                $guide
            );
        }
    }
}
