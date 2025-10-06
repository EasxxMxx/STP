<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class stp_free_education extends Model
{
    use HasFactory;

    protected $table = 'stp_free_education'; 

    protected $fillable = [
        'id',
        'scheme_name',
        'state_id',
        'description',
        'text_color_code',
        'background_color_code',
        'data_status',
        'updated_by',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function schools()
    {
        return $this->hasMany(stp_school::class, 'free_education_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(stp_states::class, 'state_id', 'id');
    }

}
