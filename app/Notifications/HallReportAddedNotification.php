<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\HallReport;

class HallReportAddedNotification extends Notification
{
    use Queueable;

    protected $report;

    public function __construct(HallReport $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'تقرير قاعة جديد',
            'message' => "تم إضافة تقرير جديد للقاعة '{$this->report->hall->hall_name}' بتاريخ اليوم ({$this->report->inspection_date}).",
            'report_id' => $this->report->id,
        ];
    }
}
