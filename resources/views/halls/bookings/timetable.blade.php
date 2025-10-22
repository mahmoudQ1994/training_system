@extends('layouts.app')

@section('title', 'الجدول الزمني لحجوزات القاعات')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">
            <i class="bi bi-calendar4-week me-2"></i>
            الجدول الزمني لحجوزات القاعات ({{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }})
        </h4>

        <div>
            <a href="{{ route('halls.halls.bookings.timetable', ['month' => \Carbon\Carbon::parse($month)->subMonth()->format('Y-m')]) }}" class="btn btn-outline-primary btn-sm">
                ⬅️ الشهر السابق
            </a>
            <a href="{{ route('halls.halls.bookings.timetable', ['month' => \Carbon\Carbon::parse($month)->addMonth()->format('Y-m')]) }}" class="btn btn-outline-primary btn-sm">
                ➡️ الشهر التالي
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table text-center align-middle" style="border-collapse: collapse;">
            <thead class="table-primary">
                <tr>
                    <th style="width: 110px;">التاريخ</th>
                    <th style="width: 90px;">اليوم</th>
                    @foreach($halls as $hall)
                        <th>{{ $hall->hall_name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $daysOfWeek = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                    $start = $startOfMonth->copy();
                @endphp

                @while($start->lte($endOfMonth))
                    <tr 
                        @if($start->dayOfWeek === 5) 
                            style="background-color:#f0f0f0;"
                        @endif
                    >
                        {{-- التاريخ --}}
                        <td class="fw-bold text-secondary">{{ $start->format('Y-m-d') }}</td>
                        {{-- اليوم --}}
                        <td class="fw-bold text-secondary">{{ $daysOfWeek[$start->dayOfWeekIso - 6 >= 0 ? $start->dayOfWeekIso - 6 : $start->dayOfWeekIso + 1] }}</td>

                        {{-- لو اليوم جمعة --}}
                        @if($start->dayOfWeek === 5)
                            <td colspan="{{ count($halls) }}" class="text-danger fw-bold" style="background: #f8d7da;">
                                💤 إجازة — قاعات المركز لا تعمل بهذا اليوم إلا في حالات الطوارئ والتنسيق مباشرة مع المشرف العام على قطاع التدريب  .
                            </td>
                        @else
                            {{-- باقي الأيام --}}
                            @foreach($halls as $hall)
                                @php
                                    $booking = $hall->bookings->first(function($b) use ($start) {
                                        return $start->between(
                                            \Carbon\Carbon::parse($b->booking_date),
                                            \Carbon\Carbon::parse($b->end_date)
                                        );
                                    });
                                @endphp

                                <td style="{{ $booking ? 'background-color:#d1e7dd;' : '' }}">
                                    @if($booking)
                                        <span class="fw-bold text-success">{{ $booking->requesting_department }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        @endif
                    </tr>
                    @php $start->addDay(); @endphp
                @endwhile
            </tbody>
        </table>
    </div>

</div>

<style>
    .table-responsive {
        max-height: 75vh; /* تحديد ارتفاع الجدول */
        overflow: auto; /* تفعيل التمرير */
        border: 1px solid #dee2e6;
    }

    /* تثبيت الهيدر */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #0d6efd; /* لون أزرق للهيدر */
        color: #fff;
        z-index: 30;
        text-align: center;
        white-space: nowrap;
    }

    /* تحسين الخلايا */
    .table tbody td {
        vertical-align: middle;
        transition: background-color 0.2s ease-in-out;
    }

    /* تظليل عند مرور الماوس */
    tbody tr:hover td {
        background-color: #eef4ff !important;
    }

    /* صف الجمعة */
    tr[style*="background-color:#f0f0f0;"] {
        background-color: #e9ecef !important;
        font-weight: bold;
        color: #555;
    }

    tr[style*="background-color:#f0f0f0;"]:hover td {
        background-color: #e9ecef !important;
    }
</style>


@endsection
