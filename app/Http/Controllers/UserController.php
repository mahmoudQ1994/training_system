<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UserController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    // 🛡️ ضبط صلاحيات الوصول حسب نوع المستخدم
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            // 🧑‍💼 المستخدم العادي "user" يمكنه فقط الإضافة والعرض، لا يمكنه تعديل أو حذف
            if ($user->role === 'user') {
                if (in_array($request->route()->getName(), [
                    'users.edit', 'users.update', 'users.destroy'
                ])) {
                    abort(403, 'ليس لديك صلاحية الوصول إلى هذه الصفحة ❌');
                }
            }

            // 👨‍💼 المدير "admin" لا يمكنه تعديل أو حذف مستخدم "super_admin"
            if ($user->role === 'admin' && in_array($request->route()->getName(), [
                'users.edit', 'users.update', 'users.destroy'
            ])) {
                $targetId = $request->route('user')?->id;
                $target = \App\Models\User::find($targetId);

                if ($target && $target->role === 'super_admin') {
                    abort(403, 'لا يمكنك تعديل أو حذف مستخدم سوبر أدمن ❌');
                }
            }

            // 🔒 منع المستخدم العادي من دخول صفحة المستخدمين بالكامل
            if ($user->role === 'user' && str_starts_with($request->route()->getName(), 'users.')) 
                abort(403, 'ليس لديك صلاحية لعرض صفحة المستخدمين ❌');

            return $next($request);
        });
    }

    // ✅ عرض قائمة المستخدمين
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    // ✅ عرض صفحة إضافة مستخدم جديد
    public function create()
    {
        return view('users.create');
    }

    // ✅ حفظ المستخدم الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'national_id' => 'required|string|max:14|unique:users,national_id',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'address' => 'nullable|string|max:255',
            'role' => 'required|string|in:user,admin,super_admin',
            'status' => 'required|string|in:active,inactive',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $validated;
        $data['password'] = bcrypt($request->password);

        // ✅ رفع الصورة إن وُجدت
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = $path;
        }

        // ✅ حفظ المستخدم
        User::create($data);

        return redirect()->route('users.index')->with('success', 'تمت إضافة المستخدم بنجاح ✅');
    }

    // ✅ عرض تفاصيل المستخدم
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // ✅ تعديل المستخدم
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // ✅ تحديث البيانات
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin,super_admin',
            'status' => 'required|in:active,inactive',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ✅ رفع الصورة الجديدة إن وُجدت
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم ✅');
    }

    // ✅ حذف المستخدم
    public function destroy(User $user)
    {
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح 🗑️');
    }
}
