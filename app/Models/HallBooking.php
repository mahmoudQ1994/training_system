<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HallBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'hall_id',
        'user_id',
        'booking_date',
        'end_date',               // ✅ أُضيف حقل تاريخ النهاية
        'start_time',
        'end_time',
        'purpose',
        'requesting_department',  // ✅ الجهة الطالبة
        'payment_status',         // ✅ حالة السداد
        'status',                 // ✅ حالة الحجز (pending / approved / rejected)
    ];

    // ✅ العلاقة مع القاعة
    public function hall()
    {
        return $this->belongsTo(TrainingHall::class, 'hall_id');
    }

    // ✅ العلاقة مع المستخدم الذي حجز
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'booking_date' => 'date',
        'end_date' => 'date',
    ];

}
