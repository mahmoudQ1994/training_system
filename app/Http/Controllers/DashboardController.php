<?php

namespace App\Http\Controllers;

use App\Models\TrainingHall;
use App\Models\HallBooking;
use App\Models\HallReport;
use App\Models\Program;
use App\Models\SystemSetting;
use App\Models\Trainee;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ✅ القاعات التي يوجد لها حجز اليوم
        $bookedHallsToday = HallBooking::with('hall')
            ->whereDate('booking_date', $today)
            ->get();

        // ✅ القاعات التي لم تُحجز اليوم
        $availableHallsToday = TrainingHall::whereDoesntHave('bookings', function($query) use ($today) {
            $query->whereDate('booking_date', $today);
        })->get();

        // ✅ البرامج التدريبية التي تُنفذ اليوم
        $programsToday = Program::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        // باقي الإحصائيات للكروت
        $totalHalls       = TrainingHall::count();
        $totalReports     = HallReport::count();
        $totalPrograms    = $programsToday->count();

        // ✅ عدد المتدربين المنفذين برامج اليوم
        $totalTrainees = 0;
        foreach ($programsToday as $program) {
            $totalTrainees += $program->trainees()->count();
        }

        $todayBookings    = HallBooking::whereDate('booking_date', $today)->count();
        $bookedHalls      = $bookedHallsToday->count();
        $availableHalls   = $availableHallsToday->count();

        $todayDate = Carbon::now()->translatedFormat('l, d F Y');

        return view('dashboard.index', compact(
            'totalHalls',
            'availableHalls',
            'bookedHalls',
            'todayBookings',
            'totalPrograms',
            'totalTrainees',
            'bookedHallsToday',
            'availableHallsToday',
            'programsToday',
            'totalReports',
            'todayDate'
        ));
    }
}
