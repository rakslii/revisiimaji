<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
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

    /**
     * Display a listing of banners.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'home');
        
        $banners = Banner::orderBy('display_order')->orderBy('created_at', 'desc')->get();
        $homeBanners = $banners->where('type', 'home_banner');
        $popups = $banners->where('type', 'popup');
        
        return view('pages.admin.settings.banners.index', compact('banners', 'homeBanners', 'popups', 'tab'));
    }

    /**
     * Show the form for creating a new banner.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'home_banner');
        return view('pages.admin.settings.banners.create', compact('type'));
    }

    /**
     * Store a newly created banner in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:50',
            'type' => 'required|in:home_banner,popup',
            'position' => 'required_if:type,popup|in:center,top,bottom,left,right',
            'size' => 'required_if:type,popup|in:small,medium,large,full',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'show_once_per_session' => 'nullable|boolean',
            'delay_seconds' => 'nullable|integer|min:0|max:60',
            'show_close_button' => 'nullable|boolean',
            'show_on_mobile' => 'nullable|boolean',
            'show_on_tablet' => 'nullable|boolean',
            'show_on_desktop' => 'nullable|boolean',
            'background_color' => 'nullable|string|max:20',
            'background_opacity' => 'nullable|integer|min:0|max:100',
        ];

        // Validate for popup type
        if ($request->type == 'popup') {
            $rules['position'] = 'required|in:center,top,bottom,left,right';
            $rules['size'] = 'required|in:small,medium,large,full';
        }

        $validated = $request->validate($rules);

        // Handle checkbox boolean
        $validated['is_active'] = $request->has('is_active');
        $validated['show_once_per_session'] = $request->has('show_once_per_session');
        $validated['show_close_button'] = $request->has('show_close_button');
        $validated['show_on_mobile'] = $request->has('show_on_mobile');
        $validated['show_on_tablet'] = $request->has('show_on_tablet');
        $validated['show_on_desktop'] = $request->has('show_on_desktop');

        // Upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $validated['image'] = $path;
        }

        // Upload mobile image
        if ($request->hasFile('mobile_image')) {
            $path = $request->file('mobile_image')->store('banners/mobile', 'public');
            $validated['mobile_image'] = $path;
        }

        // Set default display order if not provided
        if (empty($validated['display_order'])) {
            $validated['display_order'] = Banner::where('type', $request->type)->max('display_order') + 1;
        }

        Banner::create($validated);

        return redirect()->route('admin.settings.banners.index', ['tab' => $request->type == 'home_banner' ? 'home' : 'popup'])
            ->with('success', 'Banner created successfully.');
    }

    /**
     * Show the form for editing the specified banner.
     */
    public function edit(Banner $banner)
    {
        return view('pages.admin.settings.banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:50',
            'position' => 'nullable|in:center,top,bottom,left,right',
            'size' => 'nullable|in:small,medium,large,full',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'show_once_per_session' => 'nullable|boolean',
            'delay_seconds' => 'nullable|integer|min:0|max:60',
            'show_close_button' => 'nullable|boolean',
            'show_on_mobile' => 'nullable|boolean',
            'show_on_tablet' => 'nullable|boolean',
            'show_on_desktop' => 'nullable|boolean',
            'background_color' => 'nullable|string|max:20',
            'background_opacity' => 'nullable|integer|min:0|max:100',
        ];

        $validated = $request->validate($rules);

        // Handle checkbox boolean
        $validated['is_active'] = $request->has('is_active');
        $validated['show_once_per_session'] = $request->has('show_once_per_session');
        $validated['show_close_button'] = $request->has('show_close_button');
        $validated['show_on_mobile'] = $request->has('show_on_mobile');
        $validated['show_on_tablet'] = $request->has('show_on_tablet');
        $validated['show_on_desktop'] = $request->has('show_on_desktop');

        // Upload new image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $path = $request->file('image')->store('banners', 'public');
            $validated['image'] = $path;
        }

        // Upload new mobile image
        if ($request->hasFile('mobile_image')) {
            // Delete old mobile image
            if ($banner->mobile_image) {
                Storage::disk('public')->delete($banner->mobile_image);
            }
            $path = $request->file('mobile_image')->store('banners/mobile', 'public');
            $validated['mobile_image'] = $path;
        }

        $banner->update($validated);

        return redirect()->route('admin.settings.banners.index', ['tab' => $banner->type == 'home_banner' ? 'home' : 'popup'])
            ->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified banner from storage.
     */
    public function destroy(Banner $banner)
    {
        // Delete images
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        if ($banner->mobile_image) {
            Storage::disk('public')->delete($banner->mobile_image);
        }

        $banner->delete();

        return redirect()->route('admin.settings.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    /**
     * Update banner display order (for drag & drop)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer|exists:banners,id'
        ]);

        foreach ($request->orders as $index => $id) {
            Banner::where('id', $id)->update(['display_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle banner active status
     */
    public function toggleActive(Banner $banner)
    {
        $banner->is_active = !$banner->is_active;
        $banner->save();

        return response()->json([
            'success' => true,
            'is_active' => $banner->is_active,
            'message' => 'Banner status updated successfully.'
        ]);
    }

    /**
     * Get banner statistics
     */
    public function statistics(Banner $banner)
    {
        return response()->json([
            'views' => $banner->views_count,
            'clicks' => $banner->clicks_count,
            'ctr' => $banner->views_count > 0 
                ? round(($banner->clicks_count / $banner->views_count) * 100, 2) 
                : 0
        ]);
    }
}