<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Program;

class ProgramScheduledTodayNotification extends Notification
{
    use Queueable;

    protected $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'برنامج مقرر اليوم',
            'message' => "تم جدولة البرنامج '{$this->program->title}' اليوم ({$this->program->start_date}).",
            'program_id' => $this->program->id,
        ];
    }
}
