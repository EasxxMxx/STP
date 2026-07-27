<?php

namespace App\Http\Requests\MascotGuide;

class StoreMascotGuideRequest extends MascotGuideDraftRequest
{
    public function rules(): array
    {
        return [
            'guide_key' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'unique:stp_mascot_guides,guide_key',
            ],
            ...$this->contentRules(),
        ];
    }
}
