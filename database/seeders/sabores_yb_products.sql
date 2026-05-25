-- =============================================================================
-- Solo PRODUCTOS (empanadas) — Tienda: Sabores Y&B
-- Requiere categorías: empanadas-clasicas, empanadas-especiales
-- =============================================================================

SET NAMES utf8mb4;

-- Ajusta el slug si tu tienda usa otro (ej: demo)
SET @shop_id = (SELECT `id` FROM `shops` WHERE `slug` = 'sabores-yb' LIMIT 1);

-- Si no existe por slug, busca por nombre
SET @shop_id = IFNULL(
    @shop_id,
    (SELECT `id` FROM `shops` WHERE `name` LIKE '%Sabores%' LIMIT 1)
);

-- Si aún no hay tienda, usa la primera
SET @shop_id = IFNULL(@shop_id, (SELECT `id` FROM `shops` ORDER BY `id` ASC LIMIT 1));

-- Crear categorías si faltan
INSERT INTO `categories` (`shop_id`, `name`, `slug`, `icon`, `color`, `status`, `created_at`, `updated_at`)
SELECT @shop_id, 'Empanadas clásicas', 'empanadas-clasicas', 'fa-fire', '#10B981', 1, NOW(), NOW()
WHERE @shop_id IS NOT NULL
AND NOT EXISTS (SELECT 1 FROM `categories` WHERE `shop_id` = @shop_id AND `slug` = 'empanadas-clasicas');

INSERT INTO `categories` (`shop_id`, `name`, `slug`, `icon`, `color`, `status`, `created_at`, `updated_at`)
SELECT @shop_id, 'Empanadas especiales', 'empanadas-especiales', 'fa-star', '#EF4444', 1, NOW(), NOW()
WHERE @shop_id IS NOT NULL
AND NOT EXISTS (SELECT 1 FROM `categories` WHERE `shop_id` = @shop_id AND `slug` = 'empanadas-especiales');

-- =============================================================================
-- EMPANADAS CLÁSICAS (8)
-- =============================================================================
INSERT INTO `products` (`shop_id`, `category_id`, `name`, `description`, `price`, `image_path`, `is_available`, `features`, `created_at`, `updated_at`)
SELECT @shop_id, c.`id`, v.`name`, v.`description`, v.`price`, NULL, 1, NULL, NOW(), NOW()
FROM `categories` c
CROSS JOIN (
    SELECT 'Empanada de Carne Molida'      AS `name`, 'Tradicional empanada de carne molida sazonada a la perfección.' AS `description`, 1.50 AS `price` UNION ALL
    SELECT 'Empanada de Pollo Guisado',   'Jugoso pollo mechado guisado con aliños criollos.', 1.50 UNION ALL
    SELECT 'Empanada de Queso Blanco',    'Rellena de abundante queso blanco rallado derretido.', 1.20 UNION ALL
    SELECT 'Empanada de Carne Mechada',   'Carne mechada guisada al estilo venezolano tradicional.', 1.80 UNION ALL
    SELECT 'Empanada de Cazón',           'Exquisita empanada de cazón (tiburón joven) guisado de oriente.', 2.00 UNION ALL
    SELECT 'Empanada Dominó',             'Combinación perfecta de caraotas negras con queso blanco.', 1.40 UNION ALL
    SELECT 'Empanada de Jamón y Queso',   'Clásico relleno de jamón cocido y queso blanco suave.', 1.60 UNION ALL
    SELECT 'Empanada de Tajada con Queso','Plátano maduro frito en tajadas con queso blanco rallado.', 1.50
) v
WHERE @shop_id IS NOT NULL
  AND c.`shop_id` = @shop_id
  AND c.`slug` = 'empanadas-clasicas'
  AND NOT EXISTS (
      SELECT 1 FROM `products` p
      WHERE p.`shop_id` = @shop_id AND p.`category_id` = c.`id` AND p.`name` = v.`name`
  );

-- =============================================================================
-- EMPANADAS ESPECIALES (5)
-- =============================================================================
INSERT INTO `products` (`shop_id`, `category_id`, `name`, `description`, `price`, `image_path`, `is_available`, `features`, `created_at`, `updated_at`)
SELECT @shop_id, c.`id`, v.`name`, v.`description`, v.`price`, NULL, 1, NULL, NOW(), NOW()
FROM `categories` c
CROSS JOIN (
    SELECT 'Empanada Pabellón Margariteño'     AS `name`, 'Exquisita combinación de cazón, caraotas negras, tajadas y queso.' AS `description`, 2.50 AS `price` UNION ALL
    SELECT 'Empanada Operada de Mechada',       'Empanada de carne mechada abierta y rellena con queso extra por encima.', 2.30 UNION ALL
    SELECT 'Empanada Triple Queso',            'Una explosión de queso blanco, queso amarillo y queso crema.', 2.20 UNION ALL
    SELECT 'Empanada de Camarones al Ajillo',  'Deliciosos camarones salteados con ajo y vino blanco.', 3.50 UNION ALL
    SELECT 'Empanada de Pulpo a la Vinagreta', 'Tierno pulpo preparado a la vinagreta marina oriental.', 3.80
) v
WHERE @shop_id IS NOT NULL
  AND c.`shop_id` = @shop_id
  AND c.`slug` = 'empanadas-especiales'
  AND NOT EXISTS (
      SELECT 1 FROM `products` p
      WHERE p.`shop_id` = @shop_id AND p.`category_id` = c.`id` AND p.`name` = v.`name`
  );

-- Listado insertado
SELECT p.`id`, c.`name` AS categoria, p.`name`, p.`price`, p.`is_available`
FROM `products` p
JOIN `categories` c ON c.`id` = p.`category_id`
WHERE p.`shop_id` = @shop_id
  AND c.`slug` IN ('empanadas-clasicas', 'empanadas-especiales')
ORDER BY c.`slug`, p.`name`;
