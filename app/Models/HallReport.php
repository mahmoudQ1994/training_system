<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_id',
        'inspection_date',
        'inspected_by',
        'chairs_count',
        'lecturer_desk',
        'display_screen',
        'computer_available',
        'cables_available',
        'paper_board',
        'white_board',
        'air_conditioning',
        'air_conditioning_count',
        'internet_available',
        'sound_system',
        'lighting_good',
        'ventilation_good',
        'waiting_area',
        'buffet_available',
        'toilets_available',
        'fire_extinguishers',
        'emergency_exit',
        'notes',
        'readiness_percent',
        'created_by',
        'updated_by',
    ];

    public function hall()
    {
        return $this->belongsTo(TrainingHall::class, 'hall_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    
}
