<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class stp_riasecPosterAssetSet extends Model
{
    protected $fillable = [
        'riasec_type_id', 'animal_name', 'animal_source_path', 'animal_image_path',
        'traits', 'accent_color', 'status', 'published_by', 'published_at',
    ];

    protected $casts = ['traits' => 'array', 'published_at' => 'datetime'];

    public function riasecType(): BelongsTo
    {
        return $this->belongsTo(stp_RIASECType::class, 'riasec_type_id');
    }
}
