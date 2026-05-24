@extends('layouts.admin')

@section('title', 'Tutoriales del Sistema')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- CABECERA DE LA PÁGINA -->
    <div>
        <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-white tracking-tight">Tutoriales del sistema</h2>
        <p class="text-xs text-slate-450 dark:text-slate-500 font-semibold mt-0.5">
            Aprende a dominar cada herramienta y saca el máximo provecho a tu tienda digital
        </p>
    </div>

    <!-- SECCIÓN DE VIDEO TUTORIALES -->
    <div class="space-y-4">
        <h3 class="text-sm font-black text-slate-850 dark:text-white uppercase tracking-wider pl-1 select-none">
            Video Guías Rápidas
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $videos = [
                    [
                        'title' => 'Configura tu tienda por primera vez 🚀',
                        'duration' => '5:12 min',
                        'desc' => 'Aprende los primeros pasos esenciales para establecer la identidad de tu negocio.',
                        'bg' => 'from-purple-600 to-indigo-600',
                        'topic' => 'Configuración Inicial'
                    ],
                    [
                        'title' => 'Gestión de Productos e Inventario 📦',
                        'duration' => '4:30 min',
                        'desc' => 'Cómo registrar productos, categorías, precios y fotos atractivas paso a paso.',
                        'bg' => 'from-cyan-500 to-blue-600',
                        'topic' => 'Catálogo Digital'
                    ],
                    [
                        'title' => 'Gestión de Pedidos en Tiempo Real 🛒',
                        'duration' => '3:45 min',
                        'desc' => 'Domina el recibo de notificaciones y la sincronización con pedidos de WhatsApp.',
                        'bg' => 'from-emerald-500 to-teal-600',
                        'topic' => 'Flujo de Ventas'
                    ],
                    [
                        'title' => 'Configuración de Apariencia y Colores 🎨',
                        'duration' => '6:15 min',
                        'desc' => 'Personaliza el logo, banner y los tonos de tu marca para cautivar clientes.',
                        'bg' => 'from-rose-500 to-pink-600',
                        'topic' => 'Branding y Activos'
                    ],
                ];
            @endphp

            @foreach($videos as $video)
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-3xl overflow-hidden shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md hover:scale-[1.02] group cursor-pointer"
                 onclick="Swal.fire({
                     title: '{{ $video['title'] }}',
                     html: '<div class=\'rounded-2xl overflow-hidden bg-slate-950 aspect-video flex items-center justify-center border border-white/10 shadow-inner\'><div class=\'text-center\'><i class=\'fas fa-play text-4xl text-purple-400 animate-pulse\'></i><p class=\'text-[10px] text-slate-450 mt-3 font-semibold uppercase tracking-wider\'>Cargando Sesión de Video Entrenamiento...</p></div></div><p class=\'text-xs text-slate-400 mt-4 leading-relaxed\'>Estamos preparando tu lección práctica guiada de <strong>{{ $video['topic'] }}</strong>. ¡Prepara tus audífonos!</p>',
                     confirmButtonText: 'Comenzar a ver',
                     confirmButtonColor: 'var(--color-primary, #E60067)',
                     background: '#0d1127',
                     color: '#fff',
                     customClass: {
                         popup: 'rounded-3xl border border-white/10 p-6',
                         title: 'font-black text-base text-white tracking-tight',
                         confirmButton: 'font-extrabold text-xs uppercase tracking-widest px-6 py-3.5 rounded-xl border border-white/10 active:scale-[0.98] transition-all'
                     }
                 })">
                
                <!-- Thumbnail Mockup -->
                <div class="relative aspect-video bg-gradient-to-br {{ $video['bg'] }} flex items-center justify-center overflow-hidden shrink-0 select-none">
                    <!-- Grid Overlay -->
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(255,255,255,0.15),transparent)]"></div>
                    
                    <!-- Play Overlay Button -->
                    <div class="w-12 h-12 rounded-full bg-white/25 backdrop-blur-md flex items-center justify-center text-white border border-white/20 transition-all duration-300 group-hover:scale-110 group-hover:bg-white group-hover:text-slate-950 shadow-[0_0_20px_rgba(255,255,255,0.25)]">
                        <svg class="w-4 h-4 ml-0.5 fill-current" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    </div>

                    <!-- Tags -->
                    <span class="absolute top-3 left-3 bg-slate-950/40 backdrop-blur-md text-[8px] font-black text-white px-2 py-0.5 rounded-full border border-white/10 uppercase tracking-widest">
                        {{ $video['topic'] }}
                    </span>

                    <span class="absolute bottom-3 right-3 bg-slate-950/60 backdrop-blur-md text-[9px] font-bold text-white px-2 py-0.5 rounded-lg border border-white/5">
                        {{ $video['duration'] }}
                    </span>
                </div>

                <!-- Info Box -->
                <div class="p-5 flex-grow flex flex-col justify-between space-y-2.5">
                    <div>
                        <h4 class="text-xs sm:text-sm font-black text-slate-800 dark:text-white leading-snug group-hover:text-purple-650 dark:group-hover:text-purple-400 transition-colors">
                            {{ $video['title'] }}
                        </h4>
                        <p class="text-[11px] text-slate-450 dark:text-slate-500 font-semibold leading-relaxed mt-1.5">
                            {{ $video['desc'] }}
                        </p>
                    </div>

                    <span class="text-[10px] font-extrabold text-primary group-hover:underline flex items-center gap-1 select-none pt-2">
                        Ver lección →
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- SECCIÓN DE PREGUNTAS FRECUENTES (ACCORDION) -->
    <div class="space-y-4" x-data="{ active: null }">
        <h3 class="text-sm font-black text-slate-850 dark:text-white uppercase tracking-wider pl-1 select-none">
            Preguntas Frecuentes (FAQ)
        </h3>

        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-[28px] overflow-hidden shadow-sm transition-colors duration-300">
            @php
                $faqs = [
                    [
                        'q' => '¿Cómo configuro mi número de WhatsApp para recibir los pedidos?',
                        'a' => 'Dirígete al módulo de <strong>Configuración</strong> en el menú lateral. En la sección de datos básicos, completa el campo <strong>Número de WhatsApp</strong> ingresando tu número con su código de país sin el símbolo "+" (ej. para Bolivia: 591XXXXXXXX). Guarda los cambios. A partir de ese momento, todos los clientes que presionen "Enviar pedido" en tu menú digital completarán su carrito de compras y te enviarán los datos formateados a tu chat de WhatsApp automáticamente.'
                    ],
                    [
                        'q' => '¿Cómo activo o desactivo los módulos del menú lateral de administración?',
                        'a' => 'Si deseas cambiar qué elementos son visibles en la navegación lateral, dirígete a <strong>Configuración</strong>, haz clic en la pestaña <strong>Apariencia & Activos</strong>, y marca o desmarca los módulos requeridos (ej. Categorías, Productos, Pedidos, Clientes, Marketing). También puedes volver a activar el configurador guiado inicial cuando gustes, ingresando directamente a la URL de tu tienda con la ruta <strong>/admin/setup-modules</strong>.'
                    ],
                    [
                        'q' => '¿Cómo funciona la descarga e impresión del Código QR del catálogo?',
                        'a' => 'En la cabecera superior derecha del panel administrativo (al lado izquierdo de la campana de notificaciones), encontrarás un botón con el ícono de **Código QR**. Al hacer clic, se desplegará el modal premium "Compartir catálogo". Desde allí podrás:
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>Copiar el enlace público al portapapeles.</li>
                            <li>Compartir en WhatsApp, Facebook e Instagram de forma asistida.</li>
                            <li>Hacer clic en <strong>Descargar</strong> para guardar un archivo PNG de alta definición con el Código QR de tu menú personalizado en el color de tu marca comercial. Puedes imprimir esta imagen y colocarla en las mesas, mostradores o folletos de tu negocio para que tus comensales lo escaneen directamente.</li>
                        </ul>'
                    ],
                    [
                        'q' => '¿Cómo actualizo o renuevo mi plan de suscripción comercial?',
                        'a' => 'Ingresa al módulo de <strong>Suscripción</strong> en la barra de navegación lateral. Allí podrás revisar tu consumo actual y los límites permitidos de productos y categorías. Si necesitas escalar, simplemente haz clic en <strong>"Cambiar a Pro"</strong> o <strong>"Contactar a ventas"</strong>. Serás redirigido a la pasarela integrada de Pago Móvil, donde podrás realizar la transferencia en Bolivianos (Bs) a los datos suministrados y subir tu captura del comprobante con la referencia bancaria. Tu activación se validará a la brevedad.'
                    ],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="border-b border-slate-50 dark:border-slate-800/40 last:border-0">
                <!-- FAQ Header Button -->
                <button type="button" 
                        @click="active = (active === {{ $index }} ? null : {{ $index }})"
                        class="w-full flex items-center justify-between text-left px-6 py-5 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors cursor-pointer select-none">
                    <span class="text-xs sm:text-sm font-extrabold text-slate-700 dark:text-slate-200 tracking-tight pr-4">
                        {{ $faq['q'] }}
                    </span>
                    <span class="text-slate-450 dark:text-slate-500 shrink-0 transition-transform duration-300"
                          :class="active === {{ $index }} ? 'rotate-180 text-primary' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </button>

                <!-- FAQ Body Content -->
                <div x-show="active === {{ $index }}" 
                     x-collapse 
                     x-cloak
                     class="px-6 pb-6 text-xs text-slate-500 dark:text-slate-400 font-semibold leading-relaxed border-t border-slate-50/30 dark:border-slate-800/10 pt-4 bg-slate-50/20 dark:bg-slate-800/10">
                    {!! $faq['a'] !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
