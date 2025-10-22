@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3 px-4">

    {{-- ✅ العنوان والأزرار --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold mb-0">
            <i class="bi bi-calendar-check me-2"></i> حجز القاعة: {{ $hall->hall_name }}
        </h4>

        <a href="{{ route('halls.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> رجوع
        </a>
    </div>

    {{-- ✅ عرض أي رسالة خطأ عامة --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('halls.bookings.store', $hall->id) }}" method="POST" class="bg-white shadow-sm rounded-3 p-4">
        @csrf

        <div class="row g-3">
            {{-- تاريخ بداية الحجز --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">تاريخ بداية الحجز</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                @error('start_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- تاريخ نهاية الحجز --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">تاريخ نهاية الحجز</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                @error('end_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- وقت بداية اليوم --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">وقت بداية اليوم التدريبي</label>
                <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                @error('start_time') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- وقت نهاية اليوم --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">وقت نهاية اليوم التدريبي</label>
                <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                @error('end_time') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- الجهة الطالبة --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">الجهة الطالبة للحجز</label>
                <input type="text" name="requesting_department" class="form-control" placeholder="مثال: إدارة التدريب أو المستشفى العام" value="{{ old('requesting_department') }}" required>
                @error('requesting_department') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- حالة السداد --}}
            <div class="col-md-6">
                <label class="form-label fw-bold">حالة السداد</label>
                <select name="payment_status" class="form-select" required>
                    <option value="">-- اختر الحالة --</option>
                    <option value="paid" {{ old('payment_status')=='paid' ? 'selected' : '' }}>مدفوع</option>
                    <option value="unpaid" {{ old('payment_status')=='unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                </select>
                @error('payment_status') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- الغرض من الحجز --}}
            <div class="col-12">
                <label class="form-label fw-bold">الغرض من الحجز</label>
                <textarea name="purpose" class="form-control" rows="3" placeholder="اكتب الغرض من الحجز (اختياري)">{{ old('purpose') }}</textarea>
                @error('purpose') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- زر التأكيد --}}
        <button type="submit" class="btn btn-success btn-lg w-100 mt-4">
            <i class="bi bi-check-circle"></i> تأكيد الحجز
        </button>
    </form>

</div>
@endsection
