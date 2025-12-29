<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
{
    return Socialite::driver('google')
        ->scopes(['openid', 'email', 'profile']) // HANYA 3 INI SAJA
        ->with(['access_type' => 'offline', 'prompt' => 'consent'])
        ->redirect();
}

public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        // Cari atau buat user
        $user = \App\Models\User::where('google_id', $googleUser->getId())
                    ->orWhere('email', $googleUser->getEmail())
                    ->first();
        
        $isNewUser = false;
        
        if (!$user) {
            // BUAT USER BARU
            $user = \App\Models\User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'phone' => '0812' . rand(100000, 999999),
                'email_verified_at' => now(),
            ]);
            $isNewUser = true;
            
        } else {
            // Update user yang sudah ada
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
            }
            $user->avatar = $googleUser->getAvatar();
            $user->save();
        }
        
        // BUAT ALAMAT OTOMATIS jika user baru
        if ($isNewUser) {
            \App\Models\Location::create([
                'user_id' => $user->id,
                'name' => 'Alamat Utama',
                'recipient_name' => $user->name,
                'recipient_phone' => $user->phone,
                'full_address' => 'Alamat untuk ' . $user->name,
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '10110',
                'is_primary' => true,
            ]);
        }
        
        // Login
        \Illuminate\Support\Facades\Auth::login($user, true);
        
        return redirect()->intended('/')->with('success', 'Login berhasil!');
        Auth::login($user, true);

// Merge cart setelah login
\App\Models\Cart::mergeCarts($user);

