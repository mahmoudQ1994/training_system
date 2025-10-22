@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 100%;">

    {{-- 🔹 العنوان وزر الإضافة --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-people-fill me-2"></i> {{ $page_title ?? 'قائمة المتدربين' }}
            </h4>
        </div>
        <div class="col-md-6 text-md-end mt-2 mt-md-0">
            <a href="{{ route('trainees.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> إضافة متدرب جديد
            </a>
        </div>
    </div>

    {{-- ✅ منطقة الفلترة والبحث --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('trainees.index') }}" method="GET" class="row g-3 align-items-end">

                {{-- 🔍 البحث بالاسم --}}
                <div class="col-md-3">
                    <label class="form-label">اسم المتدرب</label>
                    <input type="text" name="name" class="form-control" value="{{ request()->name }}" placeholder="ابحث بالاسم...">
                </div>

                {{-- 🪪 الرقم القومي --}}
                <div class="col-md-3">
                    <label class="form-label">الرقم القومي</label>
                    <input type="text" name="national_id" class="form-control" value="{{ request()->national_id }}" placeholder="ابحث بالرقم القومي...">
                </div>

                {{-- 📱 رقم الموبايل --}}
                <div class="col-md-3">
                    <label class="form-label">رقم الموبايل</label>
                    <input type="text" name="mobile" class="form-control" value="{{ request()->mobile }}" placeholder="ابحث بالموبايل...">
                </div>

                {{-- 🔘 زر البحث وإعادة التعيين --}}
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search me-1"></i> بحث
                    </button>
                    <a href="{{ route('trainees.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-repeat me-1"></i> إعادة تعيين
                    </a>
                </div>
            </form>
        </div>
    </div>
        {{-- 🔹 عدد المتدربين   --}}
    <div class="mb-3">
        <h6 class="text-secondary">
            إجمالي المتدربين: <span class="badge bg-info text-dark">{{ $trainees->total() }}</span>
        </h6>
    </div>


    {{-- ✅ جدول عرض المتدربين --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            قائمة المتدربين
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($trainees->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>الاسم</th>
                                <th>الرقم القومي</th>
                                <th>البريد الإلكتروني</th>
                                <th>رقم الموبايل</th>
                                <th>البرنامج التدريبي</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainees as $trainee)
                                <tr class="text-center">
                                    <td>{{ $trainee->name_ar }}</td>
                                    <td>{{ $trainee->national_id }}</td>
                                    <td>{{ $trainee->email ?? '-' }}</td>
                                    <td>{{ $trainee->mobile ?? '-' }}</td>
                                    <td>{{ $trainee->program?->title ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('trainees.show', $trainee->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('trainees.edit', $trainee->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('trainees.destroy', $trainee->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المتدرب؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ✅ روابط التصفح --}}
                <div class="mt-3">
                    {{ $trainees->links() }}
                </div>
            @else
                <p class="text-center text-muted">لا توجد بيانات متدربين حالياً.</p>
            @endif
        </div>
    </div>
</div>
@endsection
