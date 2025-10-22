@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 100%;">

    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="fw-bold text-primary">
                <i class="bi bi-journal-text me-2"></i> {{ $page_title ?? 'البرامج التدريبية' }}
            </h4>
        </div>
        <div class="col-md-6 text-md-end mt-2 mt-md-0">
            <a href="{{ route('programs.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> إضافة برنامج جديد
            </a>
        </div>
    </div>

            {{-- ✅ منطقة الفلترة والبحث --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('programs.index') }}" method="GET" class="row g-3 align-items-end">

                {{-- 🔍 البحث العام --}}
                <div class="col-md-3">
                    <label class="form-label">البحث</label>
                    <input type="text" name="search" class="form-control" value="{{ request()->search }}" placeholder="ابحث عن برنامج...">
                </div>

                {{-- 📅 من تاريخ --}}
                <div class="col-md-3">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request()->from_date }}">
                </div>
                {{-- 📅 إلى تاريخ --}}
                <div class="col-md-3">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request()->to_date }}">
                </div>
                {{-- 🔘 الحالة --}}
                <div class="col-md-3">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">اختر الحالة</option>
                        <option value="draft" {{ request()->status == 'draft' ? 'selected' : '' }}>تم التنفيذ</option>
                        <option value="published" {{ request()->status == 'published' ? 'selected' : '' }}>تحت التنفيذ</option>
                        <option value="cancelled" {{ request()->status == 'cancelled' ? 'selected' : '' }}>ملغى</option>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search me-1"></i> بحث
                    </button>
                    <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-repeat me-1"></i> إعادة تعيين
                    </a>
                </div>
            </form>
        </div>
    </div>


    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            قائمة البرامج التدريبية
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif


            @if ($programs->count())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>اسم البرنامج</th>
                                <th>الجهة المنفذة</th>
                                <th>تاريخ البداية</th>
                                <th>تاريخ النهاية</th>
                                <th>المكان</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                                <tr class="text-center">
                                    <td>{{ $program->title }}</td>
                                    <td>{{ $program->organizer }}</td>
                                    <td>{{ $program->start_date?->format('Y-m-d') }}</td>
                                    <td>{{ $program->end_date?->format('Y-m-d') }}</td>
                                    <td>{{ $program->location }}</td>                    
                                    <td>
                                        <a href="{{ route('programs.show', $program->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>  
                                        </a>
                                        <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا البرنامج؟');">
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

                <div class="mt-3">
                    {{ $programs->links() }}
                </div>
            @else
                <p class="text-center">لا توجد برامج تدريبية حالياً.</p>
            @endif
        </div>
    </div>
</div>

@endsection
