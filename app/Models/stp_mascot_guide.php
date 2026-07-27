<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stp_mascot_guide extends Model
{
    use HasFactory;

    protected $table = 'stp_mascot_guides';

    protected $attributes = [
        'priority' => 0,
        'dismiss_scope' => 'session',
        'visit_condition' => 'any',
        'publication_status' => 'draft',
        'data_status' => 1,
    ];

    protected $fillable = [
        'guide_key',
        'title',
        'body',
        'cta_label',
        'cta_path',
        'page_patterns',
        'path_param_pattern',
        'trigger_type',
        'trigger_delay_ms',
        'trigger_threshold',
        'anchor_target',
        'image_path',
        'priority',
        'dismiss_scope',
        'visit_condition',
        'publication_status',
        'data_status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'page_patterns' => 'array',
        'trigger_delay_ms' => 'integer',
        'trigger_threshold' => 'integer',
        'priority' => 'integer',
        'data_status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];
}
