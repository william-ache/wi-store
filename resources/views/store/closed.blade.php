<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tienda No Disponible - {{ $company['name'] }}</title>

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --color-primary: {{ $company['colors']['primary'] ?? '#8B5CF6' }};
            --color-secondary: {{ $company['colors']['secondary'] ?? '#0a051d' }};
            --color-bg: {{ $company['colors']['bg_light'] ?? '#0b0f19' }};
        }

        body {
            font-family: 'Outfit', 'sans-serif';
            background: radial-gradient(circle at top, rgba(139, 92, 246, 0.15) 0%, rgba(10, 5, 29, 1) 100%), var(--color-bg);
            color: #f3f4f6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .neon-glow-btn {
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
        }

        .neon-glow-btn:hover {
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.8);
            transform: translateY(-2px);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .closed-image-glow {
            filter: drop-shadow(0 0 20px rgba(139, 92, 246, 0.3));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) scale(1);
            }
            50% {
                transform: translateY(-10px) scale(1.02);
            }
        }

        .star-pulse {
            animation: pulse 2s infinite alternate;
        }

        @keyframes pulse {
            0% { opacity: 0.3; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1.1); }
        }
    </style>
</head>

<body class="flex flex-col justify-between">

    <!-- Header Navigation -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
        <a href="#" class="flex items-center gap-3">
            <img src="{{ $company['logo'] }}" alt="Logo" class="w-10 h-10 rounded-full object-cover border border-purple-500/30">
            <span class="text-xl font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-white via-purple-200 to-purple-400">
                {{ strtoupper($company['name']) }}
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-400">
            <a href="#" class="hover:text-purple-400 transition-colors">INICIO</a>
            <a href="#" class="hover:text-purple-400 transition-colors">TIENDA</a>
            <a href="#" class="hover:text-purple-400 transition-colors">CONTACTO</a>
            <a href="#" class="relative hover:text-purple-400 transition-colors">
                <i class="fa-solid fa-shopping-cart text-lg"></i>
            </a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-12 text-center max-w-4xl mx-auto z-10 relative">
        
        <!-- Decorative Glow Background Effects -->
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-72 h-72 bg-purple-600/10 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-10 left-1/3 w-60 h-60 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Heading Text -->
        <div class="space-y-4 mb-8">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white uppercase leading-tight">
                ¡Lo sentimos!<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400">
                    Esta tienda no está disponible
                </span><br>
                por el momento.
            </h1>
            <p class="text-gray-400 max-w-xl mx-auto text-base md:text-lg leading-relaxed">
                Estamos realizando tareas de mantenimiento necesarias para mejorar tu experiencia de compra. Volveremos a estar operativos muy pronto. ¡Gracias por tu comprensión y paciencia!
            </p>
        </div>

        <!-- Illustration -->
        <div class="mb-10 w-full max-w-sm md:max-w-md mx-auto">
            <img src="{{ asset('images/local_cerrado.png') }}" alt="Local Cerrado" class="w-full h-auto closed-image-glow rounded-2xl">
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-2xl mb-10 text-left">
            <!-- Left Info Panel -->
            <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 transition-all duration-500"></div>
                <h3 class="text-purple-300 font-bold text-lg mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-purple-500 rounded-full animate-ping"></span>
                    Mantente Informado:
                </h3>
                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-chevron-right text-purple-400/80"></i>
                        <span>Últimas Novedades</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-chevron-right text-purple-400/80"></i>
                        <span>Estado del Sistema</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-chevron-right text-purple-400/80"></i>
                        <span>Estado del Servidor</span>
                    </li>
                </ul>
            </div>

            <!-- Right Info Panel -->
            <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-pink-500/5 rounded-full blur-2xl group-hover:bg-pink-500/10 transition-all duration-500"></div>
                <h3 class="text-pink-300 font-bold text-lg mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-pink-400"></i>
                    Síguenos en Redes:
                </h3>
                
                <div class="flex flex-wrap gap-4 mb-4">
                    @if(!empty($company['instagram']))
                        <a href="{{ $company['instagram'] }}" target="_blank" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center hover:bg-gradient-to-tr hover:from-purple-600 hover:to-pink-500 hover:scale-110 transition-all duration-300">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                    @endif
                    @if(!empty($company['facebook']))
                        <a href="{{ $company['facebook'] }}" target="_blank" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center hover:bg-blue-600 hover:scale-110 transition-all duration-300">
                            <i class="fa-brands fa-facebook-f text-lg"></i>
                        </a>
                    @endif
                    @if(!empty($company['tiktok']))
                        <a href="{{ $company['tiktok'] }}" target="_blank" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center hover:bg-black hover:border-pink-500 hover:scale-110 transition-all duration-300">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </a>
                    @endif
                    @if(!empty($company['x_twitter']))
                        <a href="{{ $company['x_twitter'] }}" target="_blank" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center hover:bg-neutral-800 hover:scale-110 transition-all duration-300">
                            <i class="fa-brands fa-x-twitter text-lg"></i>
                        </a>
                    @endif
                    @if(!empty($company['telegram']))
                        <a href="{{ $company['telegram'] }}" target="_blank" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center hover:bg-blue-500 hover:scale-110 transition-all duration-300">
                            <i class="fa-brands fa-telegram text-lg"></i>
                        </a>
                    @endif
                    @if(!empty($company['whatsapp']))
                        @php
                            $waNum = '';
                            if (str_contains($company['whatsapp'], ':')) {
                                $parts = explode(',', $company['whatsapp']);
                                $firstPart = explode(':', $parts[0]);
                                $waNum = end($firstPart);
                            } else {
                                $waNum = $company['whatsapp'];
                            }
                            $waNum = preg_replace('/[^0-9]/', '', $waNum);
                        @endphp
                        <a href="https://wa.me/{{ $waNum }}" target="_blank" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center hover:bg-emerald-600 hover:scale-110 transition-all duration-300">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    @endif
                </div>

                <div class="text-sm text-gray-400">
                    Contacto directo vía redes sociales o WhatsApp.
                </div>
            </div>
        </div>

        <!-- Back Button / Action -->
        <div>
            @if(!empty($company['whatsapp']))
                @php
                    $waNum = '';
                    if (str_contains($company['whatsapp'], ':')) {
                        $parts = explode(',', $company['whatsapp']);
                        $firstPart = explode(':', $parts[0]);
                        $waNum = end($firstPart);
                    } else {
                        $waNum = $company['whatsapp'];
                    }
                    $waNum = preg_replace('/[^0-9]/', '', $waNum);
                @endphp
                <a href="https://wa.me/{{ $waNum }}" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-full neon-glow-btn text-base">
                    <i class="fa-brands fa-whatsapp text-xl"></i>
                    CONTACTAR CON SOPORTE
                </a>
            @else
                <a href="#" onclick="window.location.reload();" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-full neon-glow-btn text-base">
                    <i class="fa-solid fa-rotate-right"></i>
                    REINTENTAR ACCESO
                </a>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-6 py-12 border-t border-purple-500/10 text-center md:text-left z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div class="space-y-4">
                <div class="flex items-center justify-center md:justify-start gap-3">
                    <img src="{{ $company['logo'] }}" alt="Logo" class="w-8 h-8 rounded-full object-cover">
                    <span class="text-lg font-bold tracking-wider text-white">
                        {{ strtoupper($company['name']) }}
                    </span>
                </div>
                <p class="text-xs text-gray-400 max-w-sm mx-auto md:mx-0">
                    Menú digital inteligente y autogestionable de última generación.
                </p>
            </div>
            
            <div class="space-y-2 md:col-span-2 flex flex-col md:flex-row md:justify-end gap-x-8 gap-y-2 text-xs text-gray-400">
                <div>
                    <span class="font-semibold text-purple-300 block mb-1">Quick Links</span>
                    <div class="flex flex-wrap justify-center md:justify-end gap-x-4 gap-y-1">
                        <a href="#" class="hover:text-purple-400 transition-colors">Simplificied</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">Términos de Servicio</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">Privacidad</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">Contacto</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500 border-t border-purple-500/5 pt-6">
            <p>&copy; {{ date('Y') }} {{ $company['name'] }}. Todos los derechos reservados.</p>
            <div class="flex gap-4">
                @if(!empty($company['instagram']))
                    <a href="{{ $company['instagram'] }}" target="_blank" class="hover:text-purple-400"><i class="fa-brands fa-instagram text-sm"></i></a>
                @endif
                @if(!empty($company['facebook']))
                    <a href="{{ $company['facebook'] }}" target="_blank" class="hover:text-purple-400"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                @endif
                @if(!empty($company['tiktok']))
                    <a href="{{ $company['tiktok'] }}" target="_blank" class="hover:text-purple-400"><i class="fa-brands fa-tiktok text-sm"></i></a>
                @endif
                @if(!empty($company['x_twitter']))
                    <a href="{{ $company['x_twitter'] }}" target="_blank" class="hover:text-purple-400"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>
