<?php

namespace App\Support;

final class PlanDetails
{
    /**
     * Filas de la tabla comparativa técnica (Emprendedor vs Negocio).
     *
     * @return array<int, array{feature: string, standard: string, premium: string}>
     */
    public static function comparisonRows(): array
    {
        return PlanCatalog::comparisonRows();
    }

    /**
     * Filas resumidas para la comparativa en landing (sin fotos; hasta métodos de pago).
     *
     * @return array<int, array{feature: string, standard: string, premium: string}>
     */
    public static function comparisonRowsPreview(): array
    {
        return PlanCatalog::comparisonRowsPreview();
    }

    /** @return array<string, mixed> */
    public static function standard(): array
    {
        $limits = PlatformPlanSettings::limits('standard');

        return [
            'slug' => 'standard',
            'marketing_name' => PlatformPlanSettings::plan('standard')['marketing_name'] ?? 'Emprendedor',
            'technical_name' => 'Emprendedor',
            'purpose' => PlatformPlanSettings::purpose('standard') ?: 'Configuración ideal para pequeños comercios, negocios independientes o emprendimientos que inician su transformación digital con necesidades de catálogo esenciales.',
            'sections' => [
                [
                    'title' => 'Capacidad del Catálogo',
                    'body' => sprintf(
                        'Capacidad de %s y %s según tu plan activo.',
                        PlanCatalog::formatLimit($limits['max_products'], 'producto', 'productos'),
                        PlanCatalog::formatLimit($limits['max_categories'], 'categoría', 'categorías'),
                    ),
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
            'card_highlights' => self::cardHighlights('standard'),
        ];
    }

    /** @return array<string, mixed> */
    public static function premium(): array
    {
        $limits = PlatformPlanSettings::limits('premium');

        return [
            'slug' => 'premium',
            'marketing_name' => PlatformPlanSettings::plan('premium')['marketing_name'] ?? 'Negocio',
            'technical_name' => 'Negocio',
            'purpose' => PlatformPlanSettings::purpose('premium') ?: 'Pensado para negocios en fase de expansión, marcas consolidadas y locales con un flujo continuo de transacciones que requieren autonomía operativa y análisis de métricas.',
            'sections' => [
                [
                    'title' => 'Capacidad del Catálogo Ampliada',
                    'body' => sprintf(
                        'Inventario ampliado: %s y %s.',
                        PlanCatalog::formatLimit($limits['max_products'], 'producto', 'productos'),
                        PlanCatalog::formatLimit($limits['max_categories'], 'categoría', 'categorías'),
                    ),
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
            'card_highlights' => self::cardHighlights('premium'),
        ];
    }

    /** @return list<string> */
    private static function cardHighlights(string $key): array
    {
        try {
            $fromSettings = PlatformPlanSettings::highlights($key);

            if ($fromSettings !== []) {
                return $fromSettings;
            }
        } catch (\Throwable) {
            // Tabla aún no migrada: usar valores embebidos en defaults().
        }

        return match ($key) {
            'standard' => PlatformPlanSettings::defaults()['plans']['standard']['highlights'],
            'premium' => PlatformPlanSettings::defaults()['plans']['premium']['highlights'],
            default => [],
        };
    }
}
