@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 1200px;">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center fs-4 fw-bold py-3">
            تحديث كلمة المرور
        </div>

        <div class="card-body p-4">

            {{-- رسائل النجاح أو الخطأ --}}
            @if (session('success'))
                <div class="alert alert-success text-center fs-5">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger text-center fs-5">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="fs-6">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" class="form-control form-control-lg" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" class="form-control form-control-lg" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="new_password_confirmation" class="form-control form-control-lg" required>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success btn-lg w-50 me-2">
                        <i class="bi bi-key"></i> تحديث كلمة المرور
                    </button>

                    {{-- زر الإغلاق --}}
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg w-50">
                        <i class="bi bi-x-circle"></i> إغلاق
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
