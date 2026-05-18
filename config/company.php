<?php

return [
    'name' => env('COMPANY_NAME', 'Mi Empresa'),
    'logo' => env('COMPANY_LOGO', 'assets/images/default-logo.png'),
    'cover' => env('COMPANY_COVER', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200'),
    'exchange_rate' => env('COMPANY_EXCHANGE_RATE', 'Bs. 515.18'),
    'exchange_updated_at' => env('COMPANY_EXCHANGE_UPDATED_AT', date('d/m/Y h:i A')),
    'colors' => [
        'primary' => env('COMPANY_PRIMARY_COLOR', '#FF1493'),
        'secondary' => env('COMPANY_SECONDARY_COLOR', '#1A1A1A'),
    ],
    'description' => env('COMPANY_DESCRIPTION', ''),
    'address' => env('COMPANY_ADDRESS', ''),
    'whatsapp' => env('COMPANY_WHATSAPP', ''),
    'payment_methods' => env('COMPANY_PAYMENT_METHODS', ''),
];
