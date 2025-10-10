<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class stp_school_free_education extends Model
{
    use HasFactory;

    protected $table = 'stp_school_free_education'; 

    protected $fillable = [
        'id',
        'school_id',
        'free_education_id',
        'data_status',
        'updated_by',
        'created_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the school that owns this free education record
     */
    public function school()
    {
        return $this->belongsTo(stp_school::class, 'school_id', 'id');
    }

    /**
     * Get the free education type that this record belongs to
     */
    public function freeEducation()
    {
        return $this->belongsTo(stp_free_education::class, 'free_education_id', 'id');
    }
}
