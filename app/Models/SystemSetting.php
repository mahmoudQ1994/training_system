<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'directorate_name',
        'department_name',
        'primary_color',
        'secondary_color',
        'default_language',
        'default_email',
        'notifications_enabled',
        'logo_path',
    ];
}
