<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->guard('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if ($user->hasRole('admin')) {
            return $next($request);
        }

        $rolePermissions = config('admin_permissions.roles.' . $user->role, []);
        if (is_array($rolePermissions) && in_array('*', $rolePermissions, true)) {
            return $next($request);
        }

        if (!$user->hasAdminPermission($permission)) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
