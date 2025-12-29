<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Check auth status (untuk API/Vue frontend)
    public function check()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'avatar' => Auth::user()->avatar,
                'phone' => Auth::user()->phone,
                'is_admin' => Auth::user()->isAdmin(),
            ] : null
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Jika request API, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Logout berhasil'
            ]);
        }
        
        return redirect('/')->with('success', 'Logout berhasil');
    }

    // Get current user info
    public function me()
    {
        $user = Auth::user();
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'role' => $user->role,
                'created_at' => $user->created_at->format('d/m/Y'),
            ],
            'stats' => [
                'total_orders' => $user->orders()->count(),
                'pending_orders' => $user->orders()->where('status', 'pending')->count(),
                'total_spent' => $user->orders()->where('payment_status', 'paid')->sum('final_amount'),
            ]
        ]);
    }
}