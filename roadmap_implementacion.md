# Plan Estratégico de Implementación de Nuevos Módulos - WIStore

Este documento detalla el diagnóstico técnico, la arquitectura propuesta y el cronograma de fases para integrar las características solicitadas en la plataforma SaaS de catálogos digitales **WIStore**.

---

## 📊 1. Auditoría de Estado: Implementado vs. Pendiente

| Módulo Solicitado | Estado Actual | Diagnóstico Técnico | Prioridad de Negocio |
| :--- | :--- | :--- | :--- |
| **Cupones y Promociones** | ❌ No implementado | Requiere tabla `coupons`, validación en el checkout del carrito y cálculo de descuento en la orden. | ⭐⭐⭐⭐⭐ (Crítica) |
| **Dominios Personalizados** | ❌ No implementado | Requiere middleware de detección de host en Laravel y configuración DNS wildcard/Nginx. | ⭐⭐⭐⭐⭐ (Crítica) |
| **Píxeles y Tracking** | ❌ No implementado | Agregar campos de texto en configuración visual e inyectarlos dinámicamente en el `<head>`. | ⭐⭐⭐⭐ (Alta) |
| **SEO de Producto/Catálogo**| ❌ No implementado | Agregar columnas `meta_title` y `meta_description` en la base de datos de productos y categorías. | ⭐⭐⭐⭐ (Alta) |
| **Gestión de Mesas (Dine-in)**| ❌ No implementado | Agregar columna `table_number` opcional a las órdenes y parámetros de URL en los códigos QR. | ⭐⭐⭐⭐ (Alta) |
| **Pasarelas de Pago (Stripe/Binance/Pago Móvil)**| ❌ Parcial | Actualmente se acuerdan por fuera (WhatsApp). Se requiere migración a pasarelas dinámicas con APIs webhook. | ⭐⭐⭐ (Media) |
| **Reseñas y Calificaciones**| ⚠️ Parcial | Ya existe la ruta y controlador para registrar reviews, pero falta visualización premium en storefront. | ⭐⭐⭐ (Media) |
| **Carritos Abandonados** | ❌ No implementado | Requiere almacenamiento de carritos en DB/Redis con triggers de recordatorios por WhatsApp/Email. | ⭐⭐⭐ (Media) |
| **Reservas y Citas** | ❌ No implementado | Requiere tabla `bookings`, selección de horarios y bloqueo de disponibilidad. | ⭐⭐ (Baja) |
| **PWA (Instalación)** | ❌ No implementado | Requiere `manifest.json` y `service-worker.js` dinámicos por cada tienda. | ⭐⭐ (Baja) |
| **Webhooks e Integraciones**| ❌ No implementado | Requiere API REST protegida por tokens (Sanctum) y sistema de envío de payloads en eventos. | ⭐ (Futura) |

---

## 🚀 2. Fase 1: Conversión Rápida y SEO (Implementación Rápida)

Enfocada en funcionalidades de alta conversión con bajo impacto de infraestructura.

### 2.1. Sistema de Cupones y Promociones
*   **Arquitectura de Datos:**
    ```
    Table: coupons
    - id (BigInt, PK)
    - shop_id (Foreign Key -> shops)
    - code (String, Unique)       // Ej: VERANO20
    - type (Enum: 'percentage', 'fixed')
    - value (Decimal 10,2)        // Porcentaje (20.00) o monto fijo (5.00)
    - min_order_amount (Decimal)  // Compra mínima requerida
    - expires_at (DateTime, Nullable)
    - usage_limit (Int)
    - used_count (Int)
    - is_active (Boolean)
    ```
*   **Lógica de Negocio:**
    1. El administrador crea los cupones desde `Configuración` -> `Cupones`.
    2. En el storefront (`store/index.blade.php`), se añade un input dinámico en el panel del carrito: *"¿Tienes un cupón de descuento?"*.
    3. Validación por AJAX/AlpineJS al presionar "Aplicar". Se descuenta el valor del subtotal antes de enviar el pedido estructurado por WhatsApp/Telegram.

### 2.2. Tracking Pixels (Meta, TikTok y Google)
*   **Arquitectura de Datos:**
    Añadir columnas en la tabla `shops` o en un JSON de configuración:
    `facebook_pixel_id`, `tiktok_pixel_id`, `google_analytics_id`.
*   **Lógica de Inyección:**
    En el layout base de las tiendas (`store/index.blade.php`), inyectar scripts condicionales en el `<head>`:
    ```blade
    @if(!empty($company['facebook_pixel_id']))
    <!-- Meta Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s){...}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '{{ $company['facebook_pixel_id'] }}');
      fbq('track', 'PageView');
    </script>
    @endif
    ```

### 2.3. Optimización SEO en Productos y Categorías
*   **Arquitectura de Datos:**
    Agregar columnas `seo_title` y `seo_description` en las tablas `products` y `categories`.
*   **Integración:**
    Incluir inputs de SEO en el formulario de creación/edición de productos y categorías. Inyectar dinámicamente en el encabezado cuando el usuario visualice la vista individual de un producto.

