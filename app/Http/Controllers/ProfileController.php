<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $locations = $user->locations()->orderBy('is_primary', 'desc')->get();
        
        // Ambil alamat utama jika ada
        $primaryAddress = $user->locations()->where('is_primary', true)->first();
        
        return view('pages.profile.index', compact('user', 'locations', 'primaryAddress'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
        $user->save();
        
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_primary' => 'boolean'
        ]);
        
        $user = auth()->user();
        
        // If setting as primary, unset other primary locations
        if ($request->is_primary) {
            $user->locations()->update(['is_primary' => false]);
        }
        
        Location::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'full_address' => $request->full_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'is_primary' => $request->is_primary ?? false,
        ]);
        
        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }
    
public function editLocation(Location $location)
{
    if ($location->user_id !== auth()->id()) {
        abort(403);
    }
    
    return response()->json([
        'name' => $location->name,
        'recipient_name' => $location->recipient_name,
        'recipient_phone' => $location->recipient_phone,
        'full_address' => $location->full_address,
        'city' => $location->city,
        'province' => $location->province,
        'postal_code' => $location->postal_code,
        'latitude' => $location->latitude,
        'longitude' => $location->longitude,
        'is_primary' => $location->is_primary,
    ]);
}

    public function updateLocation(Request $request, Location $location)
    {
        if ($location->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_primary' => 'boolean'
        ]);
        
        $user = auth()->user();
        
        // If setting as primary, unset other primary locations
        if ($request->is_primary) {
            $user->locations()->where('id', '!=', $location->id)->update(['is_primary' => false]);
        }
        
        $location->update([
            'name' => $request->name,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'is_primary' => $request->is_primary ?? $location->is_primary,
        ]);
        
        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function deleteLocation(Location $location)
    {
        if ($location->user_id !== auth()->id()) {
            abort(403);
        }
        
        $location->delete();
        
        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setPrimaryLocation(Location $location)
    {
        if ($location->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Unset all primary locations
        auth()->user()->locations()->update(['is_primary' => false]);
        
        // Set this as primary
        $location->update(['is_primary' => true]);
        
        return back()->with('success', 'Alamat utama berhasil diperbarui.');
    }
}