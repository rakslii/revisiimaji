<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCode;

class PromoCodeController extends Controller
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
        $promoCodes = PromoCode::latest()->paginate(10);
        return view('pages.admin.promos.index', compact('promoCodes'));
    }
    
    public function storePromoCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        PromoCode::create($validated);
        
        return back()->with('success', 'Promo code created successfully');
    }
    
    public function updatePromoCode(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $id,
            'discount_percent' => 'required|numeric|min:0|max:100',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        $promoCode->update($validated);
        
        return back()->with('success', 'Promo code updated successfully');
    }
    
    public function deletePromoCode($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();
        
        return back()->with('success', 'Promo code deleted successfully');
    }

}