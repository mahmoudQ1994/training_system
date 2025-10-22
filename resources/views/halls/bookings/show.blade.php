@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100">

    <div class="card shadow border-0 w-100">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-centerr">
            <h4 class="mb-0">
                <i class="bi bi-eye me-2"></i> تفاصيل الحجز رقم ({{ $booking->id }})
            </h4>
            <a href="{{ route('halls.bookings.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left"></i> رجوع
            </a>
        </div>

        <div class="card-body bg-white">

            {{-- ✅ عرض البيانات الأساسية --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>اسم القاعة:</strong> {{ $booking->hall->hall_name }}</p>
                    <p><strong>تاريخ الحجز:</strong> {{ $booking->booking_date }}</p>
                    <p><strong>تاريخ نهاية الحجز:</strong> {{ $booking->end_date ?? '---' }}</p>
                    <p><strong>وقت البداية:</strong> {{ $booking->start_time }}</p>
                    <p><strong>وقت النهاية:</strong> {{ $booking->end_time }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>الجهة الحاجزة:</strong> {{ $booking->requesting_department ?? 'غير محدد' }}</p>
                    <p><strong>الغرض من الحجز:</strong> {{ $booking->purpose ?? '---' }}</p>
                    <p><strong>حالة الحجز:</strong>
                        <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : 'warning' }}">
                            {{ $booking->status == 'approved' ? 'مؤكد' : 'قيد المراجعة' }}
                        </span>
                    </p>
                    <p><strong>مدفوع:</strong>
                        @if($booking->is_paid)
                            <span class="text-success fw-bold">✔️ نعم</span>
                        @else
                            <span class="text-danger fw-bold">❌ لا</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- ✅ معلومات المستخدم --}}
            <div class="alert alert-info mt-4">
                <i class="bi bi-person-circle me-2"></i>
                <strong>المستخدم الذي أنشأ الحجز:</strong> {{ $booking->user->name ?? '---' }}
            </div>

            {{-- ✅ الأزرار --}}
            <div class="d-flex justify-content-between mt-4">
                <div>
                    <a href="{{ route('halls.bookings.edit', $booking->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil-square"></i> تعديل
                    </a>

                    @if($booking->status !== 'approved')
                    <form action="{{ route('halls.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-success">
                            <i class="bi bi-check-circle"></i> تأكيد الحجز
                        </button>
                    </form>
                    @endif
                </div>

                <form action="{{ route('halls.bookings.destroy', $booking->id) }}" method="POST" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الحجز؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i> حذف
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
