<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class stp_personalityTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'score',
        'status',
        'share_token',
        'shared_at',
    ];

    protected $casts = [
        'shared_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(stp_student::class, 'student_id', 'id');
    }
}
