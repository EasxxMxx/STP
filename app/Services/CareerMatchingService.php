<?php

namespace App\Services;

use App\Models\stp_career;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CareerMatchingService
{
    public const VERSION = 1;

    public const TYPES = [
        'Realistic',
        'Investigative',
        'Artistic',
        'Social',
        'Enterprising',
        'Conventional',
    ];

    public function normalizeScores(array $scores): array
    {
        $normalized = [];

        foreach ($scores as $type => $score) {
            $canonicalType = ucfirst(strtolower(trim((string) $type)));

            if (! in_array($canonicalType, self::TYPES, true)) {
                throw ValidationException::withMessages([
                    'scores' => ["Unknown RIASEC type: {$type}."],
                ]);
            }

            if (array_key_exists($canonicalType, $normalized)) {
                throw ValidationException::withMessages([
                    'scores' => ["Duplicate RIASEC type: {$canonicalType}."],
                ]);
            }

            if (! is_numeric($score) || (float) $score < 0 || (float) $score > 100) {
                throw ValidationException::withMessages([
                    "scores.{$type}" => ['Each RIASEC score must be numeric and between 0 and 100.'],
                ]);
            }

            $normalized[$canonicalType] = round((float) $score, 2);
        }

        $missingTypes = array_values(array_diff(self::TYPES, array_keys($normalized)));

        if (count($normalized) !== count(self::TYPES) || $missingTypes) {
            throw ValidationException::withMessages([
                'scores' => ['Scores must contain exactly: '.implode(', ', self::TYPES).'.'],
            ]);
        }

        return array_replace(array_fill_keys(self::TYPES, 0), $normalized);
    }

    public function match(array $scores): array
    {
        return $this->rankCareers(
            $this->normalizeScores($scores),
            stp_career::query()->where('status', 1)->orderBy('name')->get()
        );
    }

    public function rankCareers(array $normalizedScores, Collection $careers): array
    {
        $normalizedScores = $this->normalizeScores($normalizedScores);

        if ($careers->count() < 3) {
            throw new \RuntimeException('At least three active career profiles are required.');
        }

        $studentTopTypes = collect($normalizedScores)
            ->sortDesc()
            ->keys()
            ->take(3)
            ->values();
        $maximumDistance = sqrt(count(self::TYPES) * (100 ** 2));

        return $careers
            ->map(function ($career) use ($normalizedScores, $studentTopTypes, $maximumDistance) {
                $profile = $this->careerProfile($career);
                $squaredDistance = 0.0;

                foreach (self::TYPES as $type) {
                    $squaredDistance += ($normalizedScores[$type] - $profile[$type]) ** 2;
                }

                $matchPercentage = (int) round(
                    max(0, min(100, 100 * (1 - (sqrt($squaredDistance) / $maximumDistance))))
                );
                $alignedTypes = $studentTopTypes
                    ->sortBy(fn ($type) => abs($normalizedScores[$type] - $profile[$type]))
                    ->take(2)
                    ->values();

                return [
                    'career_id' => (int) $career->id,
                    'slug' => $career->slug,
                    'name' => $career->name,
                    'match_percentage' => $matchPercentage,
                    'reason' => $this->buildReason($alignedTypes),
                    'riasec_profile' => $profile,
                ];
            })
            ->sort(function (array $first, array $second) {
                return ($second['match_percentage'] <=> $first['match_percentage'])
                    ?: strcmp($first['name'], $second['name']);
            })
            ->take(3)
            ->values()
            ->map(function (array $match, int $index) {
                return ['rank' => $index + 1] + $match;
            })
            ->all();
    }

    public function toApiPayload(array $matches): array
    {
        return array_map(function (array $match) {
            unset($match['riasec_profile']);

            return $match;
        }, $matches);
    }

    private function careerProfile($career): array
    {
        return collect(self::TYPES)
            ->mapWithKeys(fn ($type) => [$type => (int) $career->{strtolower($type)}])
            ->all();
    }

    private function buildReason(Collection $types): string
    {
        if ($types->count() < 2) {
            return 'Your RIASEC interests align strongly with this career.';
        }

        return "Your {$types[0]} and {$types[1]} interests align strongly with this career.";
    }
}
