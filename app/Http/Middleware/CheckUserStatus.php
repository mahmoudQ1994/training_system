<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->status === 'inactive' || Auth::user()->status === 0 || Auth::user()->status === '0')) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'تم تعطيل حسابك من قبل الإدارة.');
        }

        return $next($request);
    }
}
