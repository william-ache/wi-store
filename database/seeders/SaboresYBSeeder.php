<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaboresYBSeeder extends Seeder
{
    public function run(): void
    {
        $slug = 'sabores-yb';

        $shop = Shop::where('slug', $slug)->first();

        if (!$shop) {
            $shop = Shop::create([
                'name' => 'Sabores Y&B',
                'slug' => $slug,
                'shop_category' => 'gastronomia',
                'shop_category_icon' => '🍽️',
                'whatsapp_number' => '584121305420',
                'description' => 'Empanadas artesanales y más. Pide en línea y recibe en tu puerta.',
                'address' => 'Margarita, Venezuela',
                'color_primary' => '#E60067',
                'color_secondary' => '#C6A100',
                'color_background' => '#FFF0F8',
                'exchange_rate' => 'Bs. 515.18',
                'plan' => 'standard',
                'billing_cycle' => 'mensual',
                'plan_expires_at' => now()->addYear(),
                'last_payment_date' => now(),
                'last_payment_amount' => 14.99,
                'is_active' => true,
                'has_dine_in' => true,
                'has_pickup' => true,
                'has_delivery' => true,
            ]);
            $this->command->info("Tienda creada: {$shop->name} (slug: {$shop->slug})");
        } else {
            $shop->update([
                'name' => 'Sabores Y&B',
                'is_active' => true,
            ]);
            $this->command->info("Tienda existente actualizada: {$shop->name}");
        }

        $user = User::where('email', 'sabores.yb20@gmail.com')->first();

        if (!$user) {
            User::create([
                'shop_id' => $shop->id,
                'name' => 'Administrador Sabores Y&B',
                'email' => 'sabores.yb20@gmail.com',
                'password' => 'sabores.yb20',
                'temp_password' => 'sabores.yb20',
            ]);
            $this->command->info('Usuario admin creado: sabores.yb20@gmail.com');
        } else {
            $user->update([
                'shop_id' => $shop->id,
                'password' => 'sabores.yb20',
                'temp_password' => 'sabores.yb20',
            ]);
            $this->command->info('Usuario admin actualizado: sabores.yb20@gmail.com');
        }

        $categories = [
            [
                'name' => 'Empanadas clásicas',
                'slug' => 'empanadas-clasicas',
                'icon' => 'fa-fire',
                'color' => '#10B981',
                'products' => [
                    ['name' => 'Carne Molida', 'price' => 1.50, 'description' => 'Empanada de carne molida sazonada con sofrito, comino y achiote. Relleno jugoso y tradicional.'],
                    ['name' => 'Pollo', 'price' => 1.50, 'description' => 'Pollo desmechado guisado con cebolla, pimentón y aliños criollos. Suave y lleno de sabor.'],
                    ['name' => 'Queso Llanero', 'price' => 1.20, 'description' => 'Rellena de queso llanero derretido. Cremosa por dentro y crujiente en la masa.'],
                    ['name' => 'Carne Mechada', 'price' => 1.80, 'description' => 'Carne de res mechada y guisada a fuego lento. El sabor clásico de la empanada venezolana.'],
                    ['name' => 'Macabi (Pescado)', 'price' => 2.00, 'description' => 'Relleno de pescado macabi guisado al estilo oriental. Fresco, sabroso y típico de la costa.'],
                    ['name' => 'Jamón y Queso', 'price' => 1.60, 'description' => 'Jamón cocido con queso blanco derretido. Un clásico que nunca falla.'],
                    ['name' => 'Guiso Navideño', 'price' => 1.50, 'description' => 'Relleno de guiso navideño: mezcla de carnes, pollo y garbanzos en su punto, como en diciembre.'],
                    ['name' => 'Pabellón', 'price' => 2.50, 'description' => 'Pabellón en empanada: carne mechada, caraotas negras, tajada madura y queso. Sabor margariteño completo.'],
                ],
            ],
            [
                'name' => 'Empanadas especiales',
                'slug' => 'empanadas-especiales',
                'icon' => 'fa-star',
                'color' => '#EF4444',
                'products' => [
                    ['name' => 'Carne Mechada con Queso', 'price' => 1.80, 'description' => 'Carne mechada guisada con capa generosa de queso derretido. Conocida como la Pelúa.'],
                    ['name' => 'Carne Molida con Queso', 'price' => 1.80, 'description' => 'Carne molida sazonada combinada con queso blanco fundido. Relleno abundante y equilibrado.'],
                    ['name' => 'Pollo con Queso', 'price' => 1.80, 'description' => 'Pollo guisado mezclado con queso derretido. La Catira: dulce combinación de sabores criollos.'],
                    ['name' => 'Gordon Blue de Carne Mechada', 'price' => 1.80, 'description' => 'Carne mechada envuelta en jamón y queso al estilo cordon bleu. Crujiente por fuera, cremosa por dentro.'],
                    ['name' => 'Gordon Blue de Pollo', 'price' => 1.80, 'description' => 'Pollo guisado con jamón y queso en versión cordon bleu. Relleno gourmet y bien condimentado.'],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $category = Category::firstOrCreate(
                ['shop_id' => $shop->id, 'slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'icon' => $catData['icon'],
                    'color' => $catData['color'],
                    'status' => true,
                ]
            );

            $category->update([
                'name' => $catData['name'],
                'icon' => $catData['icon'],
                'color' => $catData['color'],
                'status' => true,
            ]);

            foreach ($catData['products'] as $prod) {
                $product = Product::where('shop_id', $shop->id)
                    ->where('category_id', $category->id)
                    ->where('name', $prod['name'])
                    ->first();

                if ($product) {
                    $product->update([
                        'price' => $prod['price'],
                        'description' => $prod['description'],
                        'is_available' => true,
                    ]);
                } else {
                    Product::create([
                        'shop_id' => $shop->id,
                        'category_id' => $category->id,
                        'name' => $prod['name'],
                        'price' => $prod['price'],
                        'description' => $prod['description'],
                        'is_available' => true,
                    ]);
                }
            }
        }

        $productCount = Product::where('shop_id', $shop->id)->count();
        $this->command->info("Productos en tienda: {$productCount}");
        $this->command->info("Menú público: /{$shop->slug}");
        $this->command->info("Admin login: /{$shop->slug}/admin/login");
    }
}
