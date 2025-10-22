@extends('layouts.app')
@section('content')
<div class="p-1 bg-light min-vh-100">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary mb-4">
                <i class="bi bi-building-check me-2"></i>   تفاصيل قاعة التدريب  : 
             {{ $hall->hall_name }}</h4>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">اسم القاعة:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->hall_name }}  
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">رمز القاعة:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->hall_code ?? '—' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">المبنى:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->building_name ?? '—' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">الدور / الطابق:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->floor_number ?? '—' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">السعة:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->capacity ?? '—' }}
                    </div>
                </div>
                <div class="col-9">
                    <label class="form-label fw-semibold">التجهيزات:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ is_array($hall->facilities) ? implode(', ', $hall->facilities) : $hall->facilities ?? '—' }}
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">الملاحظات:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->notes ?? '—' }}
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">الحالة:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->status ?? '—' }}
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">اضفها:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->creator?->name ?? '—' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">تاريخ الاضافة:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->created_at->format('Y-m-d') }}
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">آخر تعديل بواسطة:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->updater?->name ?? '—' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">تاريخ آخر تعديل:</label>
                    <div class="p-2 border bg-white rounded">
                        {{ $hall->updated_at ? $hall->updated_at->format('Y-m-d') : '—' }}
                    </div>
                </div>

                <div class="col-12">
                    <a href="{{ route('halls.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i> العودة إلى القائمة
                    </a>
                    <a href="{{ route('halls.edit', $hall) }}" class="btn btn-warning text-white px-4">
                        <i class="bi bi-pencil-square me-1"></i> تعديل بيانات القاعة 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
