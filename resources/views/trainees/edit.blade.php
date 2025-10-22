@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 99%;">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-lines-fill me-2"></i> تعديل بيانات المتدرب
            </h5>
            <a href="{{ route('trainees.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> رجوع
            </a>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>تنبيه!</strong> يرجى تصحيح الأخطاء التالية:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('trainees.update', $trainee->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- 🧍 بيانات المتدرب --}}
                <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                    👤 بيانات المتدرب
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الاسم بالعربية</label>
                        <input type="text" name="name_ar" class="form-control"
                               value="{{ old('name_ar', $trainee->name_ar) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الاسم بالإنجليزية</label>
                        <input type="text" name="name_en" class="form-control"
                               value="{{ old('name_en', $trainee->name_en) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الرقم القومي</label>
                        <input type="text" name="national_id" class="form-control"
                               value="{{ old('national_id', $trainee->national_id) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">التخصص</label>
                        <input type="text" name="specialization" class="form-control"
                               value="{{ old('specialization', $trainee->specialization) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">المسمى الوظيفي</label>
                        <input type="text" name="job_title" class="form-control"
                               value="{{ old('job_title', $trainee->job_title) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">جهة العمل</label>
                        <input type="text" name="organization" class="form-control"
                               value="{{ old('organization', $trainee->organization) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control"
                        value="{{ old('email', $trainee->email) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">رقم الموبايل</label>
                        <input type="text" name="mobile" class="form-control"
                        value="{{ old('mobile', $trainee->mobile) }}">
                    </div>
                </div>

                <hr class="my-4" style="border-top: 2px dashed #007bff; opacity: 0.5;">

                {{-- 🎓 بيانات البرنامج التدريبي (عرض فقط) --}}
                <h5 class="fw-bold text-primary mb-3">
                    📘 بيانات البرنامج التدريبي
                </h5>

                @if($trainee->program)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">اسم البرنامج</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $trainee->program->title }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الجهة المنظمة</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $trainee->program->organizer ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">اسم المدرب</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $trainee->program->instructor ?? '-' }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">تاريخ البداية</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $trainee->program->start_date?->format('Y-m-d') ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">تاريخ النهاية</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $trainee->program->end_date?->format('Y-m-d') ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">مكان التدريب</label>
                        <input type="text" class="form-control bg-light" 
                               value="{{ $trainee->program->location ?? '-' }}" readonly>
                    </div>
                </div>
                @else
                    <p class="text-muted mt-2">❌ لا توجد بيانات برنامج مرتبطة بهذا المتدرب.</p>
                @endif

                {{-- 🔘 أزرار التحكم --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        💾 حفظ التعديلات
                    </button>
                    <a href="{{ route('trainees.show', $trainee->id) }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle"></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
