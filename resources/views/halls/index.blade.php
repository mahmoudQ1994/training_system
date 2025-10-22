@extends('layouts.app')

@section('content')
<div class="p-4 bg-light min-vh-100">

    {{-- ✅ رأس الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h4 class="fw-bold text-primary mb-0">
            <i class="bi bi-building-check me-2"></i> قائمة قاعات التدريب
        </h4>
        <a href="{{ route('halls.create') }}" class="btn btn-success px-4">
            <i class="bi bi-plus-circle me-1"></i> إضافة قاعة جديدة
        </a>
    </div>

    {{-- ✅ منطقة الفلترة والبحث --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('halls.index') }}" method="GET" class="row g-3 align-items-end">

                {{-- 🔍 البحث العام --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">بحث عام</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="اسم القاعة أو الكود أو الملاحظات">
                </div>

                {{-- ⚙️ الحالة --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">الكل</option>
                        <option value="متاحة" {{ request('status') == 'متاحة' ? 'selected' : '' }}>متاحة</option>
                        <option value="محجوزة" {{ request('status') == 'محجوزة' ? 'selected' : '' }}>محجوزة</option>
                        <option value="صيانة" {{ request('status') == 'صيانة' ? 'selected' : '' }}>صيانة</option>
                    </select>
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

                {{-- 🔘 الأزرار --}}
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search me-1"></i> بحث
                    </button>
                    <a href="{{ route('halls.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-repeat me-1"></i> إعادة تعيين
                    </a>
                </div>
            </form>
        </div>
    </div>


    {{-- ✅ تنبيه النجاح --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm mx-2">{{ session('success') }}</div>
    @endif

    {{-- ✅ الجدول --}}
    <div class="bg-white shadow-sm rounded-3 overflow-hidden mx-2">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center mb-0">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>اسم القاعة</th>
                        <th>المبنى</th>
                        <th>السعة</th>
                        <th>الحالة</th>
                        <th>أنشأها</th>
                        <th>تاريخ الاضافة </th>
                        <th>آخر تعديل</th>
                        <th style="width: 140px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($halls as $hall)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-primary">{{ $hall->hall_name }}</td>
                            <td>{{ $hall->building_name ?? '-' }}</td>
                            <td>{{ $hall->capacity ?? '-' }}</td>
                            <td>
                                @if($hall->status == 'متاحة')
                                    <span class="badge bg-success">متاحة</span>
                                @elseif($hall->status == 'محجوزة')
                                    <span class="badge bg-warning text-dark">محجوزة</span>
                                @else
                                    <span class="badge bg-danger">صيانة</span>
                                @endif
                            </td>
                            <td>{{ $hall->creator?->name ?? '—' }}</td>
                            <td>{{ $hall->created_at->format('Y-m-d') }}</td>
                            <td>{{ $hall->updater?->name ?? '—' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('halls.show', $hall) }}" 
                                    class="btn btn-sm btn-info text-white" title="عرض التفاصيل">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('halls.edit', $hall) }}" class="btn btn-sm btn-warning text-white" title="تعديل">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <a href="{{ route('halls.images.index', $hall->id) }}" class="btn btn-sm btn-secondary" title="إدارة الصور">
                                        <i class="bi bi-images"></i>
                                    </a>
                                    <a href="{{ route('halls.bookings.create', $hall->id) }}" class="btn btn-sm btn-primary" title="حجز القاعة">
                                        <i class="bi bi-calendar-check"></i>
                                    </a>
                                    <form action="{{ route('halls.destroy', $hall) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه القاعة؟')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="حذف">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted py-4">لا توجد قاعات مسجلة بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ✅ ترقيم الصفحات --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $halls->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
