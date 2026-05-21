<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$shop = \App\Models\Shop::where('slug', 'demo')->first();

if ($shop) {
    $user = \App\Models\User::where('email', 'admin@wistore.com')->first();
    
    if ($user) {
        echo "Usuario admin encontrado" . PHP_EOL;
        echo "Email: " . $user->email . PHP_EOL;
        echo "Shop ID: " . $user->shop_id . PHP_EOL;
        echo "Shop slug: " . $shop->slug . PHP_EOL;
        
        if ($user->shop_id == $shop->id) {
            echo "El usuario está asociado a la tienda demo" . PHP_EOL;
        } else {
            echo "ERROR: El usuario NO está asociado a la tienda demo" . PHP_EOL;
        }
    } else {
        echo "Usuario admin no encontrado" . PHP_EOL;
        
        // Verificar si hay algún usuario
        $anyUser = \App\Models\User::first();
        if ($anyUser) {
            echo "Hay " . \App\Models\User::count() . " usuarios en total" . PHP_EOL;
            echo "Primer usuario: " . $anyUser->email . " (shop_id: " . $anyUser->shop_id . ")" . PHP_EOL;
        } else {
            echo "No hay usuarios en la base de datos" . PHP_EOL;
        }
    }
} else {
    echo "Tienda demo no encontrada" . PHP_EOL;
}