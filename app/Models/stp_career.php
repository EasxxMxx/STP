<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class stp_career extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'realistic',
        'investigative',
        'artistic',
        'social',
        'enterprising',
        'conventional',
        'status',
    ];

    protected $casts = [
        'realistic' => 'integer',
        'investigative' => 'integer',
        'artistic' => 'integer',
        'social' => 'integer',
        'enterprising' => 'integer',
        'conventional' => 'integer',
        'status' => 'integer',
    ];

    public function assetSets(): HasMany
    {
        return $this->hasMany(stp_careerAssetSet::class, 'career_id');
    }
}
