@extends('layouts.app')

@section('title', 'تقارير المرور على القاعات')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-clipboard2-check me-2"></i> تقارير المرور على القاعات
        </h4>

        <a href="{{ route('hall_reports.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> إضافة تقرير جديد
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

        {{-- ✅ منطقة الفلترة والبحث --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('hall_reports.index') }}" method="GET" class="row g-3 align-items-end">

                {{-- 🔍 البحث العام --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">بحث عام</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="اسم القاعة أو اسم القائم بالمرور">
                </div>
                {{-- 👤 اسم القائم بالمرور --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">اسم القائم بالمرور</label>
                    <input type="text" name="inspected_by" value="{{ request('inspected_by') }}" class="form-control"
                        placeholder="اسم الموظف أو المشرف">
                </div>
                {{-- 📅 من تاريخ --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">من تاريخ</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                </div>
                {{-- 📅 إلى تاريخ --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">إلى تاريخ</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                </div>
                {{-- 🔘 الاضافة بواسطة  --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">تم الإضافة بواسطة</label>
                    <input type="text" name="created_by" value="{{ request('created_by') }}" class="form-control"
                        placeholder="اسم المستخدم"> 
                </div>
                {{-- 🔘 التعديل بواسطة  --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">تم التعديل بواسطة</label>
                    <input type="text" name="updated_by" value="{{ request('updated_by') }}" class="form-control"
                        placeholder="اسم المستخدم">
                </div>

                {{-- 🔘 الأزرار --}}
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search me-1"></i> بحث
                    </button>
                    <a href="{{ route('hall_reports.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-repeat me-1"></i> إعادة تعيين
                    </a>
                </div>
            </form>
        </div>
    </div>
    {{-- ✅ عدد النتائج: 5 تقارير   --}}
    <div class="mb-3">
        <span class="text-secondary">عدد النتائج: {{ $reports->total() }} تقرير</span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>م</th>
                    <th>اسم القاعة</th>
                    <th>السعة</th>
                    <th>تاريخ المرور</th>
                    <th>تم بواسطة</th>
                    <th>نسبة الجاهزية (%)</th>
                    <th>تم الاضافة بواسطة</th>
                    <th>تم التعديل بواسطة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->hall->hall_name ?? '-' }}</td>
                        <td>{{ $report->hall->capacity ?? '-' }}</td>
                        <td>{{ $report->inspection_date }}</td>
                        <td>{{ $report->inspected_by ?? '-' }}</td>
                        <td>{{ $report->readiness_percent ?? '-' }}</td>
                        <td>{{ $report->creator->name ?? '-' }}</td>
                        <td>{{ $report->updater->name ?? '-' }}</td>

                        <td>
                            <a href="{{ route('hall_reports.show', $report->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> 
                            </a>
                            <a href="{{ route('hall_reports.edit', $report->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> 
                            </a>
                            <form action="{{ route('hall_reports.destroy', $report->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">لا توجد تقارير مرور حالياً</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
