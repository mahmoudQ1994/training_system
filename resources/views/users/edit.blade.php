@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- ✅ رسالة نجاح إن وجدت --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ رسالة أخطاء التحقق --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>حدثت أخطاء أثناء التحديث:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🧾 كارت تعديل البيانات --}}
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 900px;">
        <div class="card-header bg-warning text-dark fw-bold text-center fs-5">
            ✏️ تعديل بيانات المستخدم
        </div>

        <div class="card-body p-4">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row align-items-start flex-md-row-reverse">
                    {{-- 🖼 الصورة الشخصية في الجهة اليمنى --}}
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <label for="profile_image" class="fw-bold d-block mb-2">الصورة الشخصية</label>

                        <div class="position-relative d-inline-block">
                            <img id="preview-image"
                                 src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('images/default.png') }}"
                                 class="rounded-3 border shadow-sm"
                                 style="width: 200px; height: 200px; object-fit: cover;"
                                 alt="صورة المستخدم">

                            {{-- زر اختيار صورة --}}
                            <input type="file" name="profile_image" id="profile_image"
                                   class="form-control mt-3" accept="image/*"
                                   onchange="previewImage(event)">
                        </div>
                    </div>

                    {{-- 📋 حقول البيانات على الجهة اليسرى --}}
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم الكامل</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الوظيفة</label>
                                <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $user->job_title) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الرقم القومي</label>
                                <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $user->national_id) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الدور / الصلاحية</label>
                                <select name="role" class="form-select" required>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>مستخدم</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
                                    <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>سوبر أدمن</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select" required>
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔘 الأزرار --}}
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success px-4">
                        💾 حفظ التعديلات
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 ms-2">
                        ← إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ✅ سكريبت معاينة الصورة فوراً --}}
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview-image');
        preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
