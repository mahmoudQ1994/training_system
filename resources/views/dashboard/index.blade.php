@extends('layouts.app')

@section('content')
<div class="w-100 px-3 mt-4">

    {{-- رسالة الترحيب --}}
    <div class="bg-gradient bg-primary text-white p-2 rounded-2 shadow-sm mb-2 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">مرحباً بك، {{ Auth::user()->name }} 👋</h4> 
            <p class="mb-0 fs-6">نتمنى لك يوماً موفقاً في إدارة البرامج والحجوزات</p>
        </div>
        <div class="text-end">
            <h6 class="mb-0 fw-bold">{{ $todayDate }}</h6>
        </div>
    </div>

        {{-- عنوان الداشبورد --}}
    <div class="mb-4">
        <h5 class="text-primary fw-bold"> إحصائيات اليوم</h5>
        <p class="text-muted mb-0">يعرض الداشبورد معلومات القاعات، البرامج التدريبية والمتدربين ليوم {{ $todayDate }}</p>
    </div>

    {{-- كروت الإحصائيات --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-building fs-2 text-primary"></i>
                </div>
                <h6 class="text-muted">إجمالي القاعات</h6>
                <h3 class="fw-bold text-primary">{{ $totalHalls }}</h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-door-open fs-2 text-success"></i>
                </div>
                <h6 class="text-muted">القاعات المتاحة اليوم</h6>
                <h3 class="fw-bold text-success">{{ $availableHalls }}</h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-lock-fill fs-2 text-danger"></i>
                </div>
                <h6 class="text-muted">القاعات المحجوزة اليوم</h6>
                <h3 class="fw-bold text-danger">{{ $bookedHalls }}</h3>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-calendar-check fs-2 text-warning"></i>
                </div>
                <h6 class="text-muted">حجوزات اليوم</h6>
                <h3 class="fw-bold text-warning">{{ $todayBookings }}</h3>
            </div>
        </div>
    </div>

    {{-- كروت التدريب / البرامج / المتدربين --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-clipboard-data fs-2 text-primary"></i>
                </div>
                <h6 class="text-muted">عدد تقارير التدريب</h6>
                <h3 class="fw-bold text-primary mb-0">{{ $totalReports }}</h3>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-journal-text fs-2 text-success"></i>
                </div>
                <h6 class="text-muted">البرامج التدريبية اليوم</h6>
                <h3 class="fw-bold text-success mb-0">{{ $totalPrograms }}</h3>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm text-center p-0 hover-shadow transition w-100">
                <div class="rounded-circle p-1 mb-1 mx-auto">
                    <i class="bi bi-people-fill fs-2 text-warning"></i>
                </div>
                <h6 class="text-muted">عدد المتدربين اليوم</h6>
                <h3 class="fw-bold text-warning mb-0">{{ $totalTrainees }}</h3>
            </div>
        </div>
    </div>

    {{-- جدول القاعات المحجوزة اليوم --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm w-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">القاعات المحجوزة اليوم</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive w-100">
                        <table class="table table-striped table-hover mb-0 ">
                            <thead class="table-light">
                                <tr>
                                    <th>القاعة</th>
                                    <th>المبنى</th>
                                    <th>السعة</th>
                                    <th>الجهة الطالبة</th>
                                    <th>تاريخ بداية الحجز</th>
                                    <th>تاريخ نهاية الحجز</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookedHallsToday as $booking)
                                <tr>
                                    <td>{{ $booking->hall->hall_name ?? '-' }}</td>
                                    <td>{{ $booking->hall->building_name ?? '-' }}</td>
                                    <td>{{ $booking->hall->capacity ?? '-' }}</td>
                                    <td>{{ $booking->requesting_department ?? '-' }}</td>
                                    <td>{{ optional($booking->booking_date)->format('Y-m-d') ?? '-' }}</td>
                                    <td>{{ optional($booking->end_date)->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">لا توجد قاعات محجوزة اليوم</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول القاعات المتاحة اليوم --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm w-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">القاعات المتاحة اليوم</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive w-100">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>القاعة</th>
                                    <th>المبنى</th>
                                    <th>السعة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($availableHallsToday as $hall)
                                <tr>
                                    <td>{{ $hall->hall_name }}</td>
                                    <td>{{ $hall->building_name }}</td>
                                    <td>{{ $hall->capacity }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">لا توجد قاعات متاحة اليوم</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول البرامج التدريبية المنفذة اليوم --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm w-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">البرامج التدريبية المنفذة اليوم</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive w-100">
                        <table class="table table-striped table-hover mb-0 ">
                            <thead class="table-light">
                                <tr>
                                    <th>اسم البرنامج</th>
                                    <th>تاريخ البداية</th>
                                    <th>تاريخ النهاية</th>
                                    <th>مكان التنفيذ</th>
                                    <th>اسم المحاضر</th>
                                    <th>الجهة المنفذة</th>
                                    <th>عدد المتدربين</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programsToday as $program)
                                <tr>
                                    <td>{{ $program->title ?? '---------------------------' }}</td>
                                    <td>{{ $program->start_date->format('Y-m-d') }}</td>
                                    <td>{{ $program->end_date->format('Y-m-d') }}</td>
                                    <td>{{  $program->location ?? '-----------------------' }}</td>
                                    <td>{{ $program->trainer->name ?? 'غير محدد' }}</td>
                                    <td>{{ $program->organizer ?? '-----------------------' }}</td>
                                    <td>{{ $program->trainees()->count() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-3">لا توجد برامج تدريبية اليوم</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- أنماط جمالية --}}
<style>
.hover-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
}
.transition {
    transition: all 0.3s ease;
}

.table td, .table th {
    text-align: center;        /* توسيط النص أفقيًا */
    vertical-align: middle;    /* توسيط النص عموديًا */
}
</style>
@endsection
