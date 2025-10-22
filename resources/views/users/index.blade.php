@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">إدارة المستخدمين</h4>
        <a href="{{ route('users.create') }}" class="btn btn-success">
            <i class="bi bi-person-plus"></i> إضافة مستخدم جديد
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <table class="table table-hover align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>الوظيفة</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الموبايل</th>
                        <th>الدور</th>
                        <th>الحالة</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                    alt="الصورة" width="60" height="60" class="rounded-circle">
                                @else
                                    <img src="{{ asset('images/default.png') }}"
                                    alt="افتراضية" width="60" height="60" class="rounded-circle">
                                @endif


                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->job_title ?? '-' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if($user->role == 'super_admin')
                                    <span class="badge bg-danger">سوبر أدمن</span>
                                @elseif($user->role == 'admin')
                                    <span class="badge bg-primary">أدمن</span>
                                @else
                                    <span class="badge bg-secondary">مستخدم</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                    {{-- ✏️ تعديل يظهر فقط للمدير والسوبر أدمن --}}
                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'super_admin')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                @endif
                                {{-- 🗑️ حذف يظهر فقط للسوبر أدمن --}}
                                @if(auth()->user()->role == 'super_admin')
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-muted">لا يوجد مستخدمين مسجلين</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
