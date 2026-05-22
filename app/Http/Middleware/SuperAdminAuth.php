<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('super_admin_authenticated')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autorizado.'], 401);
            }
            return redirect()->route('super-admin.login-form');
        }

        return $next($request);
    }
}
