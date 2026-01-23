<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stp_article_comment extends Model
{
    use HasFactory;

    protected $table = 'stp_article_comments';

    protected $fillable = [
        "article_id",
        "student_id",
        "parent_id",
        "reply_to_id",
        "comment_level",
        "comment_text",
        "author_name",
        "data_status",
        "updated_by",
        "created_by"
    ];

    protected $casts = [
        'article_id' => 'integer',
        'student_id' => 'integer',
        'parent_id' => 'integer',
        'reply_to_id' => 'integer',
        'comment_level' => 'integer',
        'data_status' => 'integer',
        'updated_by' => 'integer',
        'created_by' => 'integer',
    ];

    // Relationships
    public function article()
    {
        return $this->belongsTo(stp_article::class, 'article_id');
    }

    public function student()
    {
        return $this->belongsTo(stp_student::class, 'student_id');
    }

    public function parent()
    {
        return $this->belongsTo(stp_article_comment::class, 'parent_id');
    }

    public function replyTo()
    {
        return $this->belongsTo(stp_article_comment::class, 'reply_to_id');
    }

    public function replies()
    {
        return $this->hasMany(stp_article_comment::class, 'parent_id')->where('data_status', 1);
    }
}
