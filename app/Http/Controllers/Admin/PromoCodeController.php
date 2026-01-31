<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PromoCode::latest();
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status) {
            switch($request->status) {
                case 'active':
                    $query->where('is_active', true)
                          ->where('valid_from', '<=', now())
                          ->where('valid_until', '>=', now())
                          ->whereRaw('used_count < quota');
                    break;
                case 'expired':
                    $query->where('valid_until', '<', now());
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'quota_exceeded':
                    $query->whereRaw('used_count >= quota');
                    break;
            }
        }
        
        $promoCodes = $query->paginate(10);
        
        return view('pages.admin.promos.index', compact('promoCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.promos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|unique:promo_codes,code|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        // Generate code if not provided
        if (empty($validated['code'])) {
            do {
                $code = strtoupper(Str::random(8));
            } while (PromoCode::where('code', $code)->exists());
            $validated['code'] = $code;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['used_count'] = 0;

        PromoCode::create($validated);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo code created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('pages.admin.promos.show', compact('promoCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('pages.admin.promos.edit', compact('promoCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $id . '|max:50',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,nominal',
            'value' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:' . $promoCode->used_count,
            'min_purchase' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $promoCode->update($validated);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo code deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->update(['is_active' => !$promoCode->is_active]);

        return back()->with('success', 'Status updated successfully.');
    }
}