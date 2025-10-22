@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 900px;">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white text-center fs-5">
            تعديل بيانات البرنامج التدريبي
        </div>
        <div class="card-body p-4">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>تنبيه!</strong> يرجى مراجعة الأخطاء التالية:
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('programs.update', $program->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- اسم البرنامج -->
                    <div class="col-md-6">
                        <label class="form-label">اسم البرنامج</label>
                        <input type="text" name="title" value="{{ old('title', $program->title) }}" class="form-control" required>
                    </div>

                    <!-- نوع البرنامج -->
                    <div class="col-md-6">
                        <label class="form-label">نوع البرنامج</label>
                        <select name="program_type" class="form-select" required>
                            <option value="">-- اختر النوع --</option>
                            <option value="course" {{ $program->program_type == 'course' ? 'selected' : '' }}>دورة تدريبية</option>
                            <option value="conference" {{ $program->program_type == 'conference' ? 'selected' : '' }}>مؤتمر</option>
                            <option value="day" {{ $program->program_type == 'day' ? 'selected' : '' }}>يوم علمي</option>
                        </select>
                    </div>

                    <!-- مكان التنفيذ -->
                    <div class="col-md-6">
                        <label class="form-label">مكان التنفيذ</label>
                        <input type="text" name="location" value="{{ old('location', $program->location) }}" class="form-control">
                    </div>

                    <!-- عدد المتدربين -->
                    <div class="col-md-6">
                        <label class="form-label">عدد المتدربين</label>
                        <input type="number" name="trainees_count" value="{{ old('trainees_count', $program->trainees_count) }}" class="form-control">
                    </div>

                    <!-- تاريخ البداية -->
                    <div class="col-md-6">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $program->start_date ? $program->start_date->format('Y-m-d') : '') }}" class="form-control">
                    </div>

                    <!-- تاريخ النهاية -->
                    <div class="col-md-6">
                        <label class="form-label">تاريخ النهاية</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $program->end_date ? $program->end_date->format('Y-m-d') : '') }}" class="form-control">
                    </div>

                    <!-- المدرب -->
                    <div class="col-md-6">
                        <label class="form-label">اسم المدرب</label>
                        <input type="text" name="trainer" value="{{ old('trainer', $program->trainer) }}" class="form-control">
                    </div>

                    <!-- الجهة المنظمة -->
                    <div class="col-md-6">
                        <label class="form-label">الجهة المنظمة</label>
                        <input type="text" name="organizer" value="{{ old('organizer', $program->organizer) }}" class="form-control">
                    </div>

                    <!-- الحالة -->
                    <div class="col-md-6">
                        <label class="form-label">حالة البرنامج</label>
                        <select name="status" class="form-select">
                            <option value="draft" {{ $program->status == 'draft' ? 'selected' : '' }}>تم التنفيذ</option>
                            <option value="published" {{ $program->status == 'published' ? 'selected' : '' }}>تحت التنفيذ</option>
                            <option value="cancelled" {{ $program->status == 'cancelled' ? 'selected' : '' }}>ملغى</option>
                        </select>
                    </div>

                    <!-- وصف البرنامج -->
                    <div class="col-12">
                        <label class="form-label">الوصف التفصيلي</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $program->description) }}</textarea>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">💾 حفظ التعديلات</button>
                    <a href="{{ route('programs.index') }}" class="btn btn-secondary px-4">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
