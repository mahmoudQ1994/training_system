<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'program_type',
        'organizer',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'instructor',
        'target_group',
        'trainees_count',  
        'created_by',
        'image_path',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function trainees()
    {
        return $this->hasMany(\App\Models\Trainee::class, 'program_id');
    }

}
