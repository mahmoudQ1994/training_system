@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 90%;" id="program-card">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-journal-text me-2"></i>
                تفاصيل البرنامج التدريبي
            </h5>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> رجوع
            </a>
        </div>

        <div class="card-body p-4" style="line-height: 1.4;">
            <div class="row g-3">

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-bookmark-check me-1"></i> اسم البرنامج</h6>
                    <p class="fw-semibold mb-2">{{ $program->title }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-building me-1"></i> الجهة المنفذة</h6>
                    <p class="mb-2">{{ $program->organizer ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-person-badge me-1"></i> المدرب / المحاضر</h6>
                    <p class="mb-2">{{ $program->instructor ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-people me-1"></i> الفئة المستهدفة</h6>
                    <p class="mb-2">{{ $program->target_group ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-calendar-event me-1"></i> تاريخ البداية</h6>
                    <p class="mb-2">{{ $program->start_date?->format('Y-m-d') ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-calendar-check me-1"></i> تاريخ النهاية</h6>
                    <p class="mb-2">{{ $program->end_date?->format('Y-m-d') ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-geo-alt me-1"></i> المكان</h6>
                    <p class="mb-2">{{ $program->location ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-clock me-1"></i> وقت البداية</h6>
                    <p class="mb-2">{{ $program->start_time?->format('H:i') ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-clock-history me-1"></i> وقت النهاية</h6>
                    <p class="mb-2">{{ $program->end_time?->format('H:i') ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-people-fill me-1"></i> عدد المتدربين</h6>
                    <p class="mb-2">{{ $program->trainees_count ?? '-' }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-flag me-1"></i> الحالة</h6>
                    <span class="badge 
                        @if($program->status == 'draft') bg-success 
                        @elseif($program->status == 'published') bg-warning text-dark
                        @else bg-danger 
                        @endif
                        px-3 py-2">
                        @if($program->status == 'draft') تم التنفيذ
                        @elseif($program->status == 'published') تحت التنفيذ
                        @else ملغى
                        @endif
                    </span>
                </div>

                <div class="col-md-4">
                    <h6 class="text-primary mb-1"><i class="bi bi-tag me-1"></i> نوع البرنامج</h6>
                    <p class="mb-2">
                        @if($program->program_type == 'course') دورة تدريبية
                        @elseif($program->program_type == 'conference') مؤتمر
                        @else يوم علمي
                        @endif
                    </p>
                </div>

                <div class="col-12">
                    <h6 class="text-primary mb-1"><i class="bi bi-info-circle me-1"></i> الوصف</h6>
                    <div class="border rounded p-2 bg-light small">
                        {!! nl2br(e($program->description ?? 'لا يوجد وصف.')) !!}
                    </div>
                </div>

                @if($program->image_path)
                <div class="col-12 text-center mt-3">
                    <img src="{{ asset('storage/' . $program->image_path) }}" 
                         alt="صورة البرنامج" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 300px;">
                </div>
                @endif
            </div>
        </div>

        

        <div class="card-footer bg-light text-end">
                <button id="downloadCard" class="btn btn-success">
                    📥 تنزيل كارت البرنامج كصورة
                </button>
            <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> تعديل
            </a>
            <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('هل أنت متأكد من حذف هذا البرنامج؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i> حذف
                </button>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('downloadCard').addEventListener('click', function () {
    const card = document.getElementById('program-card'); // الكارت الذي نريد تصويره
    html2canvas(card, { scale: 2 }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'بطاقة_البرنامج.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
});
</script>

@endsection
