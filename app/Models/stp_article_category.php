<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stp_article_category extends Model
{
    use HasFactory;

    protected $table = 'stp_article_category';

    protected $fillable = [
        "category_name",
        "color_code",
        "description",
        "data_status",
        "updated_by",
        "created_by"
    ];

    protected $casts = [
        'data_status' => 'integer',
        'updated_by' => 'integer',
        'created_by' => 'integer',
    ];
}

