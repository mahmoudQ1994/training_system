<?php

namespace App\Http\Controllers;

use App\Models\TrainingHall;
use App\Models\HallImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class HallImageController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('can:viewAny');
        $this->middleware('can:create')->only(['create', 'store']);
        $this->middleware('can:update')->only(['edit', 'update']);
        $this->middleware('can:delete')->only(['destroy']);
    }


    public function index(TrainingHall $hall){
        $images = $hall->images;
        return view('halls.images.index', compact('hall', 'images'));

    }

 public function store(Request $request, TrainingHall $hall)
{
    $request->validate([
        'images.*' => 'image|max:2048', // تحقق من كل صورة
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('hall_images', 'public');
            $hall->images()->create([
                'image_path' => 'storage/' . $path,
            ]);
        }
    }

    return redirect()->back()->with('success', 'تم رفع الصور بنجاح');
}
    public function destroy(HallImage $image)
    {
        // حذف الصورة من التخزين    
        Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
        // حذف السجل من قاعدة البيانات
        $image->delete();

        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }

}
