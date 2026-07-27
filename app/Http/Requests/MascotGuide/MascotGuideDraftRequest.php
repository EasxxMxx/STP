<?php

namespace App\Http\Requests\MascotGuide;

use App\Services\MascotGuideService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

abstract class MascotGuideDraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function contentRules(): array
    {
        return [
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'body' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'cta_label' => ['sometimes', 'nullable', 'string', 'max:100'],
            'cta_path' => ['sometimes', 'nullable', 'string', 'max:500', 'regex:~^/(?!/).*$~'],
            'page_patterns' => ['sometimes', 'nullable', 'array', 'min:1'],
            'page_patterns.*' => ['required', 'string', 'max:500', 'regex:~^/[^*]*(?:\*)?$~'],
            'path_param_pattern' => ['sometimes', 'nullable', 'string', 'max:500', 'regex:~^/[^*]+$~'],
            'trigger_type' => ['sometimes', 'nullable', Rule::in(MascotGuideService::TRIGGER_TYPES)],
            'trigger_delay_ms' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:600000'],
            'trigger_threshold' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:1000'],
            'anchor_target' => ['sometimes', 'nullable', Rule::in(MascotGuideService::ANCHOR_TARGETS)],
            'priority' => ['sometimes', 'integer', 'min:-100000', 'max:100000'],
            'dismiss_scope' => ['sometimes', 'nullable', Rule::in(['session'])],
            'visit_condition' => [
                'sometimes',
                'nullable',
                Rule::in(MascotGuideService::VISIT_CONDITIONS),
            ],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                app(MascotGuideService::class)->validateCtaParameters($validator, $this->all());
            },
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Invalid Validation',
            'errors' => $validator->errors(),
        ], 422));
    }
}