return redirect()->intended('/')->with('success', 'Login berhasil!');
        
    } catch (\Exception $e) {
        \Log::error('Google Login Error: ' . $e->getMessage());
        return redirect('/login')->with('error', 'Login gagal: ' . $e->getMessage());
    }
}
    
    /**
     * Membuat alamat otomatis dari data Google
     */
    private function createAutoAddressFromGoogle(User $user, $googleUser)
    {
        // Ekstrak semua data dari Google
        $fullAddress = $this->extractAddressFromGoogle($googleUser);
        $city = $this->extractCityFromGoogle($googleUser);
        $province = $this->extractProvinceFromGoogle($googleUser);
        $postalCode = $this->extractPostalCodeFromGoogle($googleUser);
        $phone = $this->extractPhoneFromGoogle($googleUser);
        
        // Jika tidak ada data alamat dari Google, buat template yang lebih personal
        if (empty($fullAddress)) {
            $fullAddress = "Alamat untuk " . $user->name;
        }
        
        if (empty($city)) {
            $city = $this->detectCityFromEmail($user->email);
        }
        
        if (empty($province)) {
            $province = $this->detectProvinceFromCity($city);
        }
        
        $locationData = [
            'user_id' => $user->id,
            'name' => 'Alamat Utama',
            'recipient_name' => $user->name,
            'recipient_phone' => $phone ?? '0812' . rand(100000, 999999), // Generate random jika tidak ada
            'full_address' => $fullAddress,
            'latitude' => $this->getLatitudeFromCity($city),
            'longitude' => $this->getLongitudeFromCity($city),
            'city' => $city ?? 'Jakarta',
            'province' => $province ?? 'DKI Jakarta',
            'postal_code' => $postalCode ?? '10110',
            'is_primary' => true,
        ];
        
        Location::create($locationData);
        
        \Log::info('Auto address created for user: ' . $user->email, $locationData);
        
        return true;
    }
    
    /**
     * Ekstrak nomor telepon dari data Google
     */
    private function extractPhoneFromGoogle($googleUser)
    {
        // Coba ambil dari berbagai kemungkinan field
        $possibleFields = [
            'phone_number',
            'phone',
            'phoneNumber',
            'mobile',
            'mobile_number',
            'contact_number',
        ];
        
        $userArray = $googleUser->user ?? [];
        
        foreach ($possibleFields as $field) {
            if (!empty($userArray[$field])) {
                return $this->formatPhoneNumber($userArray[$field]);
            }
        }
        
        // Coba dari raw data
        if (isset($googleUser->phone_number)) {
            return $this->formatPhoneNumber($googleUser->phone_number);
        }
        
        return null;
    }
    
    /**
     * Ekstrak alamat lengkap dari Google
     */
    private function extractAddressFromGoogle($googleUser)
    {
        $userArray = $googleUser->user ?? [];
        
        // Coba dari berbagai field alamat
        $addressFields = [
            'address',
            'formatted_address',
            'street_address',
            'location',
            'home_address',
            'work_address',
        ];
        
        foreach ($addressFields as $field) {
            if (!empty($userArray[$field])) {
                if (is_array($userArray[$field])) {
                    return $userArray[$field]['formatted'] ?? implode(', ', $userArray[$field]);
                }
                return $userArray[$field];
            }
        }
        
        // Coba dari address_components
        if (!empty($userArray['addresses']) && is_array($userArray['addresses'])) {
            $primaryAddress = $userArray['addresses'][0] ?? [];
            if (!empty($primaryAddress['formatted'])) {
                return $primaryAddress['formatted'];
            }
        }
        
        return null;
    }
    
    /**
     * Ekstrak kota dari data Google
     */
    private function extractCityFromGoogle($googleUser)
    {
        $userArray = $googleUser->user ?? [];
        
        // Coba dari address_components
        if (!empty($userArray['addresses']) && is_array($userArray['addresses'])) {
            foreach ($userArray['addresses'] as $address) {
                if (!empty($address['locality'])) {
                    return $address['locality'];
                }
            }
        }
        
        // Coba dari locale atau location
        if (!empty($userArray['locale'])) {
            $parts = explode('_', $userArray['locale']);
            if (count($parts) > 1) {
                // Contoh: id_ID -> Jakarta
                if ($parts[1] === 'ID') {
                    return 'Jakarta';
                }
            }
        }
        
        return null;
    }
    
    /**
     * Ekstrak provinsi dari data Google
     */
    private function extractProvinceFromGoogle($googleUser)
    {
        $userArray = $googleUser->user ?? [];
        
        if (!empty($userArray['addresses']) && is_array($userArray['addresses'])) {
            foreach ($userArray['addresses'] as $address) {
                if (!empty($address['region'])) {
                    return $address['region'];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Ekstrak kode pos dari data Google
     */
    private function extractPostalCodeFromGoogle($googleUser)
    {
        $userArray = $googleUser->user ?? [];
        
        if (!empty($userArray['addresses']) && is_array($userArray['addresses'])) {
            foreach ($userArray['addresses'] as $address) {
                if (!empty($address['postal_code'])) {
                    return $address['postal_code'];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Deteksi kota dari email (jika email mengandung clue)
     */
    private function detectCityFromEmail($email)
    {
        $email = strtolower($email);
        
        $cityPatterns = [
            'jakarta' => 'Jakarta',
            'jkt' => 'Jakarta',
            'bandung' => 'Bandung',
            'bdg' => 'Bandung',
            'surabaya' => 'Surabaya',
            'sby' => 'Surabaya',
            'yogyakarta' => 'Yogyakarta',
            'jogja' => 'Yogyakarta',
            'semarang' => 'Semarang',
            'smg' => 'Semarang',
            'medan' => 'Medan',
            'makassar' => 'Makassar',
            'mks' => 'Makassar',
            'bali' => 'Denpasar',
            'denpasar' => 'Denpasar',
        ];
        
        foreach ($cityPatterns as $pattern => $city) {
            if (strpos($email, $pattern) !== false) {
                return $city;
            }
        }
        
        return 'Jakarta'; // Default
    }
    
    /**
     * Deteksi provinsi berdasarkan kota
     */
    private function detectProvinceFromCity($city)
    {
        $cityToProvince = [
            'Jakarta' => 'DKI Jakarta',
            'Bandung' => 'Jawa Barat',
            'Surabaya' => 'Jawa Timur',
            'Yogyakarta' => 'DI Yogyakarta',
            'Semarang' => 'Jawa Tengah',
            'Medan' => 'Sumatera Utara',
            'Makassar' => 'Sulawesi Selatan',
            'Denpasar' => 'Bali',
        ];
        
        return $cityToProvince[$city] ?? 'DKI Jakarta';
    }
    
    /**
     * Get latitude berdasarkan kota
     */
    private function getLatitudeFromCity($city)
    {
        $cityCoordinates = [
            'Jakarta' => -6.2088,
            'Bandung' => -6.9175,
            'Surabaya' => -7.2575,
            'Yogyakarta' => -7.7956,
            'Semarang' => -6.9667,
            'Medan' => 3.5952,
            'Makassar' => -5.1477,
            'Denpasar' => -8.6705,
        ];
        
        return $cityCoordinates[$city] ?? -6.2088;
    }
    
    /**
     * Get longitude berdasarkan kota
     */
    private function getLongitudeFromCity($city)
    {
        $cityCoordinates = [
            'Jakarta' => 106.8456,
            'Bandung' => 107.6191,
            'Surabaya' => 112.7521,
            'Yogyakarta' => 110.3695,
            'Semarang' => 110.4167,
            'Medan' => 98.6722,
            'Makassar' => 119.4327,
            'Denpasar' => 115.2126,
        ];
        
        return $cityCoordinates[$city] ?? 106.8456;
    }
    
    /**
     * Format nomor telepon ke format Indonesia
     */
    private function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // Jika panjangnya 10-13 digit, anggap sudah benar
        if (strlen($phone) >= 10 && strlen($phone) <= 13) {
            return $phone;
        }
        
        return null;
    }
}