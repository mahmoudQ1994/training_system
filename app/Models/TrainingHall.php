<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingHall extends Model
{
    use HasFactory;

    protected $table = 'training_halls';

    protected $fillable = [
        'hall_name',
        'hall_code',
        'building_name',
        'floor_number',
        'capacity',
        'facilities',
        'status',
        'image',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'facilities' => 'array', // يسمح لك بالتعامل كمصفوفة في الكود
    ];

    // من أنشأ السجل
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    // من عدّل السجل مؤخراً
    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function images(){
        return $this->hasMany(HallImage::class, 'hall_id');
    }

    public function bookings(){
         return $this->hasMany(HallBooking::class, 'hall_id');
    }
}
