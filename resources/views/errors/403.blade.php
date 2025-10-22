@extends('layouts.app')

@section('title', 'صلاحيات غير كافية')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-xl rounded-2xl p-10 max-w-lg text-center border border-gray-200">
        <div class="text-red-500 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m0 3.75h.007M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-3">🚫 صلاحيات غير كافية</h1>
        <p class="text-gray-600 mb-6">
            عذرًا، لا تملك صلاحية الوصول إلى هذه الصفحة.<br>
            يرجى الرجوع إلى الصفحة الرئيسية أو التواصل مع المشرف.
        </p>
        <a href="{{ url('/') }}" 
           class="inline-block px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300">
            العودة إلى الصفحة الرئيسية
        </a>
    </div>
</div>
@endsection
