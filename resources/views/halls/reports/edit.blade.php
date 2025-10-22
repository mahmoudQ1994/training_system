@extends('layouts.app')
@section('title', 'تعديل تقرير مرور')
@section('content')
<div class="container py-4">

    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-journal-text me-2"></i> تعديل تقرير مرور
    </h4>

    <form action="{{ route('hall_reports.update', $hallReport->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">اسم القاعة</label>
                <select name="hall_id" class="form-select" required>
                    <option value="">-- اختر القاعة --</option>
                    @foreach($halls as $hall)
                        <option value="{{ $hall->id }}" {{ $hallReport->hall_id == $hall->id ? 'selected' : '' }}>
                            {{ $hall->hall_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">تاريخ المرور</label>
                <input type="date" name="inspection_date" class="form-control" value="{{ $hallReport->inspection_date }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">اسم القائم بالمرور</label>
                <input type="text" name="inspected_by" class="form-control" value="{{ $hallReport->inspected_by }}" placeholder="اسم الموظف أو المشرف">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">عدد كراسي المتدربين</label>
                <input type="number" name="chairs_count" class="form-control" min="0" value="{{ $hallReport->chairs_count }}" placeholder="مثلاً 20">
            </div>
        </div>
        <hr>
        <h5 class="fw-bold text-secondary mb-3">📋 تجهيزات القاعة</h5>
        <div class="row g-3">
            @php
                $fields = [
                    'lecturer_desk' => 'مكتب المحاضر',
                    'display_screen' => 'شاشة العرض',
                    'computer_available' => 'جهاز كمبيوتر',
                    'cables_available' => 'وصلات وكابلات',
                    'paper_board' => 'سبورة ورقية',
                    'white_board' => 'سبورة بيضاء',
                    'air_conditioning' => 'أجهزة التكييف',
                    'internet_available' => 'الإنترنت',
                    'sound_system' => 'سماعات صوتية',
                    'lighting_good' => 'الإضاءة كافية',
                    'ventilation_good' => 'التهوية جيدة',
                    'waiting_area' => 'صالة الانتظار',
                    'buffet_available' => 'بوفيه للمتدربين',
                    'toilets_available' => 'حمامات',
                    'fire_extinguishers' => 'طفايات الحريق',
                    'emergency_exit' => 'مخرج الطوارئ'
                ];
            @endphp
            @foreach ($fields as $field => $label)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1" {{ $hallReport->$field ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $field }}">
                            {{ $label }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-4">
            
            <div class="col-md-6">
                <label class="form-label fw-bold">ملاحظات إضافية</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="أي ملاحظات أخرى">{{ $hallReport->notes }}</textarea>
            </div>
        </div>
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> حفظ التعديلات
            </button>
            <a href="{{ route('hall_reports.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> العودة للقائمة
            </a>
        </div>
    </form>
</div>
                <i class="bi bi-arrow-left me-1"></i> العودة للقائمة
            </a>
        </div>
    </form>
</div>
@endsection