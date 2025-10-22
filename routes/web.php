<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TrainingHallController;
use App\Http\Controllers\HallImageController;
use App\Http\Controllers\HallBookingController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\HallReportController;
use App\Http\Controllers\DashboardController;


// الصفحة الرئيسية → تسجيل الدخول
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

// لوحة التحكم
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


//  كل ما يلي يتطلب تسجيل الدخول والتحقق
// --------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    //  إدارة القاعات
    Route::prefix('halls')->name('halls.')->group(function () {
        // 🔹 القاعات
        Route::resource('/', TrainingHallController::class)
            ->parameters(['' => 'hall'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'show' => 'show',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);

        //  صور القاعات
        Route::get('{hall}/images', [HallImageController::class, 'index'])->name('images.index');
        Route::post('{hall}/images', [HallImageController::class, 'store'])->name('images.store');
        Route::delete('images/{image}', [HallImageController::class, 'destroy'])->name('images.destroy');

        //  إدارة جميع الحجوزات (محجوزة ومتاحة)
        Route::get('/bookings/all', [HallBookingController::class, 'index'])->name('bookings.index');
        // تعديل / عرض حجز
        Route::get('bookings/{booking}', [\App\Http\Controllers\HallBookingController::class, 'show'])->name('bookings.show');
        // إنشاء طلب حجز جديد
        Route::get('{hall}/booking/create', [HallBookingController::class, 'create'])->name('bookings.create');
        Route::post('{hall}/booking', [HallBookingController::class, 'store'])->name('bookings.store');
        // تعديل، تحديث، حذف الحجز
        Route::get('bookings/{booking}/edit', [HallBookingController::class, 'edit'])->name('bookings.edit');
        Route::put('bookings/{booking}', [HallBookingController::class, 'update'])->name('bookings.update');
        Route::delete('bookings/{booking}', [HallBookingController::class, 'destroy'])->name('bookings.destroy');
        // الموافقة / الرفض
        Route::patch('bookings/{booking}/approve', [HallBookingController::class, 'approve'])->name('bookings.approve');
        Route::patch('bookings/{booking}/reject', [HallBookingController::class, 'reject'])->name('bookings.reject');
        // عرض صفحة الجدول الزمني (افتراضيًا الشهر الحالي)
        Route::get('/halls/bookings/timetable', [HallBookingController::class, 'timetable'])
            ->name('halls.bookings.timetable');
        // عرض صفحة الجدول فقط (صفحة تحتوي على زر فتح الجدول)
        Route::get('/halls/bookings/schedule', [HallBookingController::class, 'schedule'])
            ->name('halls.bookings.schedule');


    });

    //  تقارير المرور على القاعات
    Route::resource('hall_reports', HallReportController::class);

    //  البرامج التدريبية
    Route::prefix('programs')->name('programs.')->group(function () {
        Route::get('/', [ProgramController::class, 'index'])->name('index');
        Route::get('/create', [ProgramController::class, 'create'])->name('create');
        Route::post('/', [ProgramController::class, 'store'])->name('store');
        Route::get('/courses', [ProgramController::class, 'courses'])->name('courses');
        Route::get('/days', [ProgramController::class, 'days'])->name('days');
        Route::get('/conferences', [ProgramController::class, 'conferences'])->name('conferences');
        Route::get('/{program}', [ProgramController::class, 'show'])->name('show');
        Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('edit');
        Route::put('/{program}', [ProgramController::class, 'update'])->name('update');
        Route::delete('/{program}', [ProgramController::class, 'destroy'])->name('destroy');
    });

    // المتدربون
    Route::prefix('trainees')->name('trainees.')->group(function () {
        Route::get('/by-date', [TraineeController::class, 'byDate'])->name('byDate');
        Route::get('/reports', [TraineeController::class, 'reports'])->name('reports');
        Route::resource('/', TraineeController::class)->parameters(['' => 'trainee']);
    });

    //  إدارة المستخدمين
    Route::resource('users', UserController::class);

    //  الإعدادات العامة للنظام
    Route::get('/settings', [SystemSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SystemSettingController::class, 'update'])->name('settings.update');

    // الإشعارات
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');
    

    // تعليم إشعار كمقروء
    Route::patch('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])
        ->name('notifications.markRead');

    // حذف إشعار
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
    ->name('notifications.destroy');
    //  الملف الشخصى
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/update-photo', [ProfileController::class, 'updatePhoto'])->name('updatePhoto');
    });
});

// --------------------------------------------------------------------------
//  مصادقة المستخدمين (Auth)
// --------------------------------------------------------------------------
require __DIR__ . '/auth.php';
