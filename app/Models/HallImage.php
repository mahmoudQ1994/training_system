<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallImage extends Model
{
    protected $fillable = ['hall_id', 'image_path'];

    public function hall()
    {
        return $this->belongsTo(TrainingHall::class);
    }
}
