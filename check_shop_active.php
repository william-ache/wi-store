<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$shop = \App\Models\Shop::where('slug', 'demo')->first();

if ($shop) {
    echo "Tienda: " . $shop->name . PHP_EOL;
    echo "Slug: " . $shop->slug . PHP_EOL;
    echo "is_active: " . ($shop->is_active ? 'true' : 'false') . PHP_EOL;
    echo "shop_category: " . ($shop->shop_category ?? 'null') . PHP_EOL;
    echo "shop_category_icon: " . ($shop->shop_category_icon ?? 'null') . PHP_EOL;
} else {
    echo "Tienda demo no encontrada" . PHP_EOL;
}