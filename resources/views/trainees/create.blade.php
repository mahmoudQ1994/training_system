@extends('layouts.app')

@section('content')
<div class="container-fluid px-5 py-4" style="max-width: 98%; margin:auto;">
    <h3 class="mb-4 text-center fw-bold">📋 تسجيل متدرب جديد</h3>

    {{-- 🔔 تنبيه --}}
    <div class="alert alert-info text-center">
        الرجاء اختيار <strong>تاريخ بداية البرنامج</strong> أولاً لعرض البرامج التدريبية المتاحة في ذلك اليوم.
    </div>

    <form action="{{ route('trainees.store') }}" method="POST" class="bg-white p-4 rounded-3 shadow-sm">
        @csrf

        {{-- 🗓️ بيانات البرنامج --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label fw-bold">📅 تاريخ بداية البرنامج</label>
                <input type="date" id="program_date" name="program_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">🏫 البرنامج التدريبي</label>
                <select id="program_id" name="program_id" class="form-select" required>
                    <option value="">-- اختر تاريخ البرنامج أولاً --</option>
                </select>
                @error('program_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">الرقم القومي</label>
                <input type="text" name="national_id" maxlength="14" class="form-control" required>
                @error('national_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

        </div>

        {{-- 👤 بيانات المتدرب --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">الاسم بالعربية</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">الاسم بالإنجليزية</label>
                <input type="text" name="name_en" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">التخصص</label>
                <input type="text" name="specialization" class="form-control">
            </div>
        </div>

        {{-- بيانات العمل --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-5">
                <label class="form-label fw-bold">المسمى الوظيفي</label>
                <input type="text" name="job_title" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">جهة العمل</label>
                <input type="text" name="organization" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">رقم الموبايل</label>
                <input type="text" name="mobile" class="form-control">
                @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- زر الحفظ --}}
        <div class="text-end mt-4">
            <a href="{{ route('trainees.index') }}" class="btn btn-secondary px-4">إلغاء</a>
            <button class="btn btn-success px-4 fw-bold">💾 حفظ المتدرب</button>
        </div>
    </form>
</div>

{{-- ✅ سكريبت تحميل البرامج وعرض تفاصيلها --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('program_date');
    const programSelect = document.getElementById('program_id');
    const detailsBox = document.getElementById('program_details');
    const startText = document.getElementById('start_date_text');
    const endText = document.getElementById('end_date_text');
    const daysText = document.getElementById('days_text');
    const hallText = document.getElementById('hall_text');

    // عند اختيار التاريخ
    dateInput.addEventListener('change', function() {
        const date = this.value;
        if (!date) return;

        programSelect.innerHTML = '<option>⏳ جاري تحميل البرامج...</option>';
        programSelect.disabled = true;

        fetch(`/trainees/by-date?date=${encodeURIComponent(date)}`)
            .then(response => {
                if (!response.ok) throw new Error('Response not OK');
                return response.json();
            })
            .then(programs => {
                programSelect.innerHTML = '';

                if (!Array.isArray(programs) || programs.length === 0) {
                    programSelect.innerHTML = '<option>❌ لا توجد برامج في هذا التاريخ</option>';
                    programSelect.disabled = true;
                    detailsBox.style.display = 'none';
                    return;
                }

                programSelect.innerHTML = '<option value="">-- اختر البرنامج --</option>';
                programs.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = `${p.title} (${p.start_time})`;
                    opt.dataset.start = p.start_date;
                    opt.dataset.end = p.end_date;
                    opt.dataset.days = p.days_count;
                    opt.dataset.hall = p.hall_name;
                    programSelect.appendChild(opt);
                });

                programSelect.disabled = false;
            })
            .catch(error => {
                programSelect.innerHTML = '<option>⚠️ حدث خطأ أثناء تحميل البرامج.</option>';
                programSelect.disabled = true;
                detailsBox.style.display = 'none';
            });
    });

});
</script>
@endsection
