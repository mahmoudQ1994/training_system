@extends('layouts.app')

@section('content')
<div class="p-4 bg-light min-vh-100">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary mb-4">
                <i class="bi bi-pencil-square me-2"></i> تعديل بيانات القاعة
            </h4>

            <form action="{{ route('halls.update', $hall->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">اسم القاعة:</label>
                        <input type="text" name="hall_name" class="form-control" value="{{ old('hall_name', $hall->hall_name) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">كود القاعة:</label>
                        <input type="text" name="hall_code" class="form-control" value="{{ old('hall_code', $hall->hall_code) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">اسم المبنى:</label>
                        <input type="text" name="building_name" class="form-control" value="{{ old('building_name', $hall->building_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">رقم الطابق:</label>
                        <input type="text" name="floor_number" class="form-control" value="{{ old('floor_number', $hall->floor_number) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">السعة:</label>
                        <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $hall->capacity) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الحالة:</label>
                        <select name="status" class="form-select">
                            <option value="متاحة" {{ $hall->status == 'متاحة' ? 'selected' : '' }}>متاحة</option>
                            <option value="مشغولة" {{ $hall->status == 'مشغولة' ? 'selected' : '' }}>مشغولة</option>
                            <option value="صيانة" {{ $hall->status == 'صيانة' ? 'selected' : '' }}>صيانة</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">المرافق:</label>
                        <input type="text" name="facilities[]" class="form-control" value="{{ implode(', ', $hall->facilities ?? []) }}">
                        <small class="text-muted">افصل بين المرافق بفاصلة (,)</small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">ملاحظات:</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $hall->notes) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">تغيير الصورة:</label>
                        <input type="file" name="image" class="form-control">
                        @if ($hall->image)
                            <img src="{{ asset($hall->image) }}" alt="صورة القاعة" class="img-fluid rounded mt-2" style="max-height: 150px;">
                        @endif
                    </div>

                    <div class="col-12 text-end mt-4">
                        <a href="{{ route('halls.show', $hall->id) }}" class="btn btn-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> حفظ التعديلات
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
