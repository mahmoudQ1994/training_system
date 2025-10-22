@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i> الملف الشخصي</h4>
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-house"></i> الرجوع للرئيسية
                    </a>
                </div>

                <div class="card-body bg-light text-center">

                    {{-- صورة المستخدم --}}
                    <div class="position-relative d-inline-block mb-4">
                        <img src="{{ $user->profile_photo 
                            ? asset('storage/profile_image/' . $user->profile_photo) 
                            : asset('images/default-avatar.png') }}" 
                            alt="Avatar" class="rounded-circle border border-3 border-primary shadow" 
                            width="150" height="150">

                        {{-- زر تغيير الصورة --}}
                        <form action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <input type="file" name="photo" accept="image/*" class="form-control w-50">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-upload"></i> تحديث الصورة
                                </button>
                            </div>
                            @error('photo')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </form>
                    </div>

                    <hr>

                    <div class="row text-start">
                        <div class="col-md-6 mb-3">
                            <strong>الاسم الكامل:</strong>
                            <div class="text-secondary">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>البريد الإلكتروني:</strong>
                            <div class="text-secondary">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>رقم الهاتف:</strong>
                            <div class="text-secondary">{{ $user->phone ?? 'غير متوفر' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>الدور:</strong>
                            <div class="text-secondary">{{ $user->role ?? 'مستخدم' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>تاريخ الإنشاء:</strong>
                            <div class="text-secondary">{{ $user->created_at->format('Y-m-d') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>آخر تحديث:</strong>
                            <div class="text-secondary">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg me-2">
                            <i class="bi bi-pencil-square"></i> تعديل الملف الشخصي
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
