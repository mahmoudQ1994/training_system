@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- عنوان الصفحة مع أيقونة --}}
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-bell-fill fs-2 text-primary me-3"></i>
        <h3 class="mb-0">جميع الإشعارات</h3>
    </div>

    <div class="row g-3">
        @forelse($notifications as $notification)
            <div class="col-12">
                <div class="card shadow-sm p-3 hover-shadow transition {{ $notification->read_at ? '' : 'border-start border-5 border-primary' }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $notification->data['title'] }}</h6>
                            <p class="mb-1">{{ $notification->data['message'] }}</p>
                            <small class="text-muted">{{ $notification->created_at->format('d-m-Y H:i') }}</small>
                        </div>
                        <div class="text-end d-flex gap-2">
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="تحديد كمقروء">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card text-center text-muted p-4">
                    لا توجد إشعارات اليوم
                </div>
            </div>
        @endforelse
    </div>

    {{-- روابط الصفحات --}}
    <div class="mt-3">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
.table td, .table th {
    text-align: center;
    vertical-align: middle;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    transition: all 0.3s ease;
}
.transition {
    transition: all 0.3s ease;
}
</style>
@endsection
