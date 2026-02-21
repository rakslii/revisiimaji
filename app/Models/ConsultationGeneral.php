<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationGeneral extends Model
{
    protected $table = 'consultation_general';
    
    protected $fillable = [
        'phone_number',
        'display_text',
        'message_template',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function getWhatsAppUrl($customerName = null)
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        $url = "https://wa.me/{$phone}";
        
        if ($this->message_template) {
            $message = $this->message_template;
            if ($customerName) {
                $message = str_replace('[NAME]', $customerName, $message);
            }
            $url .= "?text=" . urlencode($message);
        }
        
        return $url;
    }
}