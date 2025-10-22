@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-images me-2"></i> صور القاعة: {{ $hall->hall_name }}
    </h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('halls.images.store', $hall->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row align-items-center g-2">
            <div class="col-md-8">
                <input type="file" name="images[]" multiple accept="image/*" class="form-control" required>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary">
                    <i class="bi bi-upload"></i> رفع الصور
                </button>
            </div>
        </div>
    </form>

<div class="row">
    @forelse($images as $image)
        <div class="col-md-3 mb-4 position-relative">
            <div class="card shadow-sm overflow-hidden" style="border-radius: 10px; position: relative;">
                
                <!-- الصورة تفتح في GLightbox -->
                <a href="{{ asset($image->image_path) }}" 
                   class="glightbox" 
                   data-gallery="hall-gallery"
                   data-title="
                        <div class='text-center'>
                            <strong>{{ $hall->hall_name }}</strong><br>
                            <a href='{{ asset($image->image_path) }}' download class='btn btn-sm btn-success mt-2'>
                                <i class=\'bi bi-download\'></i> تحميل
                            </a>
                        </div>
                   ">
                    <img src="{{ asset($image->image_path) }}" 
                         class="card-img-top" 
                         style="height:200px; object-fit:cover; cursor:pointer;">
                </a>

                <!-- زر الحذف -->
                <form action="{{ route('halls.images.destroy', [$hall->id, $image->id]) }}" 
                      method="POST" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟')" 
                      class="position-absolute top-0 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger opacity-75">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-muted">لا توجد صور بعد لهذه القاعة.</p>
    @endforelse
</div>




    <div class="mt-3">
        <a href="{{ route('halls.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> العودة إلى قائمة القاعات
        </a>
    </div>
</div>
@endsection
