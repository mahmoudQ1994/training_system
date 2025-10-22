<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function editPassword()
    {
        $user = Auth::user();
        return view('profile.partials.update-password-form', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.partials.update-profile-information-form', compact('user'));
    }

    public function updateProfile(Request $request)
        {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        User::where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'تم تحديث المعلومات الشخصية بنجاح!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(Auth::id());

        if (! $user instanceof User) {
            return back()->with('error', 'المستخدم غير موجود.');
        }

        // حفظ الصورة في storage/public/profile_photos
        $fileName = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('public/profile_photos', $fileName);

        // لو عنده صورة قديمة نحذفها لتجنب التراكم
        if ($user->profile_image && Storage::exists('public/profile_photos/' . basename($user->profile_image))) {
            Storage::delete('public/profile_photos/' . basename($user->profile_image));
        }

        // حفظ المسار الجديد في قاعدة البيانات
        $user->profile_image = 'storage/profile_photos/' . $fileName;
        $user->save();

        return back()->with('success', 'تم تحديث الصورة بنجاح!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        /** @var User $user */
        $user = User::find(Auth::id());

        if (! $user instanceof User) {
            return back()->with('error', 'المستخدم غير موجود.');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'كلمة المرور الحالية غير صحيحة.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'تم تحديث كلمة المرور بنجاح.');
    }

}

