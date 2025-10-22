<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Models\Program;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller as BaseController;


class TraineeController extends BaseController
{

    /**
     * 🧾 عرض قائمة المتدربين
     */
public function index(Request $request)
{
    $query = Trainee::with('program');

    if ($request->filled('name')) {
        $query->where('name_ar', 'like', "%{$request->name}%");
    }

    if ($request->filled('national_id')) {
        $query->where('national_id', 'like', "%{$request->national_id}%");
    }

    if ($request->filled('mobile')) {
        $query->where('mobile', 'like', "%{$request->mobile}%");
    }

    $trainees = $query->paginate(10);
    $programs = Program::all();

    return view('trainees.index', compact('trainees', 'programs'));
}


    /**
     * ➕ صفحة إضافة متدرب جديد
     */
    public function create()
    {
        // سنجلب البرامج لاحقاً بناءً على التاريخ عبر AJAX
        return view('trainees.create');
    }

    /**
     * 💾 حفظ المتدرب الجديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'program_id'     => 'required|exists:programs,id',
            'name_ar'        => 'required|string|max:255',
            'name_en'        => 'nullable|string|max:255',
            'national_id'    => 'required|digits:14',
            'email'          => 'nullable|email',
            'specialization' => 'nullable|string|max:255',
            'job_title'      => 'nullable|string|max:255',
            'organization'   => 'nullable|string|max:255',
            'mobile'         => 'nullable|string|max:20',
        ]);

        // ✅ تحقق من عدم التكرار في نفس البرنامج بناء على الرقم القومي
        $exists = Trainee::where('program_id', $data['program_id'])
            ->where('national_id', $data['national_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['national_id' => '⚠️ هذا المتدرب مسجل بالفعل في هذا البرنامج.'])->withInput();
        }

        Trainee::create($data);

        return redirect()->route('trainees.index')->with('success', '✅ تم إضافة المتدرب بنجاح');
    }

    /**
     * 👁️ عرض بيانات متدرب معين
     */
    public function show(Trainee $trainee)
    {
        return view('trainees.show', compact('trainee'));
    }

    /**
     * ✏️ صفحة تعديل بيانات المتدرب
     */
    public function edit(Trainee $trainee)
    {
        $programs = Program::orderBy('start_date', 'desc')->get();
        return view('trainees.edit', compact('trainee', 'programs'));
    }

    /**
     * 🔁 تحديث بيانات المتدرب
     */
    public function update(Request $request, Trainee $trainee)
    {
        $data = $request->validate([
            'name_ar'        => 'required|string|max:255',
            'name_en'        => 'nullable|string|max:255',
            'national_id'    => 'required|digits:14',
            'email'          => 'nullable|email',
            'specialization' => 'nullable|string|max:255',
            'job_title'      => 'nullable|string|max:255',
            'organization'   => 'nullable|string|max:255',
            'mobile'         => 'nullable|string|max:20',
        ]);

        // ✅ تحقق من عدم التكرار أثناء التعديل
        $exists = Trainee::where('national_id', $data['national_id'])
            ->where('id', '!=', $trainee->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['national_id' => '⚠️ هذا المتدرب مسجل بالفعل.'])->withInput();
        }

        $trainee->update($data);

        return redirect()->route('trainees.index')->with('success', '✅ تم تحديث بيانات المتدرب بنجاح');
    }

    /**
     * 🗓️ جلب البرامج حسب تاريخ البداية (AJAX)
     */
    public function byDate(Request $request)
        {
            $date = $request->query('date');

            if (!$date) {
                return response()->json(['error' => 'لم يتم إرسال التاريخ'], 400);
            }

            $programs = Program::whereDate('start_date', $date)
                ->orderBy('start_time', 'asc')
                ->get(['id', 'title', 'start_date', 'start_time']);

            return response()->json($programs);
        }


    /**
     * 🗑️ حذف متدرب
     */
    public function destroy(Trainee $trainee)
    {
        $trainee->delete();
        return redirect()->route('trainees.index')->with('success', '🗑️ تم حذف المتدرب بنجاح');
    }

    public function reports(Request $request)
    {
        // ✅ جلب جميع البرامج لاستخدامها في الفلترة
        $programs = \App\Models\Program::orderBy('title')->get();

        // ✅ إنشاء استعلام المتدربين مع العلاقات
        $query = \App\Models\Trainee::with('program');

        // 🔍 تطبيق الفلاتر
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        // ✅ تنفيذ الاستعلام
        $trainees = $query->get();

        // 📊 الإحصائيات بناءً على الفلاتر
        $totalTrainees = $trainees->count();
        $totalPrograms = \App\Models\Program::count(); // ✅ إجمالي كل البرامج فعلاً
        $totalInstructors = \App\Models\Program::distinct('instructor')->count('instructor');

        // 📈 البرنامج الأكثر تسجيلاً (اختياري)
        $topProgram = optional(
            $trainees
                ->groupBy('program_id')
                ->sortByDesc(fn($group) => $group->count())
                ->first()
                ?->first() // ← أول متدرب داخل أول مجموعة
                ->program ?? null
        )->title;

        // ✅ تمرير البيانات للواجهة
        return view('trainees.reports', compact(
            'trainees',
            'programs',
            'totalTrainees',
            'totalPrograms',
            'totalInstructors',
            'topProgram'
        ));
    }






}
