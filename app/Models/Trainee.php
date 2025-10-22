<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'name_ar',
        'name_en',
        'national_id',
        'email',
        'specialization',
        'job_title',
        'organization',
        'mobile',
        'created_by',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    
}
