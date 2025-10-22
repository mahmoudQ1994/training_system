@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 text-center">⚙️ إعدادات النظام</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- 🖼️ الشعار في أقصى اليسار --}}
            <div class="col-md-3 text-center">
                <label class="form-label d-block">شعار النظام</label>
                <div class="border rounded p-2 bg-light">
                    @if($settings && $settings->logo_path)
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="img-fluid rounded mb-2" style="max-height: 120px;">
                    @else
                        <img src="{{ asset('images/default-logo.png') }}" alt="Logo" class="img-fluid rounded mb-2" style="max-height: 120px;">
                    @endif
                </div>
                <input type="file" name="logo" class="form-control mt-2">
            </div>

            {{-- باقي الحقول على يمين الشعار --}}
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم النظام</label>
                        <input type="text" name="system_name" class="form-control" value="{{ $settings->system_name ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اسم المديرية</label>
                        <input type="text" name="directorate_name" class="form-control" value="{{ $settings->directorate_name ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اسم الإدارة</label>
                        <input type="text" name="department_name" class="form-control" value="{{ $settings->department_name ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني الافتراضي</label>
                        <input type="email" name="default_email" class="form-control" value="{{ $settings->default_email ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اللغة الافتراضية</label>
                        <select name="default_language" class="form-select">
                            <option value="ar" {{ ($settings->default_language ?? '') == 'ar' ? 'selected' : '' }}>العربية</option>
                            <option value="en" {{ ($settings->default_language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تفعيل الإشعارات</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="notifications_enabled" id="notifications_enabled"
                                {{ !empty($settings->notifications_enabled) ? 'checked' : '' }}>
                            <label class="form-check-label" for="notifications_enabled">تفعيل</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary px-5">💾 حفظ الإعدادات</button>
        </div>
    </form>
</div>
@endsection
