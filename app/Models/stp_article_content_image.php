<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stp_article_content_image extends Model
{
    use HasFactory;

    protected $table = 'stp_article_content_images';

    protected $fillable = [
        "article_id",
        "image_path",
        "image_alt",
        "data_status",
        "updated_by",
        "created_by"
    ];

    protected $casts = [
        'article_id' => 'integer',
        'data_status' => 'integer',
        'updated_by' => 'integer',
        'created_by' => 'integer',
    ];

    // Relationship with article
    public function article()
    {
        return $this->belongsTo(stp_article::class, 'article_id');
    }
}

