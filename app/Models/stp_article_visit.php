<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stp_article_visit extends Model
{
    use HasFactory;

    protected $table = 'stp_article_visits';

    protected $fillable = [
        'article_id',
        'totalNumberVisit',
        'status',
        'updated_by',
        'created_by'
    ];

    protected $casts = [
        'article_id' => 'integer',
        'totalNumberVisit' => 'integer',
        'status' => 'integer',
        'updated_by' => 'integer',
        'created_by' => 'integer',
    ];

    // Relationship with article
    public function article()
    {
        return $this->belongsTo(stp_article::class, 'article_id', 'id');
    }
}

