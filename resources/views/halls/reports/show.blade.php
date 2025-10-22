@extends('layouts.app')

@section('title', 'عرض تقرير المرور على القاعة')

@section('content')
<div class="container py-4" id="report-area">

    <div class="card shadow border-0 mb-4 mx-auto" style="max-width: 1900px; margin-top: 0 !important;">
        <div class="card-body p-5">

            <!-- رأس التقرير -->
<div class="d-flex justify-content-between align-items-center mb-0" style="margin-top: 0 !important;">
                <!-- الجهة اليمنى -->
                <div class="text-end">
                    <h4 class="text-primary mb-1" style="font-size: 15px">مديرية الشئون الصحية بسوهاج</h4>
                    <h5 class=" text-primary mb-0" style="font-size: 13px">إدارة التدريب وتنمية الموارد البشرية</h5>
                </div>

                <!-- شعار -->
                <div class="text-start">
                    <img src="{{ asset('images/sohag_health_logo.png') }}" alt="شعار مديرية الصحة بسوهاج" style="height: 60px;">
                </div>
            </div>

            <!-- العنوان الرئيسي للتقرير -->
            <div class="text-center mb-1">
                <h4 class="fw-bold  text-dark mb-0">
                    تقرير المرور على قاعات التدريب
                </h4>
                <p class="mb-0">تاريخ طباعة التقرير: {{ $report->created_at ? $report->created_at->format('Y-m-d') : '-' }}</p>
            </div>

            <hr class="my-3" style="border-top: 2px solid #000;">


            <!-- بيانات القاعة بتصميم 4 أعمدة -->
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-3">بيانات القاعة</h6>
                <table class="table table-bordered align-middle text-center">
                    <tbody>
                        <tr>
                            <th class="bg-light" >اسم القاعة</th>
                            <td >{{ $report->hall->hall_name ?? '-' }}</td>
                            <th class="bg-light" >السعة</th>
                            <td >{{ $report->hall->capacity ?? '-' }}</td>
                            <th class="bg-light" >تاريخ المرور</th>
                            <td >{{ $report->inspection_date }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">المبنى</th>
                            <td>{{ $report->hall->building_name ?? '-' }}</td>
                            <th class="bg-light">الدور</th>
                            <td>{{ $report->hall->floor_number ?? '-' }}</td>
                            <th class="bg-light">تم المرور بواسطة</th>
                            <td>{{ $report->inspected_by ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- نسبة الجاهزية -->
            <div class="mb-1">
                <h6 class="fw-bold text-primary mb-1">نسبة الجاهزية العامة</h6>
                <div class="progress" style="height: 23px; font-size: 1.5rem;">
                    <div class="progress-bar 
                        @if($report->readiness_percent >= 80) bg-success 
                        @elseif($report->readiness_percent >= 50) bg-warning 
                        @else bg-danger @endif"
                        role="progressbar"
                        style="width: {{ $report->readiness_percent }}%">
                        {{ $report->readiness_percent }}%
                    </div>
                </div>
            </div>

            <!-- جدول العناصر -->
            <div class="mb-2">
                <h6 class="fw-bold text-primary mb-1">العناصر التي تم المرور عليها</h6>
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th >العنصر</th>
                            <th >النتيجة</th>
                            <th >العنصر</th>
                            <th >النتيجة</th>
                            <th >العنصر</th>
                            <th >النتيجة</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px">
                        <tr>
                            <td class="text-center">عدد كراسي المتدربين</td>
                            <td>{{ $report->chairs_count ?? '-' }}</td>
                            <td class="text-center">مكتب المحاضر</td>
                            <td>{!! $report->lecturer_desk ? '✅' : '❌' !!}</td>
                            <td class="text-center">شاشة العرض</td>
                            <td>{!! $report->display_screen ? '✅' : '❌' !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center">جهاز كمبيوتر</td>
                            <td>{!! $report->computer_available ? '✅' : '❌' !!}</td>
                            <td class="text-center">وصلات وكابلات</td>
                            <td>{!! $report->cables_available ? '✅' : '❌' !!}</td>
                            <td class="text-center">سبورة ورقية</td>
                            <td>{!! $report->paper_board ? '✅' : '❌' !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center">سبورة بيضاء</td>
                            <td>{!! $report->white_board ? '✅' : '❌' !!}</td>
                            <td class="text-center">أجهزة التكييف </td>
                            <td>{!! $report->air_conditioning ? '✅' : '❌' !!}</td>
                            <td class="text-center">الإنترنت</td>
                            <td>{!! $report->internet_available ? '✅' : '❌' !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center">سماعات صوتية</td>
                            <td>{!! $report->sound_system ? '✅' : '❌' !!}</td>
                            <td class="text-center">الإضاءة كافية</td>
                            <td>{!! $report->lighting_good ? '✅' : '❌' !!}</td>
                            <td class="text-center">التهوية جيدة</td>
                            <td>{!! $report->ventilation_good ? '✅' : '❌' !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center">صالة انتظار</td>
                            <td>{!! $report->waiting_area ? '✅' : '❌' !!}</td>
                            <td class="text-center">بوفيه لخدمة المتدربين</td>
                            <td>{!! $report->buffet_available ? '✅' : '❌' !!}</td>
                            <td class="text-center">حمامات</td>
                            <td>{!! $report->toilets_available ? '✅' : '❌' !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center">طفايات حريق كافية</td>
                            <td>{!! $report->fire_extinguishers ? '✅' : '❌' !!}</td>
                            <td class="text-center">مخرج طوارئ</td>
                            <td>{!! $report->emergency_exit ? '✅' : '❌' !!}</td>
                            <td class="text-center">عدد اجهزة التكييف</td>
                            <td>{{ $report->air_conditioning_count ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- الملاحظات -->
            <div class="mb-3">
                <h6 class="fw-bold text-primary mb-1">الملاحظات</h6>
                <div class="border rounded p-3" style="min-height: 100px;">
                    {{ $report->notes ?? 'لا توجد ملاحظات.' }}
                </div>
            </div>

            <!-- بيانات الإضافة والتعديل -->
            <div class="mb-2">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>أضيف الكترونى بواسطة</th>
                            <th>عُدّل بواسطة</th>
                            <th>تاريخ آخر تعديل</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $report->creator->name ?? '-' }}</td>
                            <td>{{ $report->updater->name ?? '-' }}</td>
                            <td>{{ $report->updated_at ? $report->updated_at->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- التواقيع -->
            <div class="mt-1 pt-1 ">
                <div class="row text-center fw-bold">
                    <div class="col-4">
                        <p>مسئول نظم المعلومات</p>
                    </div>
                    <div class="col-4">
                        <p>القائم بالمرور</p>
                    </div>
                    <div class="col-4">
                        <p>رئيس لجنة المرور</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- زر الطباعة -->
    <div class="text-center mt-2 no-print">
        <button class="btn btn-primary" onclick="printReport()">
            <i class="bi bi-printer"></i> طباعة التقرير
        </button>
        <a href="{{ route('hall_reports.index') }}" class="btn btn-secondary ms-2">
            <i class="bi bi-arrow-right-circle"></i> عودة للتقارير
        </a>
    </div>
</div>

<!-- CSS للطباعة -->

<style>
@media print {
    @page {
        margin-top: 0;
        margin-bottom: 10mm;
        margin-left: 10mm;
        margin-right: 10mm;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
        -webkit-print-color-adjust: exact !important;
    }

    #report-area {
        margin: 0 !important;
        padding: 0 !important;
        width: 210mm;
        min-height: 297mm;
    }
}


</style>


<script>
function printReport() {
    // حفظ محتوى الصفحة الأصلي
    const originalContent = document.body.innerHTML;

    // الحصول على محتوى التقرير فقط
    const reportContent = document.getElementById('report-area').innerHTML;

    // استبدال محتوى الصفحة بمحتوى التقرير مؤقتاً
    document.body.innerHTML = reportContent;

    // اخفائة عناصر لا تحتاج للطباعة مثل زر الطباعة والعودة للخلف 
    const elementsToHide = document.querySelectorAll('.no-print');
    elementsToHide.forEach(el => el.style.display = 'none');
    

    // تنفيذ أمر الطباعة
    window.print();

    // بعد الطباعة، استرجاع المحتوى الأصلي
    document.body.innerHTML = originalContent;

    // إعادة تحميل الـ JS والـ CSS بشكل صحيح بعد الاسترجاع
    window.location.reload();
}
</script>


@endsection
