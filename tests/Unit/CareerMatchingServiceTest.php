<?php

namespace Tests\Unit;

use App\Services\CareerMatchingService;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CareerMatchingServiceTest extends TestCase
{
    private CareerMatchingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CareerMatchingService;
    }

    public function test_it_normalizes_lowercase_scores_to_canonical_types(): void
    {
        $scores = $this->service->normalizeScores([
            'realistic' => 72,
            'investigative' => 91,
            'artistic' => 46,
            'social' => 64,
            'enterprising' => 38,
            'conventional' => 57,
        ]);

        $this->assertSame(CareerMatchingService::TYPES, array_keys($scores));
        $this->assertSame(91.0, $scores['Investigative']);
    }

    public function test_it_rejects_incomplete_or_unknown_score_profiles(): void
    {
        $this->expectException(ValidationException::class);

        $this->service->normalizeScores([
            'realistic' => 50,
            'investigative' => 50,
            'artistic' => 50,
            'social' => 50,
            'enterprising' => 50,
            'unknown' => 50,
        ]);
    }

    public function test_it_rejects_scores_outside_the_percentage_range(): void
    {
        $this->expectException(ValidationException::class);

        $this->service->normalizeScores([
            'Realistic' => 101,
            'Investigative' => 50,
            'Artistic' => 50,
            'Social' => 50,
            'Enterprising' => 50,
            'Conventional' => 50,
        ]);
    }

    public function test_it_returns_three_ranked_matches_with_a_perfect_match_first(): void
    {
        $scores = [
            'Realistic' => 55,
            'Investigative' => 90,
            'Artistic' => 80,
            'Social' => 30,
            'Enterprising' => 45,
            'Conventional' => 70,
        ];
        $careers = new Collection([
            $this->career(1, 'Developer', [55, 90, 80, 30, 45, 70]),
            $this->career(2, 'Engineer', [85, 90, 30, 35, 45, 65]),
            $this->career(3, 'Artist', [20, 30, 100, 40, 40, 25]),
            $this->career(4, 'Nurse', [55, 70, 25, 95, 40, 90]),
        ]);

        $matches = $this->service->rankCareers($scores, $careers);

        $this->assertCount(3, $matches);
        $this->assertSame('Developer', $matches[0]['name']);
        $this->assertSame(100, $matches[0]['match_percentage']);
        $this->assertSame([1, 2, 3], array_column($matches, 'rank'));
        $this->assertStringContainsString('Investigative', $matches[0]['reason']);
    }

    public function test_equal_matches_are_ordered_by_name(): void
    {
        $scores = array_fill_keys(CareerMatchingService::TYPES, 50);
        $profile = [50, 50, 50, 50, 50, 50];
        $careers = new Collection([
            $this->career(1, 'Zulu', $profile),
            $this->career(2, 'Alpha', $profile),
            $this->career(3, 'Beta', $profile),
        ]);

        $matches = $this->service->rankCareers($scores, $careers);

        $this->assertSame(['Alpha', 'Beta', 'Zulu'], array_column($matches, 'name'));
    }

    public function test_api_payload_omits_internal_profile_weights(): void
    {
        $matches = [[
            'rank' => 1,
            'career_id' => 1,
            'slug' => 'developer',
            'name' => 'Developer',
            'match_percentage' => 90,
            'reason' => 'Reason',
            'riasec_profile' => ['Realistic' => 50],
        ]];

        $payload = $this->service->toApiPayload($matches);

        $this->assertArrayNotHasKey('riasec_profile', $payload[0]);
    }

    private function career(int $id, string $name, array $profile): object
    {
        return (object) [
            'id' => $id,
            'slug' => strtolower($name),
            'name' => $name,
            'realistic' => $profile[0],
            'investigative' => $profile[1],
            'artistic' => $profile[2],
            'social' => $profile[3],
            'enterprising' => $profile[4],
            'conventional' => $profile[5],
        ];
    }
}
