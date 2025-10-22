<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\HallBooking;

class HallBookedTodayNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(HallBooking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        // نرسل الإشعار على قاعدة البيانات فقط (يمكن الإيميل أو Broadcast لاحقاً)
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'حجز قاعة جديد اليوم',
            'message' => "تم حجز القاعة '{$this->booking->hall->hall_name}' بتاريخ اليوم ({$this->booking->booking_date}).",
            'booking_id' => $this->booking->id,
        ];
    }
}
