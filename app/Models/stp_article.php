<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stp_article extends Model
{
    use HasFactory;

    protected $table = 'stp_article';

    protected $fillable = [
        "category_id",
        "article_title",
        "article_author",
        "article_date",
        "article_featured",
        "article_views",
        "article_featured_image",
        "article_summary",
        "article_main_points_1",
        "article_main_points_2",
        "article_main_points_3",
        "article_content",
        "data_status",
        "updated_by",
        "created_by"
    ];

    protected $casts = [
        'category_id' => 'integer',
        'article_date' => 'date',
        'article_featured' => 'integer',
        'article_views' => 'integer',
        'data_status' => 'integer',
        'updated_by' => 'integer',
        'created_by' => 'integer',
    ];

    // Relationship with article category
    public function category()
    {
        return $this->belongsTo(stp_article_category::class, 'category_id');
    }

    // Relationship with article content images
    public function contentImages()
    {
        return $this->hasMany(stp_article_content_image::class, 'article_id')->where('data_status', 1)->orderBy('id');
    }

    // Relationship with article visits
    public function visits()
    {
        return $this->hasMany(stp_article_visit::class, 'article_id', 'id');
    }

    // Relationship with article comments
    public function comments()
    {
        return $this->hasMany(\App\Models\stp_article_comment::class, 'article_id', 'id')->where('data_status', 1);
    }
}

