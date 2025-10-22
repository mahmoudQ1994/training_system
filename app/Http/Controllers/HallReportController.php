<?php

namespace App\Http\Controllers;

use App\Models\HallReport;
use App\Models\TrainingHall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Notifications\HallReportAddedNotification;
use App\Models\User;

class HallReportController extends BaseController
{

    public function index(Request $request)
    {
        // نبدأ الكويري الأساسي
        $query = \App\Models\HallReport::with('hall');

        // 🔍 بحث عام (على اسم القاعة أو القائم بالمرور)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('hall', function ($q) use ($search) {
                $q->where('hall_name', 'LIKE', "%{$search}%");
            })->orWhere('inspected_by', 'LIKE', "%{$search}%");
        }

        // 👤 اسم القائم بالمرور
        if ($request->filled('inspected_by')) {
            $query->where('inspected_by', 'LIKE', "%{$request->inspected_by}%");
        }

        // 📅 من تاريخ
        if ($request->filled('from_date')) {
            $query->whereDate('inspection_date', '>=', $request->from_date);
        }

        // 📅 إلى تاريخ
        if ($request->filled('to_date')) {
            $query->whereDate('inspection_date', '<=', $request->to_date);
        }

        // 🧑‍💻 تم الإضافة بواسطة
        if ($request->filled('created_by')) {
            $query->where('created_by', 'LIKE', "%{$request->created_by}%");
        }

        // 🧑‍🔧 تم التعديل بواسطة
        if ($request->filled('updated_by')) {
            $query->where('updated_by', 'LIKE', "%{$request->updated_by}%");
        }

        // 📋 ترتيب النتائج الأحدث أولاً
        $reports = $query->orderBy('inspection_date', 'desc')->paginate(10);

        // 🔁 عرض النتائج مع الاحتفاظ بقيم الفلتر في الصفحة
        return view('halls.reports.index', compact('reports'));
    }


    public function create()
    {
        $halls = TrainingHall::all();
        return view('halls.reports.create', compact('halls'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['readiness_percent'] = $this->calculateReadinessPercent($data);
        $data['created_by'] = Auth::id();

        $report=  HallReport::create($data);
            if ($report->created_at && $report->created_at->format('Y-m-d') == now()->format('Y-m-d')) {
                $users = User::all();
                foreach ($users as $user) {
                    $user->notify(new HallReportAddedNotification($report));
                }
            }

        return redirect()->route('hall_reports.index')
            ->with('success', 'تم حفظ التقرير بنجاح بنسبة جاهزية ' . $data['readiness_percent'] . '%');
    }

    public function update(Request $request, HallReport $hallReport)
    {
        $data = $request->all();
        $data['readiness_percent'] = $this->calculateReadinessPercent($data);
        $data['updated_by'] = Auth::id();

        $hallReport->update($data);

        return redirect()->route('hall_reports.index')
        ->with('success', 'تم تعديل التقرير بنجاح (نسبة الجاهزية: ' . $data['readiness_percent'] . '%)');
    }

    private function calculateReadinessPercent($data)
    {
        $fields = [
            'lecturer_desk', 'display_screen', 'computer_available', 'cables_available',
            'paper_board', 'white_board', 'air_conditioning', 'internet_available',
            'sound_system', 'lighting_good', 'ventilation_good', 'waiting_area',
            'buffet_available', 'toilets_available', 'fire_extinguishers', 'emergency_exit'
        ];

        $availableCount = 0;
        foreach ($fields as $field) {
            if (!empty($data[$field])) $availableCount++;
        }

        return round(($availableCount / count($fields)) * 100, 2);
    }

    public function show($id)
    {


        $report = \App\Models\HallReport::with(['hall', 'creator', 'updater'])->findOrFail($id);
        return view('halls.reports.show', compact('report'));
    }

    public function edit(HallReport $hallReport)
    {
        $halls = TrainingHall::all();
        return view('halls.reports.edit', compact('hallReport', 'halls'));
    }

    public function destroy(HallReport $hallReport)
    {
        $hallReport->delete();
        return redirect()->route('hall_reports.index')
        ->with('success', 'تم حذف التقرير بنجاح');
    }



}
