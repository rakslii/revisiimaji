<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OnlineStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = OnlineStore::query();
    
    // Filter by status
    if ($request->has('status') && in_array($request->status, ['active', 'inactive'])) {
        $query->where('is_active', $request->status === 'active');
    }
    
    // Filter by platform
    if ($request->has('platform') && in_array($request->platform, ['ecommerce', 'social_media', 'marketplace'])) {
        $query->where('platform', $request->platform);
    }
    
    // Search
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('url', 'like', "%{$search}%");
        });
    }
    
    // Ordering
    $query->orderBy('order')
          ->orderBy('created_at', 'desc');
    
    $stores = $query->paginate(12);
    
    // Platform options for filter
    $platformOptions = [
        'ecommerce' => 'E-commerce',
        'social_media' => 'Social Media',
        'marketplace' => 'Marketplace'
    ];
    
    // Stats data
    $stats = [
        'total' => OnlineStore::count(),
        'active' => OnlineStore::where('is_active', true)->count(),
        'inactive' => OnlineStore::where('is_active', false)->count(),
    ];
    
    return view('pages.admin.settings.online-stores.index', compact('stores', 'platformOptions', 'stats'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platforms = [
            'ecommerce' => 'E-commerce (Shopee, Tokopedia, etc)',
            'social_media' => 'Social Media (Instagram, Facebook, etc)',
            'marketplace' => 'Marketplace (Bukalapak, Lazada, etc)'
        ];
        
        // Default color presets
        $colorPresets = [
            ['#FF6B6B', '#FFE66D', 'fab fa-shopify', '#FF6B6B'], // Red-Yellow
            ['#4ECDC4', '#45B7D1', 'fas fa-store', '#4ECDC4'], // Cyan
            ['#96CEB4', '#FFEAA7', 'fab fa-amazon', '#96CEB4'], // Green-Yellow
            ['#FF9A8B', '#FF6A88', 'fab fa-shopee', '#FF6A88'], // Pink
            ['#A8E6CF', '#DCEDC1', 'fas fa-shopping-cart', '#A8E6CF'], // Mint
            ['#FFAAA5', '#FF8B94', 'fab fa-tokopedia', '#FFAAA5'], // Coral
            ['#B5EAD7', '#C7CEEA', 'fas fa-shopping-bag', '#B5EAD7'], // Pastel
            ['#FFDAC1', '#E2F0CB', 'fab fa-blender', '#FFDAC1'], // Peach
        ];
        
        $iconOptions = [
            'fas fa-store' => 'Store (Default)',
            'fas fa-shopping-cart' => 'Shopping Cart',
            'fas fa-shopping-bag' => 'Shopping Bag',
            'fas fa-box' => 'Package',
            'fas fa-tags' => 'Tags',
            'fas fa-store-alt' => 'Store Alt',
            'fab fa-shopify' => 'Shopify',
            'fab fa-amazon' => 'Amazon',
            'fab fa-ebay' => 'eBay',
            'fab fa-alibaba' => 'Alibaba',
            'fab fa-shopee' => 'Shopee',
            'fab fa-tokopedia' => 'Tokopedia',
            'fab fa-blibli' => 'Blibli',
            'fab fa-bukalapak' => 'Bukalapak',
            'fab fa-lazada' => 'Lazada',
            'fab fa-instagram' => 'Instagram',
            'fab fa-facebook' => 'Facebook',
            'fab fa-whatsapp' => 'WhatsApp',
            'fab fa-twitter' => 'Twitter',
            'fab fa-tiktok' => 'TikTok',
            'fab fa-youtube' => 'YouTube',
            'fab fa-linkedin' => 'LinkedIn',
            'fab fa-pinterest' => 'Pinterest',
        ];
        
        return view('pages.admin.settings.online-stores.create', compact('platforms', 'colorPresets', 'iconOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'platform' => 'required|in:ecommerce,social_media,marketplace',
            'description' => 'nullable|string|max:500',
            'icon_class' => 'required|string|max:50',
            'color' => 'required|string|max:7|starts_with:#',
            'gradient_from' => 'required|string|max:7|starts_with:#',
            'gradient_to' => 'required|string|max:7|starts_with:#',
            'store_username' => 'nullable|string|max:100',
            'store_id' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $storeData = $validator->validated();
            $storeData['is_active'] = $request->boolean('is_active');
            $storeData['order'] = $request->order ?? 0;
            
            // Auto-generate slug if not provided
            if (empty($storeData['slug'])) {
                $storeData['slug'] = Str::slug($storeData['name']);
            }
            
            OnlineStore::create($storeData);
            
            return redirect()->route('admin.settings.online-stores.index')
                ->with('success', 'Online store created successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create online store: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $store = OnlineStore::findOrFail($id);
        return view('pages.admin.settings.online-stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $store = OnlineStore::findOrFail($id);
        
        $platforms = [
            'ecommerce' => 'E-commerce (Shopee, Tokopedia, etc)',
            'social_media' => 'Social Media (Instagram, Facebook, etc)',
            'marketplace' => 'Marketplace (Bukalapak, Lazada, etc)'
        ];
        
        $colorPresets = [
            ['#FF6B6B', '#FFE66D', 'fab fa-shopify', '#FF6B6B'],
            ['#4ECDC4', '#45B7D1', 'fas fa-store', '#4ECDC4'],
            ['#96CEB4', '#FFEAA7', 'fab fa-amazon', '#96CEB4'],
            ['#FF9A8B', '#FF6A88', 'fab fa-shopee', '#FF6A88'],
            ['#A8E6CF', '#DCEDC1', 'fas fa-shopping-cart', '#A8E6CF'],
            ['#FFAAA5', '#FF8B94', 'fab fa-tokopedia', '#FFAAA5'],
            ['#B5EAD7', '#C7CEEA', 'fas fa-shopping-bag', '#B5EAD7'],
            ['#FFDAC1', '#E2F0CB', 'fab fa-blender', '#FFDAC1'],
        ];
        
        $iconOptions = [
            'fas fa-store' => 'Store (Default)',
            'fas fa-shopping-cart' => 'Shopping Cart',
            'fas fa-shopping-bag' => 'Shopping Bag',
            'fas fa-box' => 'Package',
            'fas fa-tags' => 'Tags',
            'fas fa-store-alt' => 'Store Alt',
            'fab fa-shopify' => 'Shopify',
            'fab fa-amazon' => 'Amazon',
            'fab fa-ebay' => 'eBay',
            'fab fa-alibaba' => 'Alibaba',
            'fab fa-shopee' => 'Shopee',
            'fab fa-tokopedia' => 'Tokopedia',
            'fab fa-blibli' => 'Blibli',
            'fab fa-bukalapak' => 'Bukalapak',
            'fab fa-lazada' => 'Lazada',
            'fab fa-instagram' => 'Instagram',
            'fab fa-facebook' => 'Facebook',
            'fab fa-whatsapp' => 'WhatsApp',
            'fab fa-twitter' => 'Twitter',
            'fab fa-tiktok' => 'TikTok',
            'fab fa-youtube' => 'YouTube',
            'fab fa-linkedin' => 'LinkedIn',
            'fab fa-pinterest' => 'Pinterest',
        ];
        
        return view('pages.admin.settings.online-stores.edit', compact('store', 'platforms', 'colorPresets', 'iconOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $store = OnlineStore::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'platform' => 'required|in:ecommerce,social_media,marketplace',
            'description' => 'nullable|string|max:500',
            'icon_class' => 'required|string|max:50',
            'color' => 'required|string|max:7|starts_with:#',
            'gradient_from' => 'required|string|max:7|starts_with:#',
            'gradient_to' => 'required|string|max:7|starts_with:#',
            'store_username' => 'nullable|string|max:100',
            'store_id' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $storeData = $validator->validated();
            $storeData['is_active'] = $request->boolean('is_active');
            $storeData['order'] = $request->order ?? 0;
            
            // Update slug if name changed
            if ($store->name !== $storeData['name']) {
                $storeData['slug'] = Str::slug($storeData['name']);
            }
            
            $store->update($storeData);
            
            return redirect()->route('admin.settings.online-stores.index')
                ->with('success', 'Online store updated successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update online store: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $store = OnlineStore::findOrFail($id);
        
        try {
            $store->delete();
            
            return redirect()->route('admin.settings.online-stores.index')
                ->with('success', 'Online store deleted successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete online store: ' . $e->getMessage());
        }
    }

    /**
     * Toggle store status
     */
    public function toggleStatus($id)
    {
        $store = OnlineStore::findOrFail($id);
        
        try {
            $store->update([
                'is_active' => !$store->is_active
            ]);
            
            $status = $store->is_active ? 'activated' : 'deactivated';
            
            return redirect()->back()
                ->with('success', "Online store {$status} successfully.");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to toggle status: ' . $e->getMessage());
        }
    }

    /**
     * Update store order (for drag & drop)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'stores' => 'required|array',
            'stores.*.id' => 'required|exists:online_stores,id',
            'stores.*.order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->stores as $item) {
                OnlineStore::where('id', $item['id'])->update(['order' => $item['order']]);
            }
            
            return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update order.'], 500);
        }
    }

    /**
     * Reorder stores
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:online_stores,id',
            'direction' => 'required|in:up,down',
        ]);

        $store = OnlineStore::findOrFail($validated['id']);
        $currentOrder = $store->order;

        if ($validated['direction'] === 'up') {
            // Move up (decrease order)
            $previousStore = OnlineStore::where('order', '<', $currentOrder)
                ->orderBy('order', 'desc')
                ->first();
            
            if ($previousStore) {
                $store->update(['order' => $previousStore->order]);
                $previousStore->update(['order' => $currentOrder]);
            }
        } else {
            // Move down (increase order)
            $nextStore = OnlineStore::where('order', '>', $currentOrder)
                ->orderBy('order', 'asc')
                ->first();
            
            if ($nextStore) {
                $store->update(['order' => $nextStore->order]);
                $nextStore->update(['order' => $currentOrder]);
            }
        }

        return redirect()->back()
            ->with('success', 'Store order updated successfully.');
    }
}