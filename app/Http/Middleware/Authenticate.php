<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // ⚡ JIKA AKSES ROUTE ADMIN, REDIRECT KE ADMIN LOGIN
        if ($request->is('admin/*') || $request->routeIs('admin.*')) {
            return route('admin.login'); // Ini bener, ke pages.admin.login
        }
        
        // ⚡ Default redirect ke CUSTOMER LOGIN (lu gak punya ini)
        // Tapi di routes lu ada Route::get('/login', function() { return view('auth.login'); })
        // Tapi view auth.login gak ada!
        
        // ⚡ SOLUSI 1: Redirect ke home atau buat customer login
        return $request->expectsJson() ? null : url('/');
        
        // ⚡ ATAU SOLUSI 2: Buat simple login page dulu
        // return $request->expectsJson() ? null : route('home');
    }
}