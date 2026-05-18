<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShortLink;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Tienda de prueba YS Detallitos con colores HEX de marca
        $shop = Shop::create([
            'name' => 'YS Detallitos',
            'slug' => 'ys-detallitos',
            'whatsapp_number' => '584120000000',
            'description' => 'Tu tienda de detalles y regalos personalizados en Valencia.',
            'address' => 'Valencia, Carabobo, Venezuela',
            'payment_methods' => 'Pago Móvil, Zelle, Efectivo',
            'logo_path' => 'https://ui-avatars.com/api/?name=YS+Detallitos&background=E60067&color=fff&size=120',
            'cover_path' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1200',
            'color_primary' => '#E60067',
            'color_secondary' => '#C6A100',
            'color_background' => '#FFF0F8',
            'exchange_rate' => 'Bs. 515.18',
            'exchange_updated_at' => date('d/m/Y h:i A'),
        ]);

        // Registrar la tienda en config temporalmente para pasar la validación del Scope durante el seeding
        config(['current_shop_id' => $shop->id]);

        // 2. Crear Administrador vinculado
        User::create([
            'shop_id' => $shop->id,
            'name' => 'Admin YS Detallitos',
            'email' => 'admin@ysdetallitos.com',
            'password' => bcrypt('password123'),
        ]);

        // 3. Crear Categorías
        $category1 = Category::create([
            'shop_id' => $shop->id,
            'name' => 'Globos y Arreglos',
            'slug' => 'globos-y-arreglos',
            'status' => true,
        ]);

        $category2 = Category::create([
            'shop_id' => $shop->id,
            'name' => 'Tazas Personalizadas',
            'slug' => 'tazas-personalizadas',
            'status' => true,
        ]);

        // 4. Crear Productos
        Product::create([
            'shop_id' => $shop->id,
            'category_id' => $category1->id,
            'name' => 'Arreglo Globos Premium',
            'description' => 'Hermoso arreglo con globos metalizados, dulces variados y tarjeta de dedicatoria.',
            'price' => 25.00,
            'image_path' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?q=80&w=600',
            'is_available' => true,
        ]);

        Product::create([
            'shop_id' => $shop->id,
            'category_id' => $category1->id,
            'name' => 'Bouquet de Rosas y Chocolates',
            'description' => 'Caja decorada con 12 rosas rojas frescas y chocolates Ferrero Rocher.',
            'price' => 35.00,
            'image_path' => 'https://images.unsplash.com/photo-1548849186-e997d4f4e731?q=80&w=600',
            'is_available' => true,
        ]);

        Product::create([
            'shop_id' => $shop->id,
            'category_id' => $category2->id,
            'name' => 'Taza Amor Infinito',
            'description' => 'Taza de cerámica sublimada de alta calidad con designs exclusivos de amor.',
            'price' => 8.50,
            'image_path' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=600',
            'is_available' => true,
        ]);

        Product::create([
            'shop_id' => $shop->id,
            'category_id' => $category2->id,
            'name' => 'Taza Mágica Sorpresa',
            'description' => 'Taza que cambia de color y revela la foto personalizada al verter líquido caliente.',
            'price' => 12.00,
            'image_path' => 'https://images.unsplash.com/photo-1577937927133-66ef06acdf18?q=80&w=600',
            'is_available' => true,
        ]);

        // 5. Crear Enlaces Cortos (Acortador de Links)
        ShortLink::create([
            'shop_id' => $shop->id,
            'code' => 'ys',
            'destination_url' => 'http://127.0.0.1:8000/ys-detallitos',
            'clicks_count' => 0,
        ]);

        ShortLink::create([
            'shop_id' => $shop->id,
            'code' => 'ys-valencia',
            'destination_url' => 'http://127.0.0.1:8000/ys-detallitos',
            'clicks_count' => 0,
        ]);
    }
}
