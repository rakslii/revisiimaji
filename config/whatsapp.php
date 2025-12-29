<?php

return [
    'admin_number' => env('WHATSAPP_ADMIN', '6283879045071'),
    'template' => env('WHATSAPP_TEMPLATE', 'Halo Admin, ada order baru dari %nama% dengan ID %order_id%'),
    
    'order_template' => [
        'new_order' => "🚀 *ORDER BARU CiptaImaji* 🚀\n\n" .
                      "📦 Order ID: %order_id%\n" .
                      "👤 Customer: %customer_name%\n" .
                      "📱 Phone: %customer_phone%\n" .
                      "📍 Lokasi: %customer_location%\n\n" .
                      "🛒 Items:\n%items%\n\n" .
                      "💰 Total: Rp %total_amount%\n" .
                      "💳 Status: %payment_status%\n\n" .
                      "Segera proses order ini!",
    ],
];