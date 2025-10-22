@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">إضافة قاعة تدريب جديدة</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('halls.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">اسم القاعة <span class="text-danger">*</span></label>
                <input name="hall_name" value="{{ old('hall_name') }}" class="form-control" required>
                @error('hall_name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">رمز القاعة</label>
                <input name="hall_code" value="{{ old('hall_code') }}" class="form-control">
                @error('hall_code') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">المبنى</label>
                <input name="building_name" value="{{ old('building_name') }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">الدور / الطابق</label>
                <input name="floor_number" value="{{ old('floor_number') }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input name="capacity" value="{{ old('capacity') }}" type="number" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label d-block">التجهيزات</label>
                @php
                    $allFacilities = ['data_show','screen','whiteboard','microphone','speakers','ac','wifi','computers'];
                @endphp
                <div class="d-flex flex-wrap gap-2">
                    @foreach($allFacilities as $f)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $f }}" id="fac_{{ $f }}"
                                {{ (is_array(old('facilities')) && in_array($f, old('facilities'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="fac_{{ $f }}">
                                {{ $f }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">حالة القاعة</label>
                <select name="status" class="form-select">
                    <option value="متاحة" {{ old('status')=='متاحة' ? 'selected' : '' }}>متاحة</option>
                    <option value="محجوزة" {{ old('status')=='محجوزة' ? 'selected' : '' }}>محجوزة</option>
                    <option value="صيانة" {{ old('status')=='صيانة' ? 'selected' : '' }}>صيانة</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">صورة القاعة (اختياري)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="col-12 text-end">
                <a href="{{ route('halls.index') }}" class="btn btn-secondary">إلغاء</a>
                <button class="btn btn-success">إضافة القاعة</button>
            </div>
        </div>
    </form>
</div>
@endsection
