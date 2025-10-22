@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 95%;">

    {{-- ✅ العنوان --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-graph-up-arrow me-2"></i> تقارير المتدربين
        </h4>
        <a href="{{ route('trainees.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right"></i> عودة
        </a>
    </div>

    {{-- ✅ فلترة البيانات أولاً --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('trainees.reports') }}" method="GET" class="row g-3 align-items-end">

                {{-- 📋 البرنامج --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">البرنامج التدريبي</label>
                    <select name="program_id" class="form-select">
                        <option value="">الكل</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 📅 من تاريخ --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">من تاريخ</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                {{-- 📅 إلى تاريخ --}}
                <div class="col-md-4">
                    <label class="form-label fw-bold">إلى تاريخ</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                {{-- 🔘 الأزرار --}}
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search"></i> بحث
                    </button>
                    <a href="{{ route('trainees.reports') }}" class="btn btn-outline-secondary px-3">
                        <i class="bi bi-arrow-repeat"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ كروت الإحصائيات بعد الفلتر --}}
    <div class="row g-3 mb-4 text-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-people-fill text-primary fs-3 mb-2"></i>
                    <h6 class="text-muted">عدد المتدربين</h6>
                    <h4 class="fw-bold text-dark">{{ $totalTrainees }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-journal-text text-success fs-3 mb-2"></i>
                    <h6 class="text-muted">عدد البرامج التدريبية</h6>
                    <h4 class="fw-bold text-dark">{{ $totalPrograms }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-person-badge text-warning fs-3 mb-2"></i>
                    <h6 class="text-muted">عدد المدربين</h6>
                    <h4 class="fw-bold text-dark">{{ $totalInstructors }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ جدول عرض المتدربين --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            قائمة المتدربين
        </div>
        <div class="card-body">
            @if ($trainees->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>الرقم القومي</th>
                                <th>التخصص</th>
                                <th>الوظيفة</th>
                                <th>الجهة</th>
                                <th>الموبايل</th>
                                <th>البرنامج</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainees as $trainee)
                                <tr>
                                    <td>{{ $trainee->name_ar }}</td>
                                    <td>{{ $trainee->national_id }}</td>
                                    <td>{{ $trainee->specialization ?? '-' }}</td>
                                    <td>{{ $trainee->job_title ?? '-' }}</td>
                                    <td>{{ $trainee->organization ?? '-' }}</td>
                                    <td>{{ $trainee->mobile ?? '-' }}</td>
                                    <td>{{ $trainee->program->title ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted mb-0">❌ لا توجد نتائج مطابقة لعملية الفلترة.</p>
            @endif
        </div>
    </div>
</div>
@endsection
