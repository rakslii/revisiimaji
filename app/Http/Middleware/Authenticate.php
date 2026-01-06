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
        // ⚡ JIKA AKSES ADMIN ROUTE, REDIRECT KE ADMIN LOGIN
        if ($request->is('admin/*')) {
            return route('admin.login'); // ⚡ INI YANG BENAR!
        }
        
        // ⚡ UNTUK PUBLIC ROUTES, REDIRECT KE GOOGLE OAUTH
        return route('google.login');
    }
}