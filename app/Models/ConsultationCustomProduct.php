<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationCustomProduct extends Model
{
    protected $table = 'consultation_custom_products';
    
    protected $fillable = [
        'phone_number',
        'display_text',
        'message_template',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getWhatsAppUrl($customProductName, $customerData = [])
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        $url = "https://wa.me/{$phone}";
        
        if ($this->message_template) {
            $message = $this->message_template;
            $message = str_replace('[PRODUCT_NAME]', $customProductName, $message);
            
            foreach ($customerData as $key => $value) {
                $message = str_replace('[' . strtoupper($key) . ']', $value, $message);
            }
            
            $url .= "?text=" . urlencode($message);
        }
        
        return $url;
    }
}