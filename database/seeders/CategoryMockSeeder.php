<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryMockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener la tienda demo o la primera existente
        $shop = Shop::where('slug', 'demo')->first() ?: Shop::first();

        if (!$shop) {
            $this->command->error('No se encontró ninguna tienda en la base de datos para seedear.');
            return;
        }

        $this->command->info("Seedeando categorías de prueba en la tienda: {$shop->name} (slug: {$shop->slug})");

        // 2. Definir los datos de las categorías del screenshot
        $categoriesData = [
            [
                'name' => 'Empanadas clásicas',
                'icon' => 'fa-fire',
                'color' => '#10B981',
                'products' => [
                    ['name' => 'Empanada de Carne Molida', 'price' => 1.50, 'description' => 'Tradicional empanada de carne molida sazonada a la perfección.'],
                    ['name' => 'Empanada de Pollo Guisado', 'price' => 1.50, 'description' => 'Jugoso pollo mechado guisado con aliños criollos.'],
                    ['name' => 'Empanada de Queso Blanco', 'price' => 1.20, 'description' => 'Rellena de abundante queso blanco rallado derretido.'],
                    ['name' => 'Empanada de Carne Mechada', 'price' => 1.80, 'description' => 'Carne mechada guisada al estilo venezolano tradicional.'],
                    ['name' => 'Empanada de Cazón', 'price' => 2.00, 'description' => 'Exquisita empanada de cazón (tiburón joven) guisado de oriente.'],
                    ['name' => 'Empanada Dominó', 'price' => 1.40, 'description' => 'Combinación perfecta de caraotas negras con queso blanco.'],
                    ['name' => 'Empanada de Jamón y Queso', 'price' => 1.60, 'description' => 'Clásico relleno de jamón cocido y queso blanco suave.'],
                    ['name' => 'Empanada de Tajada con Queso', 'price' => 1.50, 'description' => 'Plátano maduro frito en tajadas con queso blanco rallado.'],
                ]
            ],
            [
                'name' => 'Empanadas especiales',
                'icon' => 'fa-star',
                'color' => '#EF4444',
                'products' => [
                    ['name' => 'Empanada Pabellón Margariteño', 'price' => 2.50, 'description' => 'Exquisita combinación de cazón, caraotas negras, tajadas y queso.'],
                    ['name' => 'Empanada Operada de Mechada', 'price' => 2.30, 'description' => 'Empanada de carne mechada abierta y rellena con queso extra por encima.'],
                    ['name' => 'Empanada Triple Queso', 'price' => 2.20, 'description' => 'Una explosión de queso blanco, queso amarillo y queso crema.'],
                    ['name' => 'Empanada de Camarones al Ajillo', 'price' => 3.50, 'description' => 'Deliciosos camarones salteados con ajo y vino blanco.'],
                    ['name' => 'Empanada de Pulpo a la Vinagreta', 'price' => 3.80, 'description' => 'Tierno pulpo preparado a la vinagreta marina oriental.'],
                ]
            ],
            [
                'name' => 'Refrescos y jugos',
                'icon' => 'fa-glass-water',
                'color' => '#06B6D4',
                'products' => []
            ],
            [
                'name' => 'Chucherías y dulces',
                'icon' => 'fa-candy-cane',
                'color' => '#EC4899',
                'products' => []
            ],
            [
                'name' => 'Artículos de conveniencia',
                'icon' => 'fa-basket-shopping',
                'color' => '#6366F1',
                'products' => []
            ]
        ];

        // 3. Crear las categorías e insertar los productos correspondientes
        foreach ($categoriesData as $catData) {
            $slug = Str::slug($catData['name']);
            
            // Buscar o crear la categoría para la tienda
            $category = Category::where('shop_id', $shop->id)
                ->where('slug', $slug)
                ->first();

            if (!$category) {
                $category = Category::create([
                    'shop_id' => $shop->id,
                    'name' => $catData['name'],
                    'slug' => $slug,
                    'icon' => $catData['icon'],
                    'color' => $catData['color'],
                    'status' => true,
                ]);
            } else {
                // Actualizar los campos icon y color
                $category->update([
                    'icon' => $catData['icon'],
                    'color' => $catData['color'],
                ]);
            }

            // Insertar productos de prueba
            foreach ($catData['products'] as $prodData) {
                // Verificar si ya existe un producto con el mismo nombre en esta categoría
                $exists = Product::where('shop_id', $shop->id)
                    ->where('category_id', $category->id)
                    ->where('name', $prodData['name'])
                    ->exists();

                if (!$exists) {
                    Product::create([
                        'shop_id' => $shop->id,
                        'category_id' => $category->id,
                        'name' => $prodData['name'],
                        'price' => $prodData['price'],
                        'description' => $prodData['description'],
                        'is_available' => true,
                        'image_path' => null,
                        'features' => null,
                    ]);
                }
            }
        }

        $this->command->info('Seeder completado con éxito.');
    }
}
