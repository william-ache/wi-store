@php
    $shopPlan = strtolower($shop->plan ?? 'standard');

    $planThemes = [
        'free_trial' => [
            'label' => 'Prueba gratuita',
            'icon' => '⚡',
            'badge' => 'bg-purple-500/15 border-purple-400/25 text-purple-200',
            'blob_a' => 'from-purple-600/25 to-fuchsia-500/10',
            'blob_b' => 'from-cyan-500/15 to-blue-600/10',
            'logo_gradient' => 'from-purple-400 to-cyan-400',
            'primary' => '#a855f7',
            'secondary' => '#22d3ee',
            'btn_gradient' => 'from-purple-500 via-fuchsia-500 to-cyan-400',
            'btn_hover' => 'hover:from-purple-400 hover:via-fuchsia-400 hover:to-cyan-300',
            'glow' => 'rgba(168, 85, 247, 0.4)',
            'card_border' => 'border-purple-500/20',
            'selected_bg' => 'bg-purple-500/10',
            'selected_border' => 'border-purple-400/50',
            'check_bg' => 'bg-purple-500',
        ],
        'standard' => [
            'label' => 'Plan Standard',
            'icon' => '⚡',
            'badge' => 'bg-sky-500/15 border-sky-400/25 text-sky-200',
            'blob_a' => 'from-sky-500/25 to-blue-600/10',
            'blob_b' => 'from-indigo-500/15 to-cyan-500/10',
            'logo_gradient' => 'from-sky-400 to-indigo-400',
            'primary' => '#0ea5e9',
            'secondary' => '#6366f1',
            'btn_gradient' => 'from-sky-500 via-blue-500 to-indigo-500',
            'btn_hover' => 'hover:from-sky-400 hover:via-blue-400 hover:to-indigo-400',
            'glow' => 'rgba(14, 165, 233, 0.4)',
            'card_border' => 'border-sky-500/20',
            'selected_bg' => 'bg-sky-500/10',
            'selected_border' => 'border-sky-400/50',
            'check_bg' => 'bg-sky-500',
        ],
        'premium' => [
            'label' => 'Plan Premium',
            'icon' => '👑',
            'badge' => 'bg-emerald-500/15 border-amber-400/25 text-emerald-200',
            'blob_a' => 'from-emerald-500/20 to-teal-500/10',
            'blob_b' => 'from-amber-500/15 to-yellow-500/10',
            'logo_gradient' => 'from-emerald-400 to-amber-400',
            'primary' => $shop->color_primary ?? '#10b981',
            'secondary' => $shop->color_secondary ?? '#f59e0b',
            'btn_gradient' => 'from-emerald-500 via-teal-500 to-amber-400',
            'btn_hover' => 'hover:brightness-110',
            'glow' => 'rgba(16, 185, 129, 0.35)',
            'card_border' => 'border-emerald-500/20',
            'selected_bg' => 'bg-emerald-500/10',
            'selected_border' => 'border-emerald-400/50',
            'check_bg' => 'bg-emerald-500',
        ],
    ];

    $theme = $planThemes[$shopPlan] ?? $planThemes['standard'];

    if ($shopPlan === 'premium') {
        $theme['btn_gradient'] = null;
    }

    $modules = [
        ['key' => 'categories', 'icon' => 'fa-layer-group', 'emoji' => '📦', 'title' => 'Categorías', 'desc' => 'Organiza tu menú por grupos y secciones.'],
        ['key' => 'products', 'icon' => 'fa-burger', 'emoji' => '🍔', 'title' => 'Productos', 'desc' => 'Precios, fotos, descripciones y disponibilidad.'],
        ['key' => 'orders', 'icon' => 'fa-clipboard-list', 'emoji' => '📋', 'title' => 'Pedidos', 'desc' => 'Recibe y gestiona pedidos en tiempo real.'],
        ['key' => 'clients', 'icon' => 'fa-users', 'emoji' => '👥', 'title' => 'Clientes', 'desc' => 'Historial y contacto de compradores.'],
        ['key' => 'invoices', 'icon' => 'fa-file-invoice', 'emoji' => '🧾', 'title' => 'Facturas', 'desc' => 'Comprobantes y reportes de ventas.'],
        ['key' => 'delivery', 'icon' => 'fa-motorcycle', 'emoji' => '🛵', 'title' => 'Delivery', 'desc' => 'Tarifas, zonas y opciones de envío.'],
        ['key' => 'analytics', 'icon' => 'fa-chart-line', 'emoji' => '📊', 'title' => 'Analítica', 'desc' => 'Estadísticas y rendimiento del negocio.'],
        ['key' => 'referrals', 'icon' => 'fa-link', 'emoji' => '🔗', 'title' => 'Referidos', 'desc' => 'Enlaces de recomendación y promotores.'],
        ['key' => 'announcements', 'icon' => 'fa-bullhorn', 'emoji' => '📢', 'title' => 'Marketing', 'desc' => 'Banners y promociones en tu menú digital.', 'wide' => true],
    ];
@endphp
<!DOCTYPE html>
<html lang="es" class="scroll-smooth wistore-ui">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configura tu menú | {{ $shop->name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @include('partials.global.wistore-scrollbar')
    <style>
        [x-cloak] { display: none !important; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #06080f;
            --plan-primary: {{ $theme['primary'] }};
            --plan-secondary: {{ $theme['secondary'] }};
            --plan-glow: {{ $theme['glow'] }};
        }

        .plan-card {
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.06), 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 60px var(--plan-glow);
        }

        .module-selected {
            background: color-mix(in srgb, var(--plan-primary) 12%, transparent);
            border-color: color-mix(in srgb, var(--plan-primary) 45%, transparent);
            box-shadow: 0 0 24px color-mix(in srgb, var(--plan-primary) 18%, transparent);
        }

        .module-check {
            background: var(--plan-primary);
            border-color: var(--plan-primary);
        }

        .icon-selected {
            background: color-mix(in srgb, var(--plan-primary) 22%, transparent);
            color: white;
        }

        .btn-plan {
            background: linear-gradient(135deg, var(--plan-primary) 0%, var(--plan-secondary) 100%);
            box-shadow: 0 4px 14px color-mix(in srgb, var(--plan-primary) 35%, transparent),
                        0 12px 40px color-mix(in srgb, var(--plan-primary) 25%, transparent),
                        inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .btn-plan:hover {
            box-shadow: 0 6px 20px color-mix(in srgb, var(--plan-primary) 45%, transparent),
                        0 16px 48px color-mix(in srgb, var(--plan-secondary) 30%, transparent),
                        inset 0 1px 0 rgba(255, 255, 255, 0.35);
            transform: translateY(-1px);
        }

        .btn-plan::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.2) 50%, transparent 60%);
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        .btn-plan:hover::before {
            opacity: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .float-blob { animation: float 10s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen text-slate-100 flex flex-col relative overflow-x-hidden"
      style="--selection-bg: var(--plan-primary);">

    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-[15%] -right-[8%] w-[min(600px,90vw)] h-[min(600px,90vw)] rounded-full bg-gradient-to-br {{ $theme['blob_a'] }} blur-[100px] float-blob"></div>
        <div class="absolute bottom-[10%] -left-[12%] w-[min(500px,80vw)] h-[min(500px,80vw)] rounded-full bg-gradient-to-tr {{ $theme['blob_b'] }} blur-[120px] float-blob" style="animation-delay: -4s;"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(255,255,255,0.03),transparent_55%)]"></div>
    </div>

    <header class="w-full max-w-4xl mx-auto px-5 sm:px-6 py-5 flex items-center justify-between relative z-10">
        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-lg font-black text-white tracking-wide">
                WI<span class="text-transparent bg-clip-text bg-gradient-to-r {{ $theme['logo_gradient'] }}">Store</span>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $theme['badge'] }}">
                {{ $theme['icon'] }} {{ $theme['label'] }}
            </span>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-[11px] font-bold text-slate-500 hover:text-rose-400 flex items-center gap-1.5 transition-colors">
                <i class="fas fa-sign-out-alt text-[10px]"></i> Salir
            </button>
        </form>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 py-6 pb-10 relative z-10"
          x-data="{
              selectedModules: ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals'],
              toggleModule(module) {
                  if (this.selectedModules.includes(module)) {
                      this.selectedModules = this.selectedModules.filter(m => m !== module);
                  } else {
                      this.selectedModules.push(module);
                  }
              }
          }">

        <div class="w-full max-w-3xl">
            <div class="plan-card w-full bg-[#0c101c]/75 backdrop-blur-2xl border {{ $theme['card_border'] }} rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-9 relative overflow-hidden">

                <div class="absolute top-0 left-0 right-0 h-1 rounded-t-[2.5rem] opacity-80"
                     style="background: linear-gradient(90deg, var(--plan-primary), var(--plan-secondary));"></div>

                <div class="text-center mb-8 relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-white/[0.04] mb-5">
                        <span class="w-2 h-2 rounded-full animate-pulse" style="background: var(--plan-primary);"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">
                            Primer ingreso · Configuración inicial
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-[2rem] font-black text-white tracking-tight leading-tight">
                        Arma tu panel de control
                    </h1>
                    <p class="text-sm text-slate-400 mt-3 max-w-md mx-auto leading-relaxed">
                        Elige los módulos visibles para
                        <span class="font-bold text-white">{{ $shop->name }}</span>.
                        Tu plan <span class="font-semibold" style="color: var(--plan-primary);">{{ $theme['label'] }}</span> define el estilo de tu espacio.
                    </p>
                </div>

                <form action="{{ route('admin.setup-modules.save', ['shop_slug' => $shop->slug]) }}" method="POST" class="relative z-10 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($modules as $mod)
                            <div @click="toggleModule('{{ $mod['key'] }}')"
                                 class="group p-4 rounded-2xl border text-left transition-all duration-300 cursor-pointer select-none flex gap-3.5 relative
                                        {{ !empty($mod['wide']) ? 'sm:col-span-2' : '' }}"
                                 :class="selectedModules.includes('{{ $mod['key'] }}')
                                     ? 'module-selected scale-[1.01]'
                                     : 'bg-white/[0.02] border-white/[0.06] hover:border-white/12 hover:bg-white/[0.04]'">

                                <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300 border border-white/5"
                                     :class="selectedModules.includes('{{ $mod['key'] }}') ? 'icon-selected' : 'bg-white/5 text-slate-500'">
                                    <span class="text-xl leading-none">{{ $mod['emoji'] }}</span>
                                </div>

                                <div class="flex-grow min-w-0 pr-7">
                                    <h4 class="text-[11px] font-black tracking-wider uppercase transition-colors"
                                        :class="selectedModules.includes('{{ $mod['key'] }}') ? 'text-white' : 'text-slate-500'">
                                        {{ $mod['title'] }}
                                    </h4>
                                    <p class="text-[10px] text-slate-500 leading-snug mt-0.5 font-medium">
                                        {{ $mod['desc'] }}
                                    </p>
                                </div>

                                <div class="absolute right-3.5 top-4 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-300"
                                     :class="selectedModules.includes('{{ $mod['key'] }}') ? 'module-check scale-110' : 'border-white/15'">
                                    <i class="fas fa-check text-[8px] font-black text-white" x-show="selectedModules.includes('{{ $mod['key'] }}')"></i>
                                </div>

                                <input type="checkbox" name="enabled_modules[]" value="{{ $mod['key'] }}" class="hidden"
                                       :checked="selectedModules.includes('{{ $mod['key'] }}')">
                            </div>
                        @endforeach
                    </div>

                    <p class="text-center text-[10px] text-slate-600 font-medium">
                        <span x-text="selectedModules.length"></span> módulos seleccionados · puedes cambiar esto después en Configuración
                    </p>

                    <button type="submit"
                            class="btn-plan relative w-full flex items-center justify-center gap-3 text-white font-black py-4 sm:py-[1.15rem] rounded-2xl transition-all duration-300 active:scale-[0.98] overflow-hidden group">
                        <span class="text-sm sm:text-[15px] tracking-wide">Comenzar e ir al panel</span>
                        <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-white/20 group-hover:bg-white/30 transition-all group-hover:translate-x-0.5">
                            <i class="fas fa-arrow-right text-sm"></i>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="w-full py-5 text-[11px] text-slate-600 relative z-10 border-t border-white/[0.04]">
        <div class="max-w-4xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>© 2026 WIStore</p>
            <div class="flex items-center gap-4">
                <a href="mailto:{{ $wistoreSupportEmail }}" class="hover:text-cyan-300/90 transition-colors">{{ $wistoreSupportEmail }}</a>
                <a href="{{ route('legal.privacidad') }}" class="hover:text-slate-400 transition-colors">Privacidad</a>
                <a href="{{ route('contacto') }}" class="hover:text-slate-400 transition-colors">Contacto</a>
            </div>
        </div>
    </footer>
</body>

</html>
