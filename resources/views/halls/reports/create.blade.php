@extends('layouts.app')

@section('title', 'إضافة تقرير مرور جديد')

@section('content')
<div class="container py-4">

    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-journal-text me-2"></i> إضافة تقرير مرور جديد
    </h4>

    <form action="{{ route('hall_reports.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">اسم القاعة</label>
                <select name="hall_id" class="form-select" required>
                    <option value="">-- اختر القاعة --</option>
                    @foreach($halls as $hall)
                        <option value="{{ $hall->id }}">{{ $hall->hall_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">تاريخ المرور</label>
                <input type="date" name="inspection_date" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">اسم القائم بالمرور</label>
                <input type="text" name="inspected_by" class="form-control" placeholder="اسم الموظف أو المشرف">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">عدد كراسي المتدربين</label>
                <input type="number" name="chairs_count" class="form-control" min="0" placeholder="مثلاً 20">
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

            @foreach($fields as $name => $label)
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="{{ $name }}" value="1" id="{{ $name }}">
                        <label class="form-check-label fw-bold" for="{{ $name }}">{{ $label }}</label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">عدد أجهزة التكييف</label>
                <input type="number" name="air_conditioning_count" class="form-control" min="0" placeholder="مثلاً 2">
            </div>
        </div>

        <div class="mt-4">
            <label class="form-label fw-bold">ملاحظات إضافية</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="أدخل أي ملاحظات حول القاعة"></textarea>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-check-circle me-1"></i> حفظ التقرير
            </button>
            <a href="{{ route('hall_reports.index') }}" class="btn btn-secondary">
                إلغاء
            </a>
        </div>
    </form>

</div>
@endsection
