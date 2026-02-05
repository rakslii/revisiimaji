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
    // ==================== ONLINE STORES ====================
    
    /**
     * Display online stores list
     */
// Update method onlineStores di SettingController:
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