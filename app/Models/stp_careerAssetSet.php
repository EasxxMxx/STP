<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class stp_careerAssetSet extends Model
{
    protected $fillable = [
        'career_id', 'left_source_path', 'left_image_path',
        'center_source_path', 'center_image_path', 'right_source_path',
        'right_image_path', 'status', 'published_by', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function career(): BelongsTo
    {
        return $this->belongsTo(stp_career::class, 'career_id');
    }
}
