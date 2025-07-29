<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Izinkan akses ke welcome page tanpa login
        if ($request->is('/')) {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Akses ditolak.');
        }
    
        return $next($request);
    }
    
}
