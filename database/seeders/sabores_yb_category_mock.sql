-- =============================================================================
-- CategoryMockSeeder → SQL para tienda "Sabores Y&B"
-- Slug de tienda: sabores-yb
-- URL menú: /sabores-yb  (o https://tu-dominio/sabores-yb)
-- Idempotente: no duplica categorías ni productos existentes.
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------------------------
-- 1) Tienda Sabores Y&B (crear o actualizar por slug)
-- -----------------------------------------------------------------------------
INSERT INTO `shops` (
    `name`,
    `slug`,
    `whatsapp_number`,
    `description`,
    `address`,
    `color_primary`,
    `color_secondary`,
    `color_background`,
    `exchange_rate`,
    `is_active`,
    `has_dine_in`,
    `has_pickup`,
    `has_delivery`,
    `plan`,
    `created_at`,
    `updated_at`
) VALUES (
    'Sabores Y&B',
    'sabores-yb',
    '584121305420',
    'Empanadas artesanales y más. Pide en línea y recibe en tu puerta.',
    'Margarita, Venezuela',
    '#E60067',
    '#C6A100',
    '#FFF0F8',
    'Bs. 515.18',
    1,
    1,
    1,
    1,
    'standard',
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `description` = VALUES(`description`),
    `whatsapp_number` = VALUES(`whatsapp_number`),
    `address` = VALUES(`address`),
    `is_active` = 1,
    `updated_at` = NOW();

SET @shop_id = (SELECT `id` FROM `shops` WHERE `slug` = 'sabores-yb' LIMIT 1);

-- Si prefieres usar la PRIMERA tienda existente en lugar de crear/actualizar por slug,
-- comenta el bloque INSERT de arriba y descomenta estas dos líneas:
-- SET @shop_id = (SELECT `id` FROM `shops` ORDER BY `id` ASC LIMIT 1);
-- UPDATE `shops` SET `name` = 'Sabores Y&B', `slug` = 'sabores-yb' WHERE `id` = @shop_id;

-- -----------------------------------------------------------------------------
-- 2) Categorías
-- -----------------------------------------------------------------------------
INSERT INTO `categories` (`shop_id`, `name`, `slug`, `icon`, `color`, `status`, `created_at`, `updated_at`) VALUES
(@shop_id, 'Empanadas clásicas',       'empanadas-clasicas',       'fa-fire',            '#10B981', 1, NOW(), NOW()),
(@shop_id, 'Empanadas especiales',     'empanadas-especiales',     'fa-star',            '#EF4444', 1, NOW(), NOW()),
(@shop_id, 'Refrescos y jugos',        'refrescos-y-jugos',        'fa-glass-water',     '#06B6D4', 1, NOW(), NOW()),
(@shop_id, 'Chucherías y dulces',      'chucherias-y-dulces',      'fa-candy-cane',      '#EC4899', 1, NOW(), NOW()),
(@shop_id, 'Artículos de conveniencia', 'articulos-de-conveniencia', 'fa-basket-shopping', '#6366F1', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `icon` = VALUES(`icon`),
    `color` = VALUES(`color`),
    `status` = 1,
    `updated_at` = NOW();

-- -----------------------------------------------------------------------------
-- 3) Productos — Empanadas clásicas
-- -----------------------------------------------------------------------------
INSERT INTO `products` (`shop_id`, `category_id`, `name`, `description`, `price`, `image_path`, `is_available`, `features`, `created_at`, `updated_at`)
SELECT @shop_id, c.`id`, v.`name`, v.`description`, v.`price`, NULL, 1, NULL, NOW(), NOW()
FROM `categories` c
CROSS JOIN (
    SELECT 'Empanada de Carne Molida' AS `name`, 'Tradicional empanada de carne molida sazonada a la perfección.' AS `description`, 1.50 AS `price` UNION ALL
    SELECT 'Empanada de Pollo Guisado', 'Jugoso pollo mechado guisado con aliños criollos.', 1.50 UNION ALL
    SELECT 'Empanada de Queso Blanco', 'Rellena de abundante queso blanco rallado derretido.', 1.20 UNION ALL
    SELECT 'Empanada de Carne Mechada', 'Carne mechada guisada al estilo venezolano tradicional.', 1.80 UNION ALL
    SELECT 'Empanada de Cazón', 'Exquisita empanada de cazón (tiburón joven) guisado de oriente.', 2.00 UNION ALL
    SELECT 'Empanada Dominó', 'Combinación perfecta de caraotas negras con queso blanco.', 1.40 UNION ALL
    SELECT 'Empanada de Jamón y Queso', 'Clásico relleno de jamón cocido y queso blanco suave.', 1.60 UNION ALL
    SELECT 'Empanada de Tajada con Queso', 'Plátano maduro frito en tajadas con queso blanco rallado.', 1.50
) v
WHERE c.`shop_id` = @shop_id AND c.`slug` = 'empanadas-clasicas'
AND NOT EXISTS (
    SELECT 1 FROM `products` p
    WHERE p.`shop_id` = @shop_id AND p.`category_id` = c.`id` AND p.`name` = v.`name`
);

-- -----------------------------------------------------------------------------
-- 4) Productos — Empanadas especiales
-- -----------------------------------------------------------------------------
INSERT INTO `products` (`shop_id`, `category_id`, `name`, `description`, `price`, `image_path`, `is_available`, `features`, `created_at`, `updated_at`)
SELECT @shop_id, c.`id`, v.`name`, v.`description`, v.`price`, NULL, 1, NULL, NOW(), NOW()
FROM `categories` c
CROSS JOIN (
    SELECT 'Empanada Pabellón Margariteño' AS `name`, 'Exquisita combinación de cazón, caraotas negras, tajadas y queso.' AS `description`, 2.50 AS `price` UNION ALL
    SELECT 'Empanada Operada de Mechada', 'Empanada de carne mechada abierta y rellena con queso extra por encima.', 2.30 UNION ALL
    SELECT 'Empanada Triple Queso', 'Una explosión de queso blanco, queso amarillo y queso crema.', 2.20 UNION ALL
    SELECT 'Empanada de Camarones al Ajillo', 'Deliciosos camarones salteados con ajo y vino blanco.', 3.50 UNION ALL
    SELECT 'Empanada de Pulpo a la Vinagreta', 'Tierno pulpo preparado a la vinagreta marina oriental.', 3.80
) v
WHERE c.`shop_id` = @shop_id AND c.`slug` = 'empanadas-especiales'
AND NOT EXISTS (
    SELECT 1 FROM `products` p
    WHERE p.`shop_id` = @shop_id AND p.`category_id` = c.`id` AND p.`name` = v.`name`
);

SET FOREIGN_KEY_CHECKS = 1;

-- Verificación rápida
SELECT @shop_id AS shop_id, s.`name`, s.`slug` FROM `shops` s WHERE s.`id` = @shop_id;
SELECT c.`slug`, c.`name`, COUNT(p.`id`) AS productos
FROM `categories` c
LEFT JOIN `products` p ON p.`category_id` = c.`id`
WHERE c.`shop_id` = @shop_id
GROUP BY c.`id`, c.`slug`, c.`name`
ORDER BY c.`id`;
