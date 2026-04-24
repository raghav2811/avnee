<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Try to authenticate via the 'admin' guard
        if (!auth()->guard('admin')->check()) {
             return redirect()->route('admin.login');
        }

        $user = auth()->guard('admin')->user();
        if ($user->role !== 'admin' && $user->role !== 'staff') {
             auth()->guard('admin')->logout();
             return redirect()->route('admin.login')->withErrors(['email' => 'Insufficient permissions.']);
        }

        return $next($request);
    }
}
