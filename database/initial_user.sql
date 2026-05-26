-- SQL para insertar un usuario y tienda inicial con colores y datos por defecto

-- Vaciar las tablas antes (opcional, migrate:fresh ya lo hace, pero por seguridad)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE users;
TRUNCATE TABLE shops;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Insertar la tienda base con colores tipo Landing (modernos, elegantes)
INSERT INTO shops (
    id, 
    name, 
    slug, 
    whatsapp_number, 
    description, 
    address, 
    payment_methods, 
    color_primary, 
    color_secondary, 
    color_background, 
    exchange_rate, 
    created_at, 
    updated_at
) VALUES (
    1, 
    'WI-Store Landing Demo', 
    'demo', 
    '+584121234567', 
    'Tienda demostrativa con diseño y colores de sistema modernos y elegantes.', 
    'Av. Principal, Edificio Central, Piso 4.', 
    'Zelle, Efectivo, Pago Móvil', 
    '#0f172a', -- slate-900 (Primario oscuro/elegante)
    '#38bdf8', -- sky-400 (Secundario brillante)
    '#f8fafc', -- slate-50 (Fondo muy claro y limpio)
    'Bs. 515.18', 
    NOW(), 
    NOW()
);

-- 2. Insertar el usuario administrador vinculado a esa tienda
-- La contraseña por defecto es "password" encriptada en Bcrypt
INSERT INTO users (
    id, 
    shop_id, 
    name, 
    email, 
    password, 
    created_at, 
    updated_at
) VALUES (
    1, 
    1, 
    'Administrador Demo', 
    'admin@wi-store.com', 
    '$2y$12$Mtvz4Hlw7gqSziXVvvgSGOKrJS5/XE.wQTgAwH5fnDxeDOVegpOzW', -- "password"
    NOW(), 
    NOW()
);
