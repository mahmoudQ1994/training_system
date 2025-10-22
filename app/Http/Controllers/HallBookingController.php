<?php

namespace App\Http\Controllers;

use App\Models\TrainingHall;
use App\Models\HallBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\HallBookedTodayNotification;
use App\Models\User;

class HallBookingController extends \Illuminate\Routing\Controller
{

    public function index()
    {
        // ✅ القاعات المحجوزة حالياً
        $bookedHalls = TrainingHall::whereHas('bookings', function ($q) {
            $q->whereIn('status', ['approved', 'pending']);
        })
        ->with(['bookings' => function ($q) {
            $q->latest();
        }])->get();

        // ✅ القاعات المتاحة
        $availableHalls = TrainingHall::whereDoesntHave('bookings', function ($q) {
            $q->whereIn('status', ['approved', 'pending']);
        })->get();

        return view('halls.bookings.index', compact('bookedHalls', 'availableHalls'));
    }

    public function create(TrainingHall $hall)
    {
        return view('halls.bookings.create', compact('hall'));
    }

    public function store(Request $request, TrainingHall $hall)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'requesting_department' => 'required|string|max:255',
            'payment_status' => 'required|in:paid,unpaid',
            'purpose' => 'nullable|string|max:255',
        ]);

        // ✅ التأكد من عدم وجود حجز متداخل
        $conflict = HallBooking::where('hall_id', $hall->id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('booking_date', [$request->start_date, $request->end_date]);
            })
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', '⚠️ القاعة محجوزة بالفعل في جزء من هذه الفترة.');
        }

        // ✅ إنشاء الحجز
        $booking = HallBooking::create([
            'hall_id' => $hall->id,
            'user_id' => Auth::id(),
            'booking_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'requesting_department' => $request->requesting_department,
            'payment_status' => $request->payment_status,
            'status' => 'pending',
        ]);

        $hall->update(['status' => 'محجوزة']);

         // ✅ إرسال إشعار لجميع المستخدمين
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new HallBookedTodayNotification($booking));
        }

        return redirect()->route('halls.bookings.index')->with('success', '✅ تم إنشاء الحجز وإرسال الإشعارات بنجاح!');
    }

    public function show(HallBooking $booking)
    {
        return view('halls.bookings.show', compact('booking'));
    }

    public function edit(HallBooking $booking)
    {
        $halls = TrainingHall::all();
        return view('halls.bookings.edit', compact('booking', 'halls'));
    }

    public function update(Request $request, HallBooking $booking)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'requesting_department' => 'required|string|max:255',
            'payment_status' => 'required|in:paid,unpaid',
            'purpose' => 'nullable|string|max:255',
        ]);

        // ✅ التحقق من عدم وجود تعارض مع حجوزات أخرى
        $conflict = HallBooking::where('hall_id', $booking->hall_id)
            ->where(function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->whereBetween('booking_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
                });
            })
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($conflict) {
            return back()->with('error', '⚠️ القاعة محجوزة بالفعل في جزء من هذه الفترة.');
        }

        // ✅ تحديث بيانات الحجز
        $booking->update([
            'booking_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'requesting_department' => $request->requesting_department,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('halls.bookings.index')->with('success', '✅ تم تحديث بيانات الحجز بنجاح!');
    }


    public function destroy(HallBooking $booking)
    {
        $booking->delete();

        return redirect()->route('halls.bookings.index')->with('success', '✅ تم حذف الحجز بنجاح!');
    }

    public function approve(HallBooking $booking)
    {
        $booking->update(['status' => 'approved']);
        $booking->hall->update(['status' => 'محجوزة']);

        return redirect()->route('halls.bookings.index')->with('success', '✅ تم تأكيد الحجز بنجاح!');
    }

    public function reject(HallBooking $booking)
    {
        $booking->update(['status' => 'rejected']);

        if (!$booking->hall->bookings()->where('status', 'approved')->exists()) {
            $booking->hall->update(['status' => 'متاحة']);
        }

        return redirect()->route('halls.bookings.index')->with('success', '❌ تم رفض الحجز بنجاح!');
    }

    public function schedule()
    {
        return view('halls.bookings.schedule');
    }

    public function timetable(Request $request)
    {
        // الحصول على الشهر الحالي أو الشهر المطلوب بصيغة كاملة
    $month = $request->input('month', date('Y-m'));

    // لو المستخدم أرسل month مثل "25-10" نحاول تصحيحه
    if (preg_match('/^\d{2}-\d{2}$/', $month)) {
        $month = '20' . $month; // يحوله إلى 2025-10
    }

    $startOfMonth = \Carbon\Carbon::parse($month . '-01')->startOfMonth();
    $endOfMonth = $startOfMonth->copy()->endOfMonth();

    // جلب كل القاعات والحجوزات ضمن هذا الشهر
    $halls = TrainingHall::with(['bookings' => function ($q) use ($startOfMonth, $endOfMonth) {
        $q->where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('booking_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->orWhereBetween('end_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()]);
        });
    }])->get();

    return view('halls.bookings.timetable', compact('halls', 'month', 'startOfMonth', 'endOfMonth'));
    }


    
}
