<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationProduct extends Model
{
    protected $table = 'consultation_products';
    
    protected $fillable = [
        'phone_number',
        'display_text',
        'message_template',
        'include_product_url',
        'is_active'
    ];

    protected $casts = [
        'include_product_url' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function getWhatsAppUrl($product, $customerName = null)
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        $url = "https://wa.me/{$phone}";
        
        if ($this->message_template) {
            $message = $this->message_template;
            
            // Replace variables
            $replaces = [
                '[PRODUCT_NAME]' => $product->name,
                '[PRODUCT_URL]' => $this->include_product_url ? url('/products/' . $product->id) : '',
                '[CUSTOMER_NAME]' => $customerName ?? 'Pelanggan'
            ];
            
            foreach ($replaces as $key => $value) {
                $message = str_replace($key, $value, $message);
            }
            
            $url .= "?text=" . urlencode($message);
        }
        
        return $url;
    }
}