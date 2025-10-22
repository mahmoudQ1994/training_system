<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // ✅ تحديث حالة القاعات إلى "متاحة" بعد انتهاء الحجز
        $schedule->call(function () {
            \App\Models\TrainingHall::whereDoesntHave('bookings', function ($query) {
                $query->where('end_date', '>=', now());
            })->update(['status' => 'متاحة']);
        })->dailyAt('01:00');

        
    }

    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
