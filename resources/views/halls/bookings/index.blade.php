@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary mb-0">
        <i class="bi bi-calendar-check me-2"></i> إدارة حجوزات القاعات
    </h3>

    {{-- ✅ زر إضافة حجز جديد --}}
    <a href="{{ route('halls.bookings.create', $availableHalls->first()->id ?? 1) }}" 
       class="btn btn-success px-4">
        <i class="bi bi-plus-circle me-1"></i> إضافة حجز جديد
    </a>
</div>


    {{-- ✅ القاعات المحجوزة --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-lock-fill me-2"></i> القاعات المحجوزة</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0 text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>اسم القاعة</th>
                        <th>الجهة الحاجزة</th>
                        <th>تاريخ الحجز</th>
                        <th>تاريخ نهاية الحجز</th>
                        <th>المستخدم</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookedHalls as $hall)
                        @foreach ($hall->bookings as $booking)
                            <tr>
                                <td>{{ $hall->hall_name }}</td>
                                <td>{{ $booking->requesting_department ?? 'غير محدد' }}</td>
                                <td>{{ $booking->booking_date }}</td>
                                <td>{{ $booking->end_date }}</td>
                                <td>{{ $booking->user->name ?? '---' }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ $booking->status == 'approved' ? 'مؤكد' : 'قيد المراجعة' }}
                                    </span>
                                </td>
                                <td class="d-flex justify-content-center gap-2 flex-wrap">
                                    {{-- زر العرض --}}
                                    <a href="{{ route('halls.bookings.show', $booking->id) }}" 
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> </a>

                                    {{-- زر التعديل --}}
                                    <a href="{{ route('halls.bookings.edit', $booking->id) }}" 
                                    class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> </a>
                                    </a>

                                    {{-- زر التأكيد --}}
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('halls.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-check-circle"></i> 
                                            </button>
                                        </form>
                                    @endif

                                    {{-- زر الحذف --}}
                                    <form action="{{ route('halls.bookings.destroy', $booking->id) }}" method="POST" class="d-inline" 
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الحجز؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr><td colspan="8" class="text-muted py-3">لا توجد قاعات محجوزة حاليًا</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- ✅ القاعات المتاحة --}}
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-door-open-fill me-2"></i> القاعات المتاحة للحجز</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0 text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>اسم القاعة</th>
                        <th>السعة</th>
                        <th>المبنى</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($availableHalls as $hall)
                        <tr>
                            <td>{{ $hall->hall_name }}</td>
                            <td>{{ $hall->capacity ?? '---' }}</td>
                            <td>{{ $hall->building_name ?? '---' }}</td>
                            <td><span class="badge bg-success">متاحة</span></td>
                            <td>
                                <a href="{{ route('halls.bookings.create', $hall->id) }}" 
                                   class="btn btn-outline-success btn-sm">
                                   <i class="bi bi-calendar-plus"></i> احجز الآن
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted py-3">لا توجد قاعات متاحة حالياً</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
