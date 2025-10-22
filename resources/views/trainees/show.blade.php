@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 90%;" id="trainee-card">
    <div class="card shadow border-0">

        {{-- 🔹 رأس الصفحة --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-vcard me-2"></i>
                تفاصيل المتدرب والبرنامج التدريبي
            </h5>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> رجوع
            </a>
        </div>

        {{-- 📋 محتوى البطاقة --}}
        <div class="card-body p-4" style="line-height: 1.5;">
            <div class="row g-3">

                {{-- 👤 بيانات المتدرب --}}
                <div class="col-12">
                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        👤 بيانات المتدرب
                    </h5>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-person me-1"></i> الاسم بالعربية</h6>
                    <p class="fw-semibold mb-2">{{ $trainee->name_ar }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-translate me-1"></i> الاسم بالإنجليزية</h6>
                    <p class="mb-2">{{ $trainee->name_en ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-card-heading me-1"></i> الرقم القومي</h6>
                    <p class="mb-2">{{ $trainee->national_id }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-mortarboard me-1"></i> التخصص</h6>
                    <p class="mb-2">{{ $trainee->specialization ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-person-workspace me-1"></i> المسمى الوظيفي</h6>
                    <p class="mb-2">{{ $trainee->job_title ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-building me-1"></i> جهة العمل</h6>
                    <p class="mb-2">{{ $trainee->organization ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-envelope me-1"></i> البريد الإلكتروني</h6>
                    <p class="mb-2">{{ $trainee->email ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-phone me-1"></i> رقم الموبايل</h6>
                    <p class="mb-2">{{ $trainee->mobile ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-person-circle me-1"></i> تمت الإضافة بواسطة</h6>
                    <p class="mb-2">{{ $trainee->created_by ?? '-' }}</p>
                </div>

                {{-- 🎓 بيانات البرنامج التدريبي --}}
                <div class="col-12 mt-4">
                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        📘 بيانات البرنامج التدريبي
                    </h5>
                </div>

                @if($trainee->program)
                    <div class="col-md-4">
                        <h6 class="text-primary mb-1"><i class="bi bi-journal-text me-1"></i> اسم البرنامج</h6>
                        <p class="fw-semibold mb-2">{{ $trainee->program->title }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-primary mb-1"><i class="bi bi-building-check me-1"></i> الجهة المنظمة</h6>
                        <p class="mb-2">{{ $trainee->program->organizer ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-primary mb-1"><i class="bi bi-person-badge me-1"></i> المدرب / المحاضر</h6>
                        <p class="mb-2">{{ $trainee->program->instructor ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-primary mb-1"><i class="bi bi-calendar-event me-1"></i> تاريخ البداية</h6>
                        <p class="mb-2">{{ $trainee->program->start_date?->format('Y-m-d') ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-primary mb-1"><i class="bi bi-calendar-check me-1"></i> تاريخ النهاية</h6>
                        <p class="mb-2">{{ $trainee->program->end_date?->format('Y-m-d') ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-primary mb-1"><i class="bi bi-geo-alt me-1"></i> مكان التدريب</h6>
                        <p class="mb-2">{{ $trainee->program->location ?? '-' }}</p>
                    </div>
                @else
                    <div class="col-12">
                        <p class="text-muted">❌ لا توجد بيانات برنامج مرتبطة بهذا المتدرب.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ✅ الأزرار السفلية --}}
        <div class="card-footer bg-light text-end">
            <button id="downloadCard" class="btn btn-success">
                📥 تنزيل بطاقة المتدرب كصورة
            </button>

            <a href="{{ route('trainees.edit', $trainee->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> تعديل
            </a>
            <form action="{{ route('trainees.destroy', $trainee->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('هل أنت متأكد من حذف هذا المتدرب؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i> حذف
                </button>
            </form>
        </div>
    </div>
</div>

{{-- 📸 كود حفظ البطاقة كصورة --}}
<script>
document.getElementById('downloadCard').addEventListener('click', function () {
    const card = document.getElementById('trainee-card');
    html2canvas(card, { scale: 2 }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'بطاقة_المتدرب.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
});
</script>
@endsection
