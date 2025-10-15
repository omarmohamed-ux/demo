<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // تحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // تحقق من الدور (نستخدم عمود 'role' الذي أضفناه)
        if ($user->role !== $role) {
            abort(403, 'Unauthorized action. You do not have the required role.');
            //return redirect('/dashboard')->with('error', 'You are unauthorized for this page.');

        }

        return $next($request);
    }
}