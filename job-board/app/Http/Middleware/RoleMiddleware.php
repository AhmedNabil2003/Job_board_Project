<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // تحقق إذا كان المستخدم مسجلاً الدخول وله الدور المناسب
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }
        
        // إعادة توجيه المستخدم إذا لم يكن لديه الصلاحية المناسبة
        return redirect('/')->with('error', 'You do not have access to this section.');
    }
}
