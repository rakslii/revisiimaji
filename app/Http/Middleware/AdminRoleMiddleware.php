<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login first.');
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Admin access only.');
        }

        return $next($request);
    }
}