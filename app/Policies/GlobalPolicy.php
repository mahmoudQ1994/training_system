<?php

namespace App\Policies;

use App\Models\User;

class GlobalPolicy
{
    /**
     * 🟢 كل المستخدمين يقدروا يعرضوا البيانات
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['user', 'admin', 'super_admin']);
    }

    public function view(User $user)
    {
        return in_array($user->role, ['user', 'admin', 'super_admin']);
    }

    /**
     * 🟡 الإضافة متاحة لكل الأدوار
     */
    public function create(User $user)
    {
        return in_array($user->role, ['user', 'admin', 'super_admin']);
    }

    /**
     * 🟠 التعديل فقط للمدير والسوبر أدمن
     */
    public function update(User $user)
    {
        return in_array($user->role, ['admin', 'super_admin']);
    }

    /**
     * 🔴 الحذف فقط للسوبر أدمن
     */
    public function delete(User $user)
    {
        return $user->role === 'super_admin';
    }
}
