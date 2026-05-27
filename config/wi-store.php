<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Soporte WI-Store (plataforma)
    |--------------------------------------------------------------------------
    */
    'support_email' => env('WI_STORE_SUPPORT_EMAIL', env('WISTORE_SUPPORT_EMAIL', 'support@wi-store.com')),

    'support_name' => env('WI_STORE_SUPPORT_NAME', env('WISTORE_SUPPORT_NAME', 'Soporte WI-Store')),

    /*
    |--------------------------------------------------------------------------
    | Prueba gratuita (Plan Negocio / Premium)
    |--------------------------------------------------------------------------
    */
    'trial_days' => (int) env('WI_STORE_TRIAL_DAYS', 14),

];