---

## 💎 3. Fase 2: Marca Premium y Nichos (Monetización del Plan Premium)

Enfocada en incentivar al usuario a pagar por planes Premium o Gold.

### 3.1. Módulo de Dominios Personalizados (Custom Domains)
*   **Arquitectura de Infraestructura:**
    1. El cliente apunta un CNAME de su dominio (ej. `tienda.com`) al dominio raíz de la plataforma (ej. `cname.wistore.com`).
    2. El servidor Nginx/Caddy está configurado para aceptar tráfico en puertos `80` y `443` con SSL automático wildcard (ej. Let's Encrypt).
*   **Resolución en Laravel:**
    Modificar el Middleware de inquilinos (`IdentifyTenant.php`) para buscar la tienda por dominio si el host no termina en `wistore.com`:
    ```php
    $host = $request->getHost();
    if (!str_ends_with($host, 'wistore.com')) {
        $shop = Shop::where('custom_domain', $host)->first();
    }
    ```

### 3.2. Gestión de Mesas (Dine-in) para Restaurantes
*   **Arquitectura de Operación:**
    1. Generar códigos QR con una variable adicional de consulta de URL: `https://wistore.com/restaurant-slug?mesa=4`
    2. El catálogo detecta la variable en la URL mediante AlpineJS y fija de manera persistente en la sesión: `mesaStatus = 4`.
    3. Al realizar el pedido, el JSON del carrito adjunta el número de mesa y se añade a la cabecera de la orden enviada al panel y a WhatsApp:
       *   *📝 Pedido desde Mesa #4 • Entregar en mesa.*

### 3.3. Calendario de Reservas y Citas (Booking)
*   **Arquitectura de Datos:**
    ```
    Table: bookings
    - id (BigInt, PK)
    - shop_id (FK -> shops)
    - client_name (String)
    - client_phone (String)
    - date (Date)
    - time_slot (String)          // Ej: "14:00 - 15:00"
    - status (Enum: 'pending', 'confirmed', 'cancelled')
    ```
*   **Frontend Catalog:**
    Agregar una vista de "Agendar Cita" en el catálogo. El cliente visualiza un calendario de días habilitados por el administrador, selecciona su servicio y hora, y finaliza enviando la confirmación de la cita a WhatsApp.

---

## ⚡ 4. Fase 3: Pasarelas, Carritos y Escala Avanzada

Enfocada en automatización extrema e integraciones externas.

### 4.1. Integración de Pasarelas de Pago Directo
*   **Flujo de Integración:**
    1. **Stripe/PayPal:** SDK estándar integrando el botón de checkout. Al pagar exitosamente, el webhook de la pasarela actualiza el estado de la orden a `pagada` y notifica al cliente y comercio.
    2. **Binance Pay:** Pago dinámico mediante código QR con API de Binance Merchant.
    3. **Pago Móvil Automático (Venezuela):** Lectura por API de notificaciones bancarias entrantes (SMS/Correo) o a través de alianzas bancarias (BVC o BDV) para corroborar la referencia del pago de forma inmediata sin revisión manual del comercio.

### 4.2. Carritos Abandonados
*   **Estrategia de Telemetría:**
    1. Cuando un usuario agrega un producto al carrito y procede a la fase de ingreso de datos pero no concreta la orden, se almacena en la tabla temporal `abandoned_carts` asociada a su número de teléfono o correo.
    2. **Acción Manual:** El administrador puede ver en su Panel una lista de carritos con un botón: *"Enviar recordatorio por WhatsApp"* que abre una plantilla pre-diseñada:
       *   *«¡Hola [Nombre]! Notamos que dejaste algunos artículos en tu carrito de [Tienda]. Haz clic aquí para completarlo y recibir un 5% de descuento especial...»*

### 4.3. Progressive Web App (PWA)
*   **Implementación:**
    Crear un endpoint `/manifest.json` y `/service-worker.js` dinámicos que utilicen la configuración de la tienda activa (nombre, color primario y logo) para permitir que los usuarios instalen el catálogo de marca blanca en su teléfono como una aplicación nativa.

---

## 📅 5. Plan de Ejecución y Cronograma de Trabajo

A continuación, se detalla el cronograma de sprints sugeridos para llevar a cabo estas implementaciones:

- **Sprint 1 (Fase 1 - Días 1 a 14):**
  - Desarrollo de tabla `coupons` y lógica de validación de cupones de descuento.
  - Implementación de campos SEO en productos/categorías.
  - Sección de pegado de píxeles e inyección dinámica en cabecera del catálogo.

- **Sprint 2 (Fase 2 - Días 15 a 28):**
  - Implementación del Middleware tenant para resolución de dominios propios.
  - Generación de QR atados a números de mesa (`?mesa=X`).
  - Módulo e interfaz para Calendario de Reservas (Booking).

- **Sprint 3 (Fase 3 - Días 29 a 42):**
  - Integración de pasarelas Stripe, Binance Pay y Pago Móvil API.
  - Telemetría de carritos abandonados e integración de Service Workers para PWA.
