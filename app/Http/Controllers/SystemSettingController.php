<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;

class SystemSettingController extends Controller
{
    public function __construct()
    {
        // 🛡️ السماح فقط للسوبر أدمن بالدخول إلى صفحة الإعدادات
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || auth()->user()->role !== 'super_admin') {
                abort(403, 'غير مصرح لك بالوصول إلى هذه الصفحة.');
            }
            return $next($request);
        });
    }

    // ✅ عرض صفحة الإعدادات
    public function index()
    {
        $settings = SystemSetting::first();
        return view('settings.index', compact('settings'));
    }

    // ✅ تحديث الإعدادات
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'system_name' => 'nullable|string|max:255',
                'directorate_name' => 'nullable|string|max:255',
                'department_name' => 'nullable|string|max:255',
                'primary_color' => 'nullable|string|max:20',
                'secondary_color' => 'nullable|string|max:20',
                'default_language' => 'required|string|in:ar,en',
                'default_email' => 'nullable|email',
                'notifications_enabled' => 'nullable',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $settings = SystemSetting::firstOrCreate(['id' => 1]);

            if ($request->hasFile('logo')) {
                if ($settings->logo_path && Storage::exists('public/' . $settings->logo_path)) {
                    Storage::delete('public/' . $settings->logo_path);
                }
                $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
            }

            $validated['notifications_enabled'] = $request->has('notifications_enabled');

            $settings->update($validated);

            return redirect()->back()->with('success', 'تم تحديث إعدادات النظام بنجاح ✅');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage());
        }
    }
}
