<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        //  منع الوصول لغير المسجلين
        $this->middleware('auth');
    }

    public function markRead($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->markAsRead();
        return back()->with('success', 'تم تعليم الإشعار كمقروء');
    }

    public function destroy($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->delete();
        return back()->with('success', 'تم حذف الإشعار');
    }
}
