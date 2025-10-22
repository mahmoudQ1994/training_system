@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3 px-4">

    {{-- ✅ العنوان والأزرار --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold mb-0">
            <i class="bi bi-pencil-square me-2"></i> تعديل بيانات الحجز - {{ $booking->hall->hall_name }}
        </h4>

        <a href="{{ route('halls.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> رجوع
        </a>
    </div>

    {{-- ✅ عرض أي رسالة خطأ --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ✅ فورم التعديل --}}
    <form action="{{ route('halls.bookings.update', $booking->id) }}" method="POST" class="bg-white shadow-sm rounded-3 p-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
            {{-- 🔹 اختيار القاعة --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">اسم القاعة</label>
                <select name="hall_id" class="form-select" disabled>
                    <option value="{{ $booking->hall->id }}">{{ $booking->hall->hall_name }}</option>
                </select>
            </div>

            {{-- 🔹 الجهة الحاجزة --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">الجهة الطالبة للحجز</label>
                <input type="text" name="requesting_department"
                    value="{{ old('requesting_department', $booking->requesting_department) }}"
                    class="form-control" placeholder="اسم الجهة الحاجزة" required>
            </div>

            {{-- 🔹 تاريخ البداية --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">تاريخ بداية الحجز</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', $booking->booking_date) }}"
                    class="form-control" required>
            </div>

            {{-- 🔹 تاريخ النهاية --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">تاريخ نهاية الحجز</label>
                <input type="date" name="end_date"
                    value="{{ old('end_date', $booking->end_date) }}"
                    class="form-control" required>
            </div>

            {{-- 🔹 وقت البداية --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">وقت بداية اليوم التدريبي</label>
                <input type="time" name="start_time"
                    value="{{ old('start_time', $booking->start_time) }}"
                    class="form-control" required>
            </div>

            {{-- 🔹 وقت النهاية --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">وقت نهاية اليوم التدريبي</label>
                <input type="time" name="end_time"
                    value="{{ old('end_time', $booking->end_time) }}"
                    class="form-control" required>
            </div>

            {{-- 🔹 حالة السداد --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">حالة السداد</label>
                <select name="payment_status" class="form-select" required>
                    <option value="">-- اختر الحالة --</option>
                    <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>مدفوع</option>
                    <option value="unpaid" {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                </select>
            </div>

            {{-- 🔹 الغرض من الحجز --}}
            <div class="col-6">
                <label class="form-label fw-bold">الغرض من الحجز</label>
                <textarea name="purpose" class="form-control" rows="3"
                    placeholder="اكتب الغرض من الحجز (اختياري)">{{ old('purpose', $booking->purpose) }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
            <i class="bi bi-save"></i> حفظ التعديلات
        </button>
    </form>

</div>
@endsection
