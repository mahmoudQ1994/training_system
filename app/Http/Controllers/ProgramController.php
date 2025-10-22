<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use App\Notifications\ProgramScheduledTodayNotification;
use App\Models\User;

class ProgramController extends BaseController
{


    /**
     * ✅ عرض جميع البرامج مع إمكانية الفلترة
     */
    public function index(Request $request)
    {
        $query = Program::query();

        // 🔍 البحث بالعنوان أو الجهة المنفذة
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('organizer', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // 📅 الفلترة بالتاريخ
        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('end_date', '<=', $request->to_date);
        }

        // ⚙️ الفلترة بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ترتيب أحدث البرامج أولًا
        $programs = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('programs.index', compact('programs'))
            ->with('page_title', 'البرامج التدريبية');
    }


    /**
     * ✅ صفحة إضافة برنامج جديد
     */
    public function create()
    {
        return view('programs.create');
    }

    /**
     * ✅ حفظ البرنامج الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'program_type' => 'required|in:course,conference,day',
            'organizer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'location' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'target_group' => 'nullable|string|max:255',
            'trainees_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'nullable|string',
        ]);

        // ✅ حفظ الصورة إن وُجدت
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('programs', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        // إنشاء البرنامج وتخزينه في متغير
        $program= Program::create($data);

        //  التحقق من أن البرنامج اليوم
        $today = date('Y-m-d');
        if ($program->start_date == $today) {
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new ProgramScheduledTodayNotification($program));
            }
        }

        return redirect()->route('programs.create')->with('success', '✅ تم حفظ البرنامج بنجاح');
    }

    /**
     * ✅ عرض تفاصيل برنامج معين
     */
    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    /**
     * ✅ صفحة تعديل البرنامج
     */
    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    /**
     * ✅ تحديث بيانات البرنامج بعد التعديل
     */
    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'program_type' => 'required|in:course,conference,day',
            'organizer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'location' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'target_group' => 'nullable|string|max:255',
            'trainees_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'nullable|string',
        ]);

        // ✅ تحديث الصورة إن تم رفع جديدة
        if ($request->hasFile('image')) {
            if ($program->image_path) {
                $old = str_replace('storage/', '', $program->image_path);
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('image')->store('programs', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $program->update($data);

        return redirect()->route('programs.show', $program)->with('success', '✅ تم تعديل البرنامج بنجاح');
    }

    /**
     * 🗑️ حذف البرنامج
     */
    public function destroy(Program $program)
    {
        if ($program->image_path) {
            $old = str_replace('storage/', '', $program->image_path);
            Storage::disk('public')->delete($old);
        }

        $program->delete();

        return redirect()->route('programs.index')->with('success', '🗑️ تم حذف البرنامج بنجاح');
    }

    /* ------------------------------------------------------------------
     * 👇 دوال خاصة بعرض الأنواع الثلاثة بشكل منفصل (للقوائم الجانبية)
     * ------------------------------------------------------------------ */

    /**
     * 🎓 عرض الدورات التدريبية فقط
     */
 
    public function courses()
    {
        $programs = Program::where('program_type', 'course')
                ->orderBy('start_date', 'desc')
                ->paginate(10); // ✅ هنا التغيير

            $page_title = 'الدورات التدريبية';

            return view('programs.index', compact('programs', 'page_title'));
    }

    /**
     * 📅 عرض الأيام العلمية فقط
     */
    public function days()
    {
        $programs = Program::where('program_type', 'day')
            ->where('status', 'draft') // ✅ فقط المنفذة
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('programs.index', compact('programs'))
            ->with('page_title', 'الأيام العلمية');
    }

    /**
     * 🏛️ عرض المؤتمرات العلمية فقط
     */
    public function conferences()
    {
        $programs = Program::where('program_type', 'conference')
            ->where('status', 'draft') // ✅ فقط المنفذة
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('programs.index', compact('programs'))
            ->with('page_title', 'المؤتمرات العلمية');
    }


}
