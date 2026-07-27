<?php

namespace App\Services;

use App\Models\stp_mascot_guide;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MascotGuideService
{
    public const TRIGGER_TYPES = ['immediate', 'delay', 'idle', 'courseViewCount'];

    public const ANCHOR_TARGETS = ['find-path', 'articles'];

    public const VISIT_CONDITIONS = ['any', 'first', 'returning'];

    public function publicGuides()
    {
        return stp_mascot_guide::query()
            ->where('publication_status', 'published')
            ->where('data_status', 1)
            ->orderByDesc('priority')
            ->orderBy('id')
            ->get()
            ->map(fn (stp_mascot_guide $guide) => $this->toPublicPayload($guide))
            ->values();
    }

    public function create(array $attributes, ?UploadedFile $image, int $adminId): stp_mascot_guide
    {
        $imagePath = $image?->store('mascot-guides', 'public');

        try {
            return DB::transaction(function () use ($attributes, $imagePath, $adminId) {
                return stp_mascot_guide::create([
                    ...$attributes,
                    'image_path' => $imagePath,
                    'publication_status' => 'draft',
                    'data_status' => 1,
                    'created_by' => $adminId,
                    'updated_by' => $adminId,
                ]);
            });
        } catch (\Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            throw $exception;
        }
    }

    public function update(
        stp_mascot_guide $guide,
        array $attributes,
        ?UploadedFile $image,
        int $adminId
    ): stp_mascot_guide {
        $oldImagePath = $guide->image_path;
        $newImagePath = $image?->store('mascot-guides', 'public');

        try {
            DB::transaction(function () use ($guide, $attributes, $newImagePath, $adminId) {
                $guide->update([
                    ...$attributes,
                    ...($newImagePath ? ['image_path' => $newImagePath] : []),
                    'updated_by' => $adminId,
                ]);
            });
        } catch (\Throwable $exception) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $exception;
        }

        if ($newImagePath && $oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $guide->refresh();
    }

    public function publish(stp_mascot_guide $guide, int $adminId): stp_mascot_guide
    {
        if ($guide->data_status !== 1) {
            throw ValidationException::withMessages([
                'id' => ['Archived mascot guides cannot be published.'],
            ]);
        }

        $this->validateForPublishing($guide);
        $guide->update([
            'publication_status' => 'published',
            'updated_by' => $adminId,
        ]);

        return $guide->refresh();
    }

    public function unpublish(stp_mascot_guide $guide, int $adminId): stp_mascot_guide
    {
        $guide->update([
            'publication_status' => 'draft',
            'updated_by' => $adminId,
        ]);

        return $guide->refresh();
    }

    public function archive(stp_mascot_guide $guide, int $adminId): stp_mascot_guide
    {
        $guide->update([
            'publication_status' => 'draft',
            'data_status' => 0,
            'updated_by' => $adminId,
        ]);

        return $guide->refresh();
    }

    public function toAdminPayload(stp_mascot_guide $guide): array
    {
        return [
            'id' => $guide->id,
            'guide_key' => $guide->guide_key,
            'title' => $guide->title,
            'body' => $guide->body,
            'cta_label' => $guide->cta_label,
            'cta_path' => $guide->cta_path,
            'page_patterns' => $guide->page_patterns,
            'path_param_pattern' => $guide->path_param_pattern,
            'trigger_type' => $guide->trigger_type,
            'trigger_delay_ms' => $guide->trigger_delay_ms,
            'trigger_threshold' => $guide->trigger_threshold,
            'anchor_target' => $guide->anchor_target,
            'image_url' => $this->imageUrl($guide->image_path),
            'priority' => $guide->priority,
            'dismiss_scope' => $guide->dismiss_scope,
            'visit_condition' => $guide->visit_condition,
            'publication_status' => $guide->publication_status,
            'data_status' => $guide->data_status,
            'created_by' => $guide->created_by,
            'updated_by' => $guide->updated_by,
            'created_at' => $guide->created_at?->toISOString(),
            'updated_at' => $guide->updated_at?->toISOString(),
        ];
    }

    private function toPublicPayload(stp_mascot_guide $guide): array
    {
        $trigger = ['type' => $guide->trigger_type];

        if (in_array($guide->trigger_type, ['delay', 'idle'], true)) {
            $trigger['delayMs'] = $guide->trigger_delay_ms;
        }

        if ($guide->trigger_type === 'courseViewCount') {
            $trigger['threshold'] = $guide->trigger_threshold;
        }

        return [
            'id' => $guide->guide_key,
            'pagePatterns' => $guide->page_patterns,
            'pathParamPattern' => $guide->path_param_pattern,
            'priority' => $guide->priority,
            'title' => $guide->title,
            'body' => $guide->body,
            'ctaLabel' => $guide->cta_label,
            'ctaTo' => $guide->cta_path,
            'trigger' => $trigger,
            'anchorTarget' => $guide->anchor_target,
            'imageSrc' => $this->imageUrl($guide->image_path),
            'dismissScope' => $guide->dismiss_scope,
            'visitCondition' => $guide->visit_condition,
        ];
    }

    private function imageUrl(?string $path): ?string
    {
        return $path ? url(Storage::disk('public')->url($path)) : null;
    }

    private function validateForPublishing(stp_mascot_guide $guide): void
    {
        $data = $guide->only([
            'title',
            'body',
            'cta_label',
            'cta_path',
            'page_patterns',
            'path_param_pattern',
            'trigger_type',
            'trigger_delay_ms',
            'trigger_threshold',
            'anchor_target',
            'dismiss_scope',
            'visit_condition',
        ]);

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
            'cta_label' => ['required', 'string', 'max:100'],
            'cta_path' => ['required', 'string', 'max:500', 'regex:~^/(?!/).*$~'],
            'page_patterns' => ['required', 'array', 'min:1'],
            'page_patterns.*' => ['required', 'string', 'max:500', 'regex:~^/[^*]*(?:\*)?$~'],
            'path_param_pattern' => ['nullable', 'string', 'max:500', 'regex:~^/[^*]+$~'],
            'trigger_type' => ['required', Rule::in(self::TRIGGER_TYPES)],
            'trigger_delay_ms' => [
                Rule::requiredIf(in_array($guide->trigger_type, ['delay', 'idle'], true)),
                'nullable',
                'integer',
                'min:0',
                'max:600000',
            ],
            'trigger_threshold' => [
                Rule::requiredIf($guide->trigger_type === 'courseViewCount'),
                'nullable',
                'integer',
                'min:1',
                'max:1000',
            ],
            'anchor_target' => ['nullable', Rule::in(self::ANCHOR_TARGETS)],
            'dismiss_scope' => ['required', Rule::in(['session'])],
            'visit_condition' => ['required', Rule::in(self::VISIT_CONDITIONS)],
        ]);

        $validator->after(function ($validator) use ($data) {
            $this->validateCtaParameters($validator, $data);
        });

        $validator->validate();
    }

    public function validateCtaParameters($validator, array $data): void
    {
        $ctaPath = $data['cta_path'] ?? null;
        if (! is_string($ctaPath)) {
            return;
        }

        preg_match_all('/:([A-Za-z][A-Za-z0-9_]*)/', $ctaPath, $ctaMatches);
        $ctaParameters = array_unique($ctaMatches[1] ?? []);
        if ($ctaParameters === []) {
            return;
        }

        $parameterPattern = $data['path_param_pattern'] ?? null;
        if (! is_string($parameterPattern) || $parameterPattern === '') {
            $validator->errors()->add(
                'path_param_pattern',
                'A path parameter pattern is required when the CTA contains parameters.'
            );

            return;
        }

        preg_match_all('/:([A-Za-z][A-Za-z0-9_]*)/', $parameterPattern, $patternMatches);
        $availableParameters = array_unique($patternMatches[1] ?? []);

        foreach ($ctaParameters as $parameter) {
            if (! in_array($parameter, $availableParameters, true)) {
                $validator->errors()->add(
                    'cta_path',
                    "The CTA parameter :{$parameter} is not available in path_param_pattern."
                );
            }
        }
    }
}
