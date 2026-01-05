<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ⚡ OVERRIDE DEFAULT AUTH REDIRECT
        Route::aliasMiddleware('auth', \App\Http\Middleware\Authenticate::class);
        
        // Atau override global redirect
        $this->overrideAuthRedirect();
    }
    
    protected function overrideAuthRedirect()
    {
        // Override default auth redirect logic
        if (request()->is('admin/*')) {
            config(['auth.redirects.login' => 'admin.login']);
            config(['auth.redirects.home' => 'admin.dashboard']);
        }
    }
}