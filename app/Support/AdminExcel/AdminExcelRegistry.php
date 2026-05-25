<?php

namespace App\Support\AdminExcel;

use App\Models\AbandonedCart;
use App\Models\Announcement;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use InvalidArgumentException;

class AdminExcelRegistry
{
    /** @var array<string, array<string, mixed>>|null */
    private static ?array $entities = null;

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        if (self::$entities !== null) {
            return self::$entities;
        }

        self::$entities = [
            'categories' => [
                'label' => 'Categorías',
                'model' => Category::class,
                'filename' => 'categorias',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'name', 'label' => 'Nombre', 'import' => true, 'required' => true],
                    ['key' => 'slug', 'label' => 'Slug', 'import' => true],
                    ['key' => 'seo_title', 'label' => 'SEO Título', 'import' => true],
                    ['key' => 'seo_description', 'label' => 'SEO Descripción', 'import' => true],
                    ['key' => 'status', 'label' => 'Activo (1/0)', 'import' => true],
                    ['key' => 'icon', 'label' => 'Icono (FontAwesome)', 'import' => true],
                    ['key' => 'color', 'label' => 'Color HEX', 'import' => true],
                    ['key' => 'products_count', 'label' => 'Productos', 'import' => false],
                ],
            ],
            'products' => [
                'label' => 'Productos',
                'model' => Product::class,
                'filename' => 'productos',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'category_name', 'label' => 'Categoría', 'import' => true, 'required' => true],
                    ['key' => 'name', 'label' => 'Nombre', 'import' => true, 'required' => true],
                    ['key' => 'description', 'label' => 'Descripción', 'import' => true],
                    ['key' => 'price', 'label' => 'Precio', 'import' => true, 'required' => true],
                    ['key' => 'is_available', 'label' => 'Disponible (1/0)', 'import' => true],
                    ['key' => 'preparation_time', 'label' => 'Tiempo preparación', 'import' => true],
                    ['key' => 'features', 'label' => 'Características (JSON)', 'import' => true],
                    ['key' => 'seo_title', 'label' => 'SEO Título', 'import' => true],
                    ['key' => 'seo_description', 'label' => 'SEO Descripción', 'import' => true],
                    ['key' => 'image_path', 'label' => 'Imagen (URL/ruta)', 'import' => true],
                ],
            ],
            'orders' => [
                'label' => 'Pedidos',
                'model' => Order::class,
                'filename' => 'pedidos',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'order_number', 'label' => 'Número de orden', 'import' => false],
                    ['key' => 'customer_name', 'label' => 'Cliente', 'import' => true, 'required' => true],
                    ['key' => 'customer_phone', 'label' => 'Teléfono', 'import' => true, 'required' => true],
                    ['key' => 'total', 'label' => 'Total', 'import' => true, 'required' => true],
                    ['key' => 'status', 'label' => 'Estado', 'import' => true, 'required' => true],
                    ['key' => 'payment_method', 'label' => 'Método de pago', 'import' => true, 'required' => true],
                    ['key' => 'payment_status', 'label' => 'Estado de pago', 'import' => true, 'required' => true],
                    ['key' => 'delivery_type', 'label' => 'Tipo entrega', 'import' => true],
                    ['key' => 'table_number', 'label' => 'Número de mesa', 'import' => true],
                    ['key' => 'payment_reference', 'label' => 'Referencia de pago', 'import' => true],
                    ['key' => 'client_phone', 'label' => 'Cliente registrado (teléfono)', 'import' => false],
                    ['key' => 'created_at', 'label' => 'Fecha creación', 'import' => false],
                ],
            ],
            'clients' => [
                'label' => 'Clientes',
                'model' => Client::class,
                'filename' => 'clientes',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'name', 'label' => 'Nombre', 'import' => true, 'required' => true],
                    ['key' => 'phone', 'label' => 'Teléfono', 'import' => true, 'required' => true],
                    ['key' => 'email', 'label' => 'Email', 'import' => true],
                    ['key' => 'total_spent', 'label' => 'Total gastado', 'import' => true],
                    ['key' => 'status', 'label' => 'Activo (1/0)', 'import' => true],
                ],
            ],
            'announcements' => [
                'label' => 'Campañas',
                'model' => Announcement::class,
                'filename' => 'campanas',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'title', 'label' => 'Título', 'import' => true, 'required' => true],
                    ['key' => 'content', 'label' => 'Contenido', 'import' => true],
                    ['key' => 'button_text', 'label' => 'Texto botón', 'import' => true],
                    ['key' => 'button_link', 'label' => 'Enlace botón', 'import' => true],
                    ['key' => 'expires_at', 'label' => 'Expira (YYYY-MM-DD)', 'import' => true],
                    ['key' => 'is_active', 'label' => 'Activo (1/0)', 'import' => true],
                    ['key' => 'image_path', 'label' => 'Imagen (URL/ruta)', 'import' => true],
                ],
            ],
            'bookings' => [
                'label' => 'Reservas',
                'model' => Booking::class,
                'filename' => 'reservas',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'client_name', 'label' => 'Nombre cliente', 'import' => true, 'required' => true],
                    ['key' => 'client_phone', 'label' => 'Teléfono', 'import' => true, 'required' => true],
                    ['key' => 'date', 'label' => 'Fecha (YYYY-MM-DD)', 'import' => true, 'required' => true],
                    ['key' => 'time_slot', 'label' => 'Horario', 'import' => true, 'required' => true],
                    ['key' => 'status', 'label' => 'Estado', 'import' => true],
                ],
            ],
            'abandoned-carts' => [
                'label' => 'Carritos abandonados',
                'model' => AbandonedCart::class,
                'filename' => 'carritos_abandonados',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'customer_name', 'label' => 'Cliente', 'import' => true, 'required' => true],
                    ['key' => 'customer_phone', 'label' => 'Teléfono', 'import' => true, 'required' => true],
                    ['key' => 'cart_data', 'label' => 'Carrito (JSON)', 'import' => true],
                    ['key' => 'status', 'label' => 'Estado', 'import' => true],
                    ['key' => 'updated_at', 'label' => 'Última actividad', 'import' => false],
                ],
            ],
            'coupons' => [
                'label' => 'Cupones',
                'model' => Coupon::class,
                'filename' => 'cupones',
                'importable' => true,
                'columns' => [
                    ['key' => 'id', 'label' => 'ID', 'import' => false],
                    ['key' => 'code', 'label' => 'Código', 'import' => true, 'required' => true],
                    ['key' => 'type', 'label' => 'Tipo (percentage/fixed)', 'import' => true, 'required' => true],
                    ['key' => 'value', 'label' => 'Valor', 'import' => true, 'required' => true],
                    ['key' => 'min_order_amount', 'label' => 'Mínimo de compra', 'import' => true],
                    ['key' => 'usage_limit', 'label' => 'Límite de usos', 'import' => true],
                    ['key' => 'used_count', 'label' => 'Veces usado', 'import' => false],
                    ['key' => 'expires_at', 'label' => 'Expira (YYYY-MM-DD)', 'import' => true],
                    ['key' => 'is_active', 'label' => 'Activo (1/0)', 'import' => true],
                ],
            ],
        ];

        return self::$entities;
    }

    /**
     * @return array<string, mixed>
     */
    public static function get(string $entity): array
    {
        $entities = self::all();

        if (! isset($entities[$entity])) {
            throw new InvalidArgumentException("Entidad Excel no válida: {$entity}");
        }

        return $entities[$entity];
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_keys(self::all());
    }
}
