<?php

namespace App\Http\Requests\MascotGuide;

class UpdateMascotGuideRequest extends MascotGuideDraftRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:stp_mascot_guides,id'],
            'guide_key' => ['prohibited'],
            ...$this->contentRules(),
        ];
    }
}
