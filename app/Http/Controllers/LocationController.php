<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get user locations
     */
    public function index()
    {
        $locations = Location::where('user_id', Auth::id())
            ->orderByDesc('is_primary')
            ->orderByDesc('created_at')
            ->get();
        
        return response()->json([
            'locations' => $locations,
        ]);
    }

    /**
     * Store a new location
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'is_primary' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        
        // If setting as primary, unset other primary locations
        if ($request->is_primary) {
            Location::where('user_id', Auth::id())->update(['is_primary' => false]);
        } else {
            // If this is the first location, set as primary
            $hasLocations = Location::where('user_id', Auth::id())->exists();
            if (!$hasLocations) {
                $data['is_primary'] = true;
            }
        }
        
        $location = Location::create($data);
        
        return response()->json([
            'message' => 'Lokasi berhasil ditambahkan',
            'location' => $location,
        ], 201);
    }

    /**
     * Update location
     */
    public function update(Request $request, $id)
    {
        $location = Location::where('user_id', Auth::id())->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:100',
            'recipient_name' => 'sometimes|string|max:100',
            'recipient_phone' => 'sometimes|string|max:20',
            'full_address' => 'sometimes|string',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'city' => 'sometimes|string|max:100',
            'province' => 'sometimes|string|max:100',
            'postal_code' => 'sometimes|string|max:10',
            'is_primary' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // If setting as primary, unset other primary locations
        if ($request->is_primary && !$location->is_primary) {
            Location::where('user_id', Auth::id())
                ->where('id', '!=', $id)
                ->update(['is_primary' => false]);
        }
        
        $location->update($request->all());
        
        return response()->json([
            'message' => 'Lokasi berhasil diperbarui',
            'location' => $location->fresh(),
        ]);
    }

    /**
     * Delete location
     */
    public function destroy($id)
    {
        $location = Location::where('user_id', Auth::id())->findOrFail($id);
        
        // If deleting primary location, set another as primary
        if ($location->is_primary) {
            $otherLocation = Location::where('user_id', Auth::id())
                ->where('id', '!=', $id)
                ->first();
            
            if ($otherLocation) {
                $otherLocation->update(['is_primary' => true]);
            }
        }
        
        $location->delete();
        
        return response()->json([
            'message' => 'Lokasi berhasil dihapus',
        ]);
    }

    /**
     * Set location as primary
     */
    public function setPrimary($id)
    {
        $location = Location::where('user_id', Auth::id())->findOrFail($id);
        
        // Unset other primary locations
        Location::where('user_id', Auth::id())
            ->where('id', '!=', $id)
            ->update(['is_primary' => false]);
        
        $location->update(['is_primary' => true]);
        
        return response()->json([
            'message' => 'Lokasi utama berhasil diubah',
            'location' => $location,
        ]);
    }
}