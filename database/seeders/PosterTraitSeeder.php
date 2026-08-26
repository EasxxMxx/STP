<?php

namespace Database\Seeders;

use App\Models\stp_RIASECType;
use App\Models\stp_riasecPosterAssetSet;
use Illuminate\Database\Seeder;

class PosterTraitSeeder extends Seeder
{
    public function run(): void
    {
        $traits = [
            'Realistic' => ['Practical', 'Reliable', 'Hands-on'],
            'Investigative' => ['Curious', 'Analytical', 'Insightful'],
            'Artistic' => ['Creative', 'Expressive', 'Imaginative'],
            'Social' => ['Empathetic', 'Supportive', 'Communicative'],
            'Enterprising' => ['Confident', 'Persuasive', 'Ambitious'],
            'Conventional' => ['Organized', 'Precise', 'Dependable'],
        ];

        foreach ($traits as $type => $words) {
            $riasec = stp_RIASECType::where('type_name', $type)->first();
            if (! $riasec) {
                continue;
            }
            stp_riasecPosterAssetSet::firstOrCreate(
                ['riasec_type_id' => $riasec->id, 'status' => 'draft'],
                ['traits' => $words, 'accent_color' => '#c71919']
            );
        }
    }
}
