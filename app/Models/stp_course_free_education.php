<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class stp_course_free_education extends Model
{
    use HasFactory;

    protected $table = 'stp_course_free_education'; 

    protected $fillable = [
        'id',
        'course_id',
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
    public function course()
    {
        return $this->belongsTo(stp_course::class, 'course_id', 'id');
    }

    /**
     * Get the free education type that this record belongs to
     */
    public function freeEducation()
    {
        return $this->belongsTo(stp_free_education::class, 'free_education_id', 'id');
    }
}
