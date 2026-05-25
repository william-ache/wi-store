<!DOCTYPE html>
<html lang="es" class="wistore-ui">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Políticas y Privacidad - WIStore</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('partials.global.wistore-scrollbar')
    <style>
body {
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
/* GPU hardware acceleration */
        .gpu-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: transform;
        }
        .blur-accelerated {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            will-change: filter;
        }
    </style>
</head>
<body class="bg-[#070913] text-gray-100 min-h-screen selection:bg-purple-500 selection:text-white relative">

    <!-- CAPA DE FONDO GLOBAL (Base Canvas & Neón GPU) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none bg-[#070913] gpu-accelerated">
        <div class="absolute -top-[10%] -right-[5%] w-[600px] h-[600px] rounded-full bg-gradient-to-r from-purple-600/20 to-indigo-600/20 blur-[120px] blur-accelerated"></div>
        <div class="absolute top-[40%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-r from-cyan-500/10 to-blue-600/10 blur-[160px] blur-accelerated"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[700px] h-[700px] rounded-full bg-gradient-to-r from-pink-600/10 via-purple-600/10 to-transparent blur-[160px] blur-accelerated"></div>

        <svg class="absolute inset-0 w-full h-full opacity-35" preserveAspectRatio="none" viewBox="0 0 1440 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="neonGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.8" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.4" />
                    <stop offset="100%" stop-color="#a855f7" stop-opacity="0" />
                </linearGradient>
                <linearGradient id="neonGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                    <stop offset="50%" stop-color="#ec4899" stop-opacity="0.3" />
                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0" />
                </linearGradient>
            </defs>
            <path d="M-100,100 C200,300 400,-100 800,200 C1200,500 1300,900 1500,800" stroke="url(#neonGradient1)" stroke-width="1.5" stroke-linecap="round" fill="none" />
            <path d="M1500,-50 C1100,150 1000,500 600,600 C200,700 0,1100 -200,1000" stroke="url(#neonGradient2)" stroke-width="1.5" stroke-linecap="round" fill="none" />
        </svg>
    </div>

    <!-- Botón Flotante Volver -->
    <a href="{{ route('home') }}" class="fixed top-6 left-6 md:top-8 md:left-8 z-50 bg-[#0d1127]/80 backdrop-blur-md border border-white/10 hover:border-purple-500/50 text-white font-bold px-4 py-2.5 rounded-full shadow-lg flex items-center gap-2 transition-all duration-300 text-xs md:text-sm group">
        <i class="fas fa-arrow-left text-purple-400 group-hover:-translate-x-1 transition-transform"></i>
        <span>Volver al Inicio</span>
    </a>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="relative z-10 py-24 md:py-32 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        
        <!-- Cabecera -->
        <div class="text-center mb-16">
            <span class="bg-purple-600/20 text-purple-400 text-[10px] uppercase font-black tracking-widest px-4 py-1.5 rounded-full border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.2)]">
                Marco Legal
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white mt-5 tracking-tight">Políticas y Privacidad</h1>
            <p class="text-sm md:text-base text-slate-400 mt-3 max-w-2xl mx-auto leading-relaxed">
                En WIStore nos tomamos muy en serio la seguridad y el tratamiento de los datos. Conoce las directrices y términos de servicio bajo los cuales opera nuestro ecosistema.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Menú Lateral ÍNDICE (Sticky) -->
            <div class="hidden lg:block lg:col-span-1">
                <div class="sticky top-28 bg-[#0d1127]/40 backdrop-blur-md border border-white/5 rounded-2xl p-5 space-y-4">
                    <h3 class="text-xs uppercase font-black text-slate-300 tracking-wider mb-2">Índice</h3>
                    <ul class="space-y-3 text-xs">
                        <li><a href="#introduccion" class="block text-slate-400 hover:text-cyan-400 transition-colors font-bold">1. Introducción</a></li>
                        <li><a href="#datos" class="block text-slate-400 hover:text-cyan-400 transition-colors font-bold">2. Datos Recopilados</a></li>
                        <li><a href="#seguridad" class="block text-slate-400 hover:text-cyan-400 transition-colors font-bold">3. Seguridad</a></li>
                        <li><a href="#cookies" class="block text-slate-400 hover:text-cyan-400 transition-colors font-bold">4. Política de Cookies</a></li>
                        <li><a href="#terminos" class="block text-slate-400 hover:text-purple-400 transition-colors font-bold">5. Términos de Servicio</a></li>
                        <li><a href="#contacto" class="block text-slate-400 hover:text-purple-400 transition-colors font-bold">6. Consultas Legales</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contenido Legal Glassmorphic -->
            <div class="col-span-1 lg:col-span-3 bg-[#0d1127]/50 backdrop-blur-xl border border-white/10 rounded-3xl p-6 md:p-10 space-y-10 text-xs md:text-sm text-slate-300 leading-relaxed">
                
                <!-- 1. Introducción -->
                <section id="introduccion" class="space-y-4 scroll-mt-28">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-cyan-400">1.</span> Introducción y Aceptación
                    </h2>
                    <p>
                        Bienvenido a WIStore, operado por Wydex. Al registrarte y utilizar nuestra plataforma de catálogos digitales interactivos y árbol de enlaces, declaras estar de acuerdo con las presentes políticas de privacidad y los términos de servicio expuestos en este documento.
                    </p>
                    <p>
                        Nos comprometemos a garantizar que los datos de tu marca y de tus clientes finales se traten con la máxima confidencialidad bajo estándares modernos de encriptación y seguridad digital.
                    </p>
                </section>

                <!-- 2. Datos Recopilados -->
                <section id="datos" class="space-y-4 scroll-mt-28">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-cyan-400">2.</span> Datos que Recopilamos
                    </h2>
                    <p>
                        Para que puedas disfrutar de la experiencia completa de WIStore, recopilamos información dividida en dos categorías primarias:
                    </p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Datos del Comercio (Tus Datos):</strong> Nombre, Correo electrónico, número de teléfono asociado a WhatsApp, credenciales básicas para el Panel de Control y tokens de marca (logos, colores, banners de productos).</li>
                        <li><strong>Datos del Consumidor Final:</strong> Cuando un cliente final monta un pedido a tu WhatsApp a través de tu catálogo híbrido, almacenamos temporalmente en el caché del navegador los datos que introduce (Nombre, Dirección, Método de Pago) únicamente para agilizar el despacho y estructurar el mensaje que se enviará a tu número de WhatsApp de soporte.</li>
                    </ul>
                </section>

                <!-- 3. Seguridad -->
                <section id="seguridad" class="space-y-4 scroll-mt-28">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-cyan-400">3.</span> Seguridad e Infraestructura
                    </h2>
                    <p>
                        Toda la información viaja bajo protocolo seguro **HTTPS con certificado SSL de 256 bits**. Las contraseñas del Panel del Administrador están hasheadas mediante algoritmos robustos unidireccionales (Bcrypt).
                    </p>
                    <p>
                        El alojamiento compartido y bases de datos dedicadas se encuentran desplegados en servidores cloud de alto rendimiento con firewalls robustos para mitigar cualquier intento de acceso no autorizado o ataques de denegación de servicio (DDoS).
                    </p>
                </section>

                <!-- 4. Política de Cookies -->
                <section id="cookies" class="space-y-4 scroll-mt-28">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-cyan-400">4.</span> Política de Cookies
                    </h2>
                    <p>
                        Utilizamos cookies operacionales estrictamente necesarias para el correcto funcionamiento del carrito de compras y el inicio de sesión. No utilizamos cookies de rastreo publicitario de terceros que comprometan tu navegación ni la privacidad del usuario final.
                    </p>
                </section>

                <!-- 5. Términos de Servicio -->
                <section id="terminos" class="space-y-4 scroll-mt-28 border-t border-white/10 pt-8">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-purple-400">5.</span> Términos de Servicio y 0% Comisiones
                    </h2>
                    <p>
                        **WIStore** opera bajo un modelo de suscripción mensual basado en tarifas fijas indexadas al dólar estadounidense, pero pagadas exclusivamente en **Bolívares (Bs.) al tipo de cambio oficial publicado por el Banco Central de Venezuela (BCV)**.
                    </p>
                    <p>
                        Garantizamos que **jamás cobraremos comisiones por las ventas que efectúes en tus catálogos**. Tus ganancias son 100% tuyas. Eres responsable de la veracidad y legalidad de los productos que ofrezcas en tu plataforma. Queda estrictamente prohibida la comercialización de artículos ilícitos, armas de fuego o sustancias controladas bajo leyes de la República Bolivariana de Venezuela.
                    </p>
                </section>

                <!-- 6. Consultas Legales -->
                <section id="contacto" class="space-y-4 scroll-mt-28">
                    <h2 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="text-purple-400">6.</span> Dudas y Consultas Legales
                    </h2>
                    <p>
                        Si tienes alguna duda o sugerencia sobre nuestro marco legal, nuestro tratamiento de bases de datos o deseas solicitar la eliminación completa de los datos de tu comercio afiliado, puedes escribir de manera directa a nuestro departamento legal:
                    </p>
                    <div class="bg-white/[0.02] border border-white/5 p-4 rounded-xl flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <p class="font-extrabold text-white">Wydex Ecosistemas Digitales</p>
                            <p class="text-slate-400 text-xs">Área de Cumplimiento Normativo y Privacidad</p>
                        </div>
                        <a href="mailto:{{ $wistoreSupportEmail }}"
                            class="bg-purple-600/20 text-purple-300 border border-purple-500/25 font-extrabold px-6 py-2.5 rounded-lg text-xs hover:bg-purple-600/30 hover:text-white transition-colors break-all">
                            {{ $wistoreSupportEmail }}
                        </a>
                    </div>
                </section>

            </div>
        </div>

    </main>

    <!-- FOOTER LIGERO -->
    <footer class="border-t border-white/5 py-8 text-center text-xs text-slate-500 relative z-10">
        <p>© 2026 WIStore. Todos los derechos reservados.</p>
    </footer>

    @include('partials.public.chat')
</body>
</html>
