@extends('layouts.app')

@section('content')
<div class="container" style="max-width:98%;">
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            إضافة برنامج جديد
        </div>
        <div class="card-body">
            {{-- عرض رسائل النجاح أو الخطأ --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">نوع البرنامج</label>
                        <select name="program_type" class="form-select" required>
                            <option value="">اختر النوع</option>
                            <option value="course">دورة تدريبية</option>
                            <option value="conference">مؤتمر</option>
                            <option value="day">يوم علمي</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">اسم البرنامج</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">الجهة المنفذة</label>
                        <input type="text" name="organizer" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">الفئة المستهدفة</label>
                        <select name="target_group" class="form-select">
                            <option value="">اختر الفئة</option>
                            <option value="طبيب بشري">طبيب بشري</option>
                            <option value="طبيب أسنان">طبيب أسنان</option>
                            <option value="صيدلي">صيدلي</option>
                            <option value="علاج طبيعي">علاج طبيعي</option>
                            <option value="تمريض">تمريض</option>
                            <option value="أخصائي علوم صحية">أخصائي علوم صحية</option>
                            <option value="فني صحي">فني صحي</option>
                            <option value="إداري">إداري</option>
                            <option value="أخرى">أخرى</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">عدد المتدربين</label>
                        <input type="number" name="trainees_count" class="form-control" min="0">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">تاريخ النهاية</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">وقت البداية</label>
                        <input type="time" name="start_time" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">وقت النهاية</label>
                        <input type="time" name="end_time" class="form-control">
                    </div>

                    <div class="col-4">
                        <label class="form-label">المكان</label>
                        <input type="text" name="location" class="form-control">
                    </div>

                    <div class="col-4">
                        <label class="form-label">المنفذ / المحاضر</label>
                        <input type="text" name="instructor" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">موقف البرنامج </label>
                        <select name="status" class="form-select">
                            <option value="draft">تم التنفيذ</option>
                            <option value="published">تحت التنفيذ</option>
                            <option value="cancelled">ملغى</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">صورة تعريفية (اختياري)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="col-8">
                        <label class="form-label">الوصف / الهدف</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button class="btn btn-success">حفظ البرنامج</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
