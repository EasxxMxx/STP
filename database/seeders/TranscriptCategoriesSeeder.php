<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\stp_core_meta;

class TranscriptCategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database with required transcript categories.
     */
    public function run(): void
    {
        $categories = [
            'UEC',
            'Other',
        ];

        foreach ($categories as $name) {
            stp_core_meta::firstOrCreate(
                [
                    'core_metaType' => 'transcript_category',
                    'core_metaName' => $name,
                ],
                [
                    'core_metaStatus' => 1,
                ]
            );
        }
    }
}


