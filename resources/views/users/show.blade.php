@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ رسالة النجاح --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🧾 بطاقة عرض بيانات المستخدم --}}
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 95%;">
        <div class="card-header bg-primary text-white text-center fw-bold fs-5">
            👤 تفاصيل المستخدم
        </div>

        <div class="card-body p-4">
            <div class="row align-items-center flex-md-row-reverse">
                {{-- 🖼 الصورة الشخصية في الجانب الأيمن --}}
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                             class="rounded-3 border shadow-sm"
                             style="width: 100%; max-width: 220px; height: auto;"
                             alt="صورة المستخدم">
                    @else
                        <img src="{{ asset('images/default.png') }}"
                             class="rounded-3 border shadow-sm"
                             style="width: 100%; max-width: 220px; height: auto;"
                             alt="صورة افتراضية">
                    @endif
                </div>

                {{-- 📋 تفاصيل المستخدم في الجانب الأيسر --}}
                <div class="col-md-8">
                    <h4 class="fw-bold text-primary mb-4">{{ $user->name }}</h4>

                    <table class="table table-borderless align-middle">
                        <tbody>
                            <tr>
                                <th class="w-25 text-pr">الوظيفة:</th>
                                <td>{{ $user->job_title ?? '-' }}</td>
                                <th class="w-25 text-pr">الرقم القومي:</th>
                                <td>{{ $user->national_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-pr">رقم الهاتف:</th>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <th class="text-pr">البريد الإلكتروني:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-pr ">العنوان:</th>
                                <td>{{ $user->address ?? '-' }}</td>
                                <th class="text-pr">تاريخ الاضافة : </th>
                                <td>{{$user->created_at ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th class="text-pr">الدور / الصلاحية:</th>
                                <td>
                                    @if($user->role == 'super_admin')
                                        <span class="badge bg-danger fs-6">سوبر أدمن</span>
                                    @elseif($user->role == 'admin')
                                        <span class="badge bg-warning text-dark fs-6">مدير</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">مستخدم</span>
                                    @endif
                                </td>
                                <th class="text-pr">الحالة:</th>
                                <td>
                                    @if($user->status == 'active')
                                        <span class="badge bg-success fs-6">نشط</span>
                                    @else
                                        <span class="badge bg-danger fs-6">غير نشط</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 🔘 الأزرار --}}
            <div class="mt-4 text-center">
                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4 me-2">
                    ← رجوع للقائمة
                </a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary px-4">
                    ✏️ تعديل البيانات
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
