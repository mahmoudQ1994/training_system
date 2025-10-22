@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ✅ عرض رسالة النجاح --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- ⚠️ عرض أخطاء التحقق --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>حدثت أخطاء أثناء التسجيل:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🧾 نموذج إضافة مستخدم جديد --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center fw-bold">
            إضافة مستخدم جديد
        </div>

        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الوظيفة</label>
                        <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الرقم القومي</label>
                        <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الصورة الشخصية</label>
                        <input type="file" name="profile_image" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الدور / الصلاحية</label>
                        <select name="role" class="form-select">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>سوبر أدمن</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-5">💾 حفظ المستخدم</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
