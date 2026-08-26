<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class stp_RIASECType extends Model
{
    use HasFactory;
    protected $table = 'stp_riasecTypes';

    protected $fillable = [
        'type_name',
        'unique_description',
        'strength',
        'status'
    ];

    public function personalityQuestion(): hasMany
    {
        return $this->hasMany(stp_personalityQuestions::class, 'riasec_type', 'id');
    }

    public function courseCategory(): hasMany
    {
        return $this->hasMany(stp_courses_category::class, 'riasec_type', 'id');
    }

    public function posterAssetSets(): HasMany
    {
        return $this->hasMany(stp_riasecPosterAssetSet::class, 'riasec_type_id');
    }
}
