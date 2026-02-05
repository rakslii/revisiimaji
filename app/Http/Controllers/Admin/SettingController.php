<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnlineStore;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingController extends Controller
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
     * Display settings index page with menu
     */
    public function index()
    {
        return view('pages.admin.settings.index');
    }

    // ==================== ADMIN USERS ====================
    
    /**
     * Display admin users list
     */
public function adminUsers(Request $request)
{
    // Tampilkan semua user dengan role admin ATAU staff
    $users = User::whereIn('role', ['admin', 'staff'])
        ->orderBy('role', 'asc') // Admin dulu, kemudian staff
        ->orderBy('name', 'asc')
        ->paginate(10);
        
    return view('pages.admin.settings.admin-users.index', compact('users'));
}

    /**
     * Show create admin user form
     */
    public function createAdminUser()
    {
        return view('pages.admin.settings.admin-users.create');
    }

    /**
     * Store new admin user
     */
    public function storeAdminUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'admin',
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.settings.admin-users.index')
            ->with('success', 'Admin user created successfully.');
    }

    /**
     * Show edit admin user form
     */
    public function editAdminUser($id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        return view('pages.admin.settings.admin-users.edit', compact('user'));
    }

    /**
     * Update admin user
     */
    public function updateAdminUser(Request $request, $id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $validated['status'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.settings.admin-users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    /**
     * Delete admin user
     */
    public function destroyAdminUser($id)
    {
        $user = User::where('role', 'admin')->findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();

        return redirect()->route('admin.settings.admin-users.index')
            ->with('success', 'Admin user deleted successfully.');
    }

    // ==================== ONLINE STORES ====================
    
    /**
     * Display online stores list
     */
// Update method onlineStores di SettingController:

/**
 * Display online stores list
 */
public function onlineStores(Request $request)
{
    $query = OnlineStore::query();
    
    // Filter by status
    if ($request->filter === 'active') {
        $query->where('is_active', true);
    }
    
    // Filter by platform
    if (in_array($request->filter, ['ecommerce', 'social_media', 'marketplace'])) {
        $query->where('platform', $request->filter);
    }
    
    $stores = $query->orderBy('order')
                    ->orderBy('name')
                    ->paginate(12);
                    
    return view('pages.admin.settings.online-stores.index', compact('stores'));
}

    /**
     * Show create online store form
     */
    public function createOnlineStore()
    {
        return view('pages.admin.settings.online-stores.create');
    }

    /**
     * Store new online store
     */
    public function storeOnlineStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'platform' => 'required|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $storeData = [
            'name' => $validated['name'],
            'url' => $validated['url'],
            'platform' => $validated['platform'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('online-stores', 'public');
            $storeData['logo'] = $path;
        }

        OnlineStore::create($storeData);

        return redirect()->route('admin.settings.online-stores.index')
            ->with('success', 'Online store created successfully.');
    }

    /**
     * Show edit online store form
     */
    public function editOnlineStore($id)
    {
        $store = OnlineStore::findOrFail($id);
        return view('pages.admin.settings.online-stores.edit', compact('store'));
    }

    /**
     * Update online store
     */
    public function updateOnlineStore(Request $request, $id)
    {
        $store = OnlineStore::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'platform' => 'required|string|max:100',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $storeData = [
            'name' => $validated['name'],
            'url' => $validated['url'],
            'platform' => $validated['platform'],
            'description' => $validated['description'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            
            $path = $request->file('logo')->store('online-stores', 'public');
            $storeData['logo'] = $path;
        }

        $store->update($storeData);

        return redirect()->route('admin.settings.online-stores.index')
            ->with('success', 'Online store updated successfully.');
    }

    /**
     * Delete online store
     */
    public function destroyOnlineStore($id)
    {
        $store = OnlineStore::findOrFail($id);
        
        // Delete logo if exists
        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }
        
        $store->delete();

        return redirect()->route('admin.settings.online-stores.index')
            ->with('success', 'Online store deleted successfully.');
    }

    // ==================== GENERAL SETTINGS ====================
    
    /**
     * Display general settings
     */
    public function generalSettings()
    {
        // Get all general settings
        $settings = AdminSetting::where('group', 'general')->get();
        
        // Create array of key-value pairs
        $settingValues = [];
        foreach ($settings as $setting) {
            $settingValues[$setting->key] = $setting->value;
        }
        
        return view('pages.admin.settings.general.index', compact('settingValues'));
    }

    /**
     * Update general settings
     */
    public function updateGeneralSettings(Request $request)
    {
        $settings = [
            'site_name' => ['required', 'string', 'max:255'],
            'site_email' => ['required', 'email', 'max:255'],
            'site_phone' => ['required', 'string', 'max:20'],
            'site_address' => ['nullable', 'string'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'whatsapp_message' => ['nullable', 'string'],
            'currency' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', 'max:50'],
            'maintenance_mode' => ['boolean'],
        ];

        $validated = $request->validate($settings);

        foreach ($validated as $key => $value) {
            AdminSetting::setValue($key, $value, 'string', 'general');
        }

        return redirect()->route('admin.settings.general.index')
            ->with('success', 'General settings updated successfully.');
    }

    // ==================== ABOUT US (SIMPLE VERSION) ====================
    
    /**
     * Display about us settings
     */
    public function aboutUs()
    {
        return view('pages.admin.settings.about-us.index');
    }

    // ==================== BANNERS (SIMPLE VERSION) ====================
    
    /**
     * Display banners settings
     */
    public function banners()
    {
        return view('pages.admin.settings.banners.index');
    }

    // ==================== CONSULTATIONS (SIMPLE VERSION) ====================
    
    /**
     * Display consultation settings
     */
    public function consultations()
    {
        return view('pages.admin.settings.consultations.index');
    }

    // ==================== PAYMENT SETTINGS (SIMPLE VERSION) ====================
    
    /**
     * Display payment settings
     */
    public function paymentSettings()
    {
        return view('pages.admin.settings.payments.index');
    }

    // ==================== SHIPPING SETTINGS (SIMPLE VERSION) ====================
    
    /**
     * Display shipping settings
     */
    public function shippingSettings()
    {
        return view('pages.admin.settings.shippings.index');
    }
    
}