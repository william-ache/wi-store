<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - WIStore</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top right, #1e1145 0%, #0a051d 100%);
            min-height: 100vh;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .neon-border {
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.2);
            border-color: rgba(139, 92, 246, 0.4);
        }
        .neon-btn {
            background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
        }
        .neon-btn:hover {
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.6);
            transform: translateY(-2px);
        }
        .neon-btn:active {
            transform: translateY(0);
        }
        .premium-glow {
            text-shadow: 0 0 8px rgba(245, 158, 11, 0.5);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(139, 92, 246, 0.3);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(139, 92, 246, 0.5);
        }
    </style>
</head>
<body class="text-slate-100 overflow-x-hidden pb-12 custom-scrollbar">

    <!-- HEADER -->
    <header class="w-full border-b border-white/5 py-4 px-6 md:px-12 flex justify-between items-center bg-[#0a051d]/85 sticky top-0 z-50 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-violet-500/20">
                <i class="fas fa-cubes text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-black tracking-tight bg-gradient-to-r from-white via-slate-100 to-violet-400 bg-clip-text text-transparent">WYDEX SaaS</h1>
                <span class="text-[10px] text-violet-400 font-bold uppercase tracking-wider">Super Admin Panel</span>
            </div>
        </div>
        <a href="/" class="text-xs font-semibold px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:text-white text-slate-350 transition duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Volver a la Web</span>
        </a>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 mt-8">
        <!-- ALERTS -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center gap-3 animate-fade-in shadow-[0_4px_20px_rgba(16,185,129,0.05)]">
                <i class="fas fa-circle-check text-lg"></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 flex flex-col gap-1 shadow-[0_4px_20px_rgba(244,63,94,0.05)] animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fas fa-circle-exclamation text-lg"></i>
                    <span class="text-sm font-bold">Por favor corrige los siguientes errores:</span>
                </div>
                <ul class="list-disc pl-8 mt-2 text-xs space-y-1 opacity-90">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- MAIN LAYOUT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT PANEL: CREATE COMPANY FORM (5 columns) -->
            <section class="lg:col-span-5 glass-panel rounded-3xl p-6 md:p-8 neon-border shadow-xl">
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-1.5">
                        <i class="fas fa-store-slash text-violet-400"></i>
                        <h2 class="text-xl font-bold text-white tracking-tight">Crear Nueva Tienda</h2>
                    </div>
                    <p class="text-xs text-slate-400">Registra una empresa e inicializa su usuario administrador al instante.</p>
                </div>

                <form action="{{ route('super-admin.shops.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <!-- Shop Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-350 uppercase mb-1.5 tracking-wider">Nombre de la Tienda</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-450 pointer-events-none">
                                <i class="fas fa-shop text-xs text-slate-400"></i>
                            </span>
                            <input type="text" name="name" required placeholder="Ej: Burger Palace" value="{{ old('name') }}"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                        </div>
                    </div>

                    <!-- WhatsApp Number -->
                    <div>
                        <label class="block text-xs font-bold text-slate-350 uppercase mb-1.5 tracking-wider">WhatsApp de Pedidos</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-450 pointer-events-none">
                                <i class="fab fa-whatsapp text-sm text-slate-400"></i>
                            </span>
                            <input type="text" name="whatsapp_number" required placeholder="Ej: +584121234567" value="{{ old('whatsapp_number') }}"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                        </div>
                    </div>

                    <hr class="border-white/5 my-4">

                    <!-- Admin Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-350 uppercase mb-1.5 tracking-wider">Correo del Administrador</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-450 pointer-events-none">
                                <i class="far fa-envelope text-xs text-slate-400"></i>
                            </span>
                            <input type="email" name="email" required placeholder="Ej: admin@burgerpalace.com" value="{{ old('email') }}"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                        </div>
                    </div>

                    <!-- Admin Password -->
                    <div>
                        <label class="block text-xs font-bold text-slate-350 uppercase mb-1.5 tracking-wider">Contraseña de Acceso</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-450 pointer-events-none">
                                <i class="fas fa-lock text-xs text-slate-400"></i>
                            </span>
                            <input type="password" name="password" required placeholder="Mínimo 6 caracteres"
                                   class="w-full bg-white/5 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                        </div>
                    </div>

                    <hr class="border-white/5 my-4">

                    <!-- Colors Grid -->
                    <div>
                        <label class="block text-xs font-bold text-slate-350 uppercase mb-2 tracking-wider">Configuración de Colores</label>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="flex flex-col items-center p-2 rounded-xl bg-white/5 border border-white/5">
                                <span class="text-[9px] font-bold text-slate-450 uppercase mb-1">Primario</span>
                                <input type="color" name="color_primary" value="#E60067" class="w-8 h-8 rounded-full border-0 bg-transparent cursor-pointer">
                            </div>
                            <div class="flex flex-col items-center p-2 rounded-xl bg-white/5 border border-white/5">
                                <span class="text-[9px] font-bold text-slate-450 uppercase mb-1">Secundario</span>
                                <input type="color" name="color_secondary" value="#0B132B" class="w-8 h-8 rounded-full border-0 bg-transparent cursor-pointer">
                            </div>
                            <div class="flex flex-col items-center p-2 rounded-xl bg-white/5 border border-white/5">
                                <span class="text-[9px] font-bold text-slate-450 uppercase mb-1">Fondo</span>
                                <input type="color" name="color_background" value="#FFF0F8" class="w-8 h-8 rounded-full border-0 bg-transparent cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <!-- Plan Selection -->
                    <div>
                        <label class="block text-xs font-bold text-slate-350 uppercase mb-1.5 tracking-wider">Plan de Suscripción</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-450 pointer-events-none">
                                <i class="fas fa-crown text-xs text-slate-400"></i>
                            </span>
                            <select name="plan" required
                                    class="w-full bg-[#0d0926] border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                <option value="standard" selected>Plan Standard (Básico)</option>
                                <option value="premium">Plan Premium (Dorados & Corona)</option>
                                <option value="gold">Plan Gold (Todo Incluido)</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                    </div>

                    <hr class="border-white/5 my-4">

                    <!-- Images Inputs -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Logo Upload -->
                        <div>
                            <label class="block text-xs font-bold text-slate-350 uppercase mb-1 tracking-wider">Logo (Archivo)</label>
                            <input type="file" name="logo" accept="image/*"
                                   class="w-full text-xs text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-violet-600/20 file:text-violet-300 hover:file:bg-violet-600/30 cursor-pointer">
                            <span class="text-[9px] text-slate-500 block mt-1">O escribe URL abajo:</span>
                            <input type="text" name="logo_url" placeholder="http://imagen.com/logo.png" value="{{ old('logo_url') }}"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg py-1.5 px-3 text-xs text-white placeholder-slate-600 mt-1 focus:outline-none focus:border-violet-500">
                        </div>

                        <!-- Cover Upload -->
                        <div>
                            <label class="block text-xs font-bold text-slate-350 uppercase mb-1 tracking-wider">Portada (Archivo)</label>
                            <input type="file" name="cover" accept="image/*"
                                   class="w-full text-xs text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-violet-600/20 file:text-violet-300 hover:file:bg-violet-600/30 cursor-pointer">
                            <span class="text-[9px] text-slate-500 block mt-1">O escribe URL abajo:</span>
                            <input type="text" name="cover_url" placeholder="http://imagen.com/cover.png" value="{{ old('cover_url') }}"
                                   class="w-full bg-white/5 border border-white/10 rounded-lg py-1.5 px-3 text-xs text-white placeholder-slate-600 mt-1 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full neon-btn py-3 px-4 rounded-xl text-sm font-extrabold text-white flex items-center justify-center gap-2 mt-6">
                        <i class="fas fa-plus"></i>
                        <span>Crear Tienda</span>
                    </button>
                </form>
            </section>

            <!-- RIGHT PANEL: SHIPS LIST (7 columns) -->
            <section class="lg:col-span-7 flex flex-col gap-6">
                
                <!-- Table Card -->
                <div class="glass-panel rounded-3xl p-6 md:p-8 shadow-xl">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <i class="fas fa-list text-violet-400"></i>
                                <h2 class="text-xl font-bold text-white tracking-tight">Tiendas Registradas</h2>
                            </div>
                            <p class="text-xs text-slate-400">Lista global y gestión de activación/desactivación.</p>
                        </div>
                        <span class="bg-violet-600/20 border border-violet-500/20 text-violet-300 px-3 py-1 rounded-full text-xs font-black">
                            {{ $shops->count() }} Empresas
                        </span>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 text-slate-400 text-xs font-bold uppercase tracking-wider pb-3">
                                    <th class="py-3 px-4">Tienda / Slug</th>
                                    <th class="py-3 px-4">Administrador</th>
                                    <th class="py-3 px-4">Plan Actual</th>
                                    <th class="py-3 px-4 text-center">Estado</th>
                                    <th class="py-3 px-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shops as $shop)
                                    <tr class="border-b border-white/5 hover:bg-white/[0.01] transition duration-200">
                                        
                                        <!-- Shop Column -->
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-slate-800/80 overflow-hidden border border-white/10 flex items-center justify-center shrink-0">
                                                    @if($shop->logo_path)
                                                        <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path) }}" 
                                                             alt="Logo" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fas fa-store text-slate-500 text-sm"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h3 class="text-sm font-bold text-white">{{ $shop->name }}</h3>
                                                    <a href="/{{ $shop->slug }}" target="_blank" class="text-[10px] text-violet-400 hover:underline font-semibold tracking-wide flex items-center gap-1 mt-0.5">
                                                        <span>/{{ $shop->slug }}</span>
                                                        <i class="fas fa-external-link-alt text-[8px] opacity-75"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Admin Email -->
                                        <td class="py-4 px-4">
                                            <div class="text-xs text-slate-300 font-semibold max-w-[140px] truncate">
                                                {{ $shop->users->first()->email ?? 'Sin admin' }}
                                            </div>
                                        </td>

                                        <!-- Plan -->
                                        <td class="py-4 px-4">
                                            @if($shop->plan === 'gold')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-500/10 border border-amber-500/30 text-amber-400 uppercase tracking-wider premium-glow">
                                                    <i class="fas fa-gem text-[9px]"></i> Gold
                                                </span>
                                            @elseif($shop->plan === 'premium')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-violet-500/10 border border-violet-500/30 text-violet-400 uppercase tracking-wider">
                                                    <i class="fas fa-crown text-[9px]"></i> Premium
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-500/10 border border-slate-500/20 text-slate-400 uppercase tracking-wider">
                                                    <i class="fas fa-award text-[9px]"></i> Standard
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="py-4 px-4 text-center">
                                            @if($shop->is_active)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                    Activo
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500/10 border border-rose-500/30 text-rose-450 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Toggle Status Action -->
                                        <td class="py-4 px-4 text-right">
                                            <form action="{{ route('super-admin.shops.toggle', $shop->id) }}" method="POST" class="inline">
                                                @csrf
                                                @if($shop->is_active)
                                                    <button type="submit" class="text-xs font-black bg-rose-600/10 hover:bg-rose-600 hover:text-white border border-rose-500/20 text-rose-400 px-3 py-1.5 rounded-xl transition duration-200">
                                                        Desactivar
                                                    </button>
                                                @else
                                                    <button type="submit" class="text-xs font-black bg-emerald-600/10 hover:bg-emerald-600 hover:text-white border border-emerald-500/20 text-emerald-400 px-3 py-1.5 rounded-xl transition duration-200">
                                                        Activar
                                                    </button>
                                                @endif
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500 text-xs font-semibold">
                                            <i class="fas fa-info-circle text-lg mb-2 block"></i>
                                            No hay tiendas registradas aún.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>

        </div>
    </main>

</body>
</html>
