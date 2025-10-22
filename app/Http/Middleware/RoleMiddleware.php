<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:admin') or 'role:super_admin'
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (! Auth::check()) {
            abort(403, 'غير مصرح');
        }

        $user = Auth::user();

        // لو دور واحد فقط
        if ($user->role === $role) {
            return $next($request);
        }

        // دعم تمرير أكثر من دور مفصول بفواصل: 'admin,super_admin'
        $roles = explode(',', $role);
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
    }
}
