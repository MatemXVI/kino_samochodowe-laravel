<?php

namespace App\Http\Middleware;

use BackedEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles){
        if (!Auth::check()) {
            if (in_array('user', $roles, true))
                return redirect()->route("login")->with("message", "Musisz się zalogować, aby uzyskać dostęp.");
            if (in_array('admin', $roles, true) || in_array('superadmin', $roles, true))
                return redirect()->route("admin.login")->with("message", "Musisz zalogować się jako administrator, aby uzyskać dostęp.");
        }

        if (!in_array(Auth::user()->role, $roles, true)) {
            abort(403, 'Brak dostępu.');
        }

        return $next($request);
    }
}

