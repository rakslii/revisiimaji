<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
{
    // ⚡ HAPUS INI: $this->middleware('auth');
    // Karena ini yang bikin redirect ke /login
    
    // Cek role admin saja
    $this->middleware(function ($request, $next) {
        if (!auth()->check()) {
            // Manual redirect ke admin.login
            return redirect()->route('admin.login')
                ->with('error', 'Please login first.');
        }
        
        if (auth()->user()->role !== 'admin') {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Admin access only.');
        }
        
        return $next($request);
    });
}
    public function index()
    {
        return view('admin.settings.index');
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'required|string',
            'site_address' => 'nullable|string',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:1024',
            'whatsapp_number' => 'required|string',
            'whatsapp_message' => 'nullable|string',
        ]);
        
        // Save settings logic here
        // Bisa menggunakan database, config file, atau cache
        
        return back()->with('success', 'Settings updated successfully');
    }

}