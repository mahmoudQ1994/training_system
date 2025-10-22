@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container my-5">

            {{-- رسائل النجاح أو الخطأ --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center shadow-sm" role="alert">
                <i class="bi bi-x-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- كارت الملف الشخصي --}}
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i> الملف الشخصي</h4>
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-house"></i> الرجوع للرئيسية
                </a>
            </div>

            <div class="card-body bg-light text-center">

                {{-- معلومات المستخدم --}}
                <div class="row text-start">
                    <div class="col-md-4 mb-3">
                        <strong>الاسم الكامل:</strong>
                        <div class="text-secondary">{{ $user->name }}</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <strong> الرقم القومى :</strong>
                        <div class="text-secondary">{{ $user->national_id }}</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>البريد الإلكتروني:</strong>
                        <div class="text-secondary">{{ $user->email }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>رقم الهاتف:</strong>
                        <div class="text-secondary">{{ $user->phone ?? 'غير متوفر' }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>الدور:</strong>
                        <div class="text-secondary">{{ $user->role ?? 'مستخدم' }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>تاريخ الإنشاء:</strong>
                        <div class="text-secondary">{{ $user->created_at->format('Y-m-d') }}</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>آخر تحديث:</strong>
                        <div class="text-secondary">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

</div>
@endsection
