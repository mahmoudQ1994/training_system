<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingHall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingHallController extends Controller
{
    public function create()
    {
        return view('halls.create');
    }

    public function index(Request $request){
        $query = TrainingHall::query()->with(['creator','updater'])->orderBy('created_at','desc');

        // تطبيق الفلاتر إن وجدت
        if ($request->filled('hall_name')) {
            $query->where('hall_name', 'like', '%' . $request->hall_name . '%');
        }
        if ($request->filled('hall_code')) {
            $query->where('hall_code', 'like', '%' . $request->hall_code . '%');
        }
        if ($request->filled('building_name')) {
            $query->where('building_name', 'like', '%' . $request->building_name . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $halls = $query->paginate(15)->withQueryString();

        return view('halls.index', compact('halls'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'hall_name' => 'required|string|max:150',
            'hall_code' => 'nullable|string|max:50|unique:training_halls,hall_code',
            'building_name' => 'nullable|string|max:100',
            'floor_number' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:0',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string|max:100',
            'status' => 'required|in:متاحة,محجوزة,صيانة',
            'image' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ]);

        // معالجة رفع الصورة إن وجدت
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('halls', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $data['facilities'] = $data['facilities'] ?? null;
        $data['created_by'] = Auth::id();

        TrainingHall::create($data);

        return redirect()->route('halls.index')->with('success', 'تم إضافة القاعة بنجاح');
    }

    public function edit(TrainingHall $hall)
    {
        return view('halls.edit-hall', compact('hall'));
    }

    public function update(Request $request, TrainingHall $hall)
    {
        $data = $request->validate([
            'hall_name' => 'required|string|max:150',
            'hall_code' => 'nullable|string|max:50|unique:training_halls,hall_code,' . $hall->id,
            'building_name' => 'nullable|string|max:100',
            'floor_number' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:0',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string|max:100',
            'status' => 'required|in:متاحة,محجوزة,صيانة,مغلقة',
            'image' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ]);

        // معالجة رفع الصورة إن وجدت
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($hall->image) {
                $oldImagePath = str_replace('storage/', '', $hall->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            $path = $request->file('image')->store('halls', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $data['facilities'] = $data['facilities'] ?? null;
        $data['updated_by'] = Auth::id();

        $hall->update($data);

        return redirect()->route('halls.index')->with('success', 'تم تحديث بيانات القاعة بنجاح');
    }

    public function destroy(TrainingHall $hall)
    {
        // حذف الصورة إن وجدت
        if ($hall->image) {
            $oldImagePath = str_replace('storage/', '', $hall->image);
            Storage::disk('public')->delete($oldImagePath);
        }

        $hall->delete();

        return redirect()->route('halls.index')->with('success', 'تم حذف القاعة بنجاح');
    }   

    public function show(TrainingHall $hall)
    {
        return view('halls.show-halls', compact('hall'));
    }

    public function bookings(TrainingHall $hall)
    {
        $bookings = $hall->bookings()->with('user')->latest()->paginate(10);
        return view('halls.bookings.list', compact('hall', 'bookings'));
    }
    

}
