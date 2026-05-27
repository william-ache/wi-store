<?php

namespace App\Support;

final class PlanDetails
{
    /**
     * Filas de la tabla comparativa técnica (Standard vs Premium).
     *
     * @return array<int, array{feature: string, standard: string, premium: string}>
     */
    public static function comparisonRows(): array
    {
        return [
            ['feature' => 'Límite de Productos', 'standard' => 'Hasta 20 productos', 'premium' => 'Hasta 35 productos'],
            ['feature' => 'Límite de Categorías', 'standard' => 'Hasta 4 categorías', 'premium' => 'Hasta 7 categorías'],
            ['feature' => 'Visualización de Fotos', 'standard' => 'Solo ventana Modal (Show)', 'premium' => 'Menú, Carrito y Modal'],
            ['feature' => 'Personalización de Diseño', 'standard' => 'No (Paleta Base)', 'premium' => 'Sí (Colores de Marca)'],
            ['feature' => 'Sedes / Sucursales', 'standard' => '1 Sede', 'premium' => 'Hasta 3 Sedes'],
            ['feature' => 'Números de Contacto', 'standard' => '1 Número', 'premium' => 'Hasta 3 Números'],
            ['feature' => 'Métodos de Pago', 'standard' => '1 Método único', 'premium' => 'Múltiples (Inteligentes)'],
            ['feature' => 'Opciones y Extras', 'standard' => 'No disponible', 'premium' => 'Sí (Variantes y Atributos)'],
            ['feature' => 'Módulo de Servicios', 'standard' => 'No disponible', 'premium' => 'Disponible'],
            ['feature' => 'Carrusel de Tiendas', 'standard' => 'No aparece', 'premium' => 'Destacado Regular'],
            ['feature' => 'Panel Administrativo', 'standard' => 'No disponible', 'premium' => 'Sí (Clientes, Órdenes, Pagos)'],
            ['feature' => 'Nivel de Soporte', 'standard' => 'Estándar vía WhatsApp', 'premium' => 'Corporativo dedicado 24/7'],
        ];
    }

    /**
     * Filas resumidas para la comparativa en landing (sin fotos; hasta métodos de pago).
     *
     * @return array<int, array{feature: string, standard: string, premium: string}>
     */
    public static function comparisonRowsPreview(): array
    {
        $rows = [];

        foreach (self::comparisonRows() as $row) {
            if ($row['feature'] === 'Visualización de Fotos') {
                continue;
            }

            $rows[] = $row;

            if ($row['feature'] === 'Métodos de Pago') {
                break;
            }
        }

        return $rows;
    }

    /** @return array<string, mixed> */
    public static function standard(): array
    {
        return [
            'slug' => 'standard',
            'marketing_name' => 'Emprendedor',
            'technical_name' => 'Standard',
            'purpose' => 'Configuración ideal para pequeños comercios, negocios independientes o emprendimientos que inician su transformación digital con necesidades de catálogo esenciales.',
            'sections' => [
                [
                    'title' => 'Capacidad del Catálogo',
                    'body' => 'Restricción estricta a un máximo de 20 productos activos y hasta 4 categorías organizativas.',
                ],
                [
                    'title' => 'Ficha de Producto Simplificada',
                    'body' => 'Soporte exclusivo para campos esenciales: título, descripción, precio y asignación de categoría. No admite variantes, extras ni modificadores complejos.',
                ],
                [
                    'title' => 'Identidad de Interfaz Estática',
                    'body' => 'El menú adopta de forma automática el esquema de colores base y predeterminado de la plataforma, inhabilitando la personalización visual independiente.',
                ],
                [
                    'title' => 'Límites Operativos',
                    'body' => 'Habilitación de 1 sola sede o sucursal física, 1 número telefónico único para enrutamiento de pedidos y 1 único método de pago registrado en el checkout.',
                ],
                [
                    'title' => 'Restricciones de Módulos',
                    'body' => 'Exclusión completa del módulo de servicios independientes, del carrusel promocional de tiendas y del panel administrativo avanzado. Disponibles únicamente los módulos de: producto, categoría, pedidos, marketing y analítica básica.',
                ],
                [
                    'title' => 'Soporte Técnico',
                    'body' => 'Soporte reactivo estándar gestionado a través de canales asíncronos en WhatsApp y correo electrónico.',
                ],
            ],
            'card_highlights' => [
                'Hasta 20 productos · 4 categorías',
                'Ficha simple sin variantes ni extras',
                'Paleta base de WI-Store (sin colores de marca)',
                '1 sede · 1 teléfono · 1 método de pago',
                'Módulos: producto, categoría, pedidos, marketing',
                'Soporte estándar por WhatsApp y email',
            ],
        ];
    }

    /** @return array<string, mixed> */
    public static function premium(): array
    {
        return [
            'slug' => 'premium',
            'marketing_name' => 'Negocio',
            'technical_name' => 'Premium',
            'purpose' => 'Pensado para negocios en fase de expansión, marcas consolidadas y locales con un flujo continuo de transacciones que requieren autonomía operativa y análisis de métricas.',
            'sections' => [
                [
                    'title' => 'Capacidad del Catálogo Ampliada',
                    'body' => 'Expansión del inventario para gestionar hasta un máximo de 40 productos activos distribuidos en hasta 8 categorías independientes.',
                ],
                [
                    'title' => 'Experiencia Visual Completa',
                    'body' => 'Desbloqueo de imágenes en alta resolución a lo largo de toda la aplicación (visibles en la grilla principal del menú, el flujo del carrito de compras y la ventana modal).',
                ],
                [
                    'title' => 'Personalización de Marca Avanzada',
                    'body' => 'Herramientas de diseño completamente habilitadas para ajustar la paleta cromática y la estética general del menú digital según la identidad del negocio.',
                ],
                [
                    'title' => 'Infraestructura Multi-sucursal',
                    'body' => 'Permite configurar hasta 3 sedes o locales físicos concurrentes, con hasta 3 números de contacto para la asignación y despacho inteligente de pedidos.',
                ],
                [
                    'title' => 'Métodos de Pago Inteligentes',
                    'body' => 'Integración y visualización de múltiples métodos de pago simultáneos durante el proceso de checkout (Pago Móvil, Zelle, efectivo, entre otros).',
                ],
                [
                    'title' => 'Productos Complejos y Modificadores',
                    'body' => 'Capacidad técnica para añadir opciones, atributos personalizables, variantes de tamaño, ingredientes extras y complementos a las fichas de producto. Máximo 3 variantes.',
                ],
                [
                    'title' => 'Módulo de Servicios Activo',
                    'body' => 'Sección especializada para la gestión, exhibición y agendamiento directo de servicios comerciales.',
                ],
                [
                    'title' => 'Panel Administrativo (Back-Office)',
                    'body' => 'Módulo integral de gestión que incluye control de clientes registrados, historial detallado de órdenes, conciliación de estados de pago y analíticas financieras básicas.',
                ],
                [
                    'title' => 'Soporte Técnico Corporativo',
                    'body' => 'Soporte de respuesta prioritaria y dedicada operativa las 24 horas, los 7 días de la semana.',
                ],
            ],
            'card_highlights' => [
                'Hasta 40 productos · 8 categorías',
                'Fotos en menú, carrito y modal',
                'Colores y marca personalizables',
                '3 sedes · 3 teléfonos · pagos múltiples',
                'Variantes y extras (máx. 3 variantes)',
                'Servicios + panel admin + soporte 24/7',
            ],
        ];
    }
}
