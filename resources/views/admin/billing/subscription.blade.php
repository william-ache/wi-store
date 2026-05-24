@extends('layouts.admin')

@section('title', 'Suscripción')

@section('content')
<div class="space-y-6">
    <!-- CABECERA DE LA PÁGINA -->
    <div>
        <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-white tracking-tight">Suscripción</h2>
        <p class="text-xs text-slate-450 dark:text-slate-500 font-semibold mt-0.5">Gestiona tu plan y método de pago</p>
    </div>

    <!-- TARJETA DEL PLAN ACTIVO -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-700 via-indigo-800 to-purple-900 text-white rounded-[2rem] p-6 md:p-8 shadow-xl border border-white/10">
        <!-- Decoración de Fondo (Brillos de neón) -->
        <div class="absolute -top-24 -right-24 w-56 h-56 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-56 h-56 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
            <!-- Detalles Principales del Plan -->
            <div class="space-y-4 flex-grow">
                <div class="flex items-center gap-2">
                    <!-- Pill Plan Activo -->
                    <span class="inline-flex items-center gap-1.5 bg-emerald-500/20 border border-emerald-400/30 rounded-full px-3.5 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Plan activo
                    </span>
                    
                    <!-- Días Restantes -->
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-200 bg-white/5 rounded-full px-3 py-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $daysRemaining }} días restantes
                    </span>
                </div>

                <div>
                    <h3 class="text-3xl font-black tracking-tight text-white leading-none">Plan {{ $planName }}</h3>
                    <p class="text-xs font-semibold text-indigo-200 mt-2">
                        Renovación: {{ $shop->plan_expires_at ? \Carbon\Carbon::parse($shop->plan_expires_at)->format('d/m/Y') : '---' }} · {{ $planPrice }}
                    </p>
                </div>
            </div>

            <!-- Próximo Cobro Box -->
            <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-4 text-left md:text-right shrink-0 min-w-[140px] shadow-lg">
                <span class="text-[9px] uppercase font-black text-indigo-200 tracking-wider block">Próximo cobro</span>
                <span class="text-xl font-black text-white mt-1 block">
                    {{ $shop->plan === 'free_trial' ? 'Bs 0.00' : ($shop->plan === 'standard' ? 'Bs 220.00' : 'Bs 400.00') }}
                </span>
            </div>
        </div>

        <!-- SECCIÓN DE CONSUMOS / BARRAS DE PROGRESO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-8 border-t border-white/10 relative z-10">
            @php
                $prodPercent = 0;
                $catPercent = 0;
                $prodRemaining = 'Ilimitados';
                $catRemaining = 'Ilimitados';
                
                if (is_numeric($maxProducts)) {
                    $prodPercent = min(100, round(($productsCount / $maxProducts) * 100));
                    $prodRemaining = max(0, $maxProducts - $productsCount) . ' disponibles';
                }
                
                if (is_numeric($maxCategories)) {
                    $catPercent = min(100, round(($categoriesCount / $maxCategories) * 100));
                    $catRemaining = max(0, $maxCategories - $categoriesCount) . ' disponibles';
                }
            @endphp

            <!-- Productos Progress -->
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs font-bold text-white/95">
                    <span class="tracking-wide">Productos</span>
                    <span>{{ $productsCount }} de {{ $maxProducts }}</span>
                </div>
                
                <!-- Track Bar -->
                <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full bg-white rounded-full transition-all duration-500 shadow-[0_0_8px_rgba(255,255,255,0.4)]" 
                         style="width: {{ is_numeric($maxProducts) ? $prodPercent : 100 }}%"></div>
                </div>

                <div class="flex justify-between items-center text-[10px] text-white/60 font-semibold">
                    <span>{{ is_numeric($maxProducts) ? $prodPercent . '% utilizado' : '0% utilizado' }}</span>
                    <span>{{ $prodRemaining }}</span>
                </div>
            </div>

            <!-- Categorías Progress -->
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs font-bold text-white/95">
                    <span class="tracking-wide">Categorías</span>
                    <span>{{ $categoriesCount }} de {{ $maxCategories }}</span>
                </div>
                
                <!-- Track Bar -->
                <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full bg-white rounded-full transition-all duration-500 shadow-[0_0_8px_rgba(255,255,255,0.4)]" 
                         style="width: {{ is_numeric($maxCategories) ? $catPercent : 100 }}%"></div>
                </div>

                <div class="flex justify-between items-center text-[10px] text-white/60 font-semibold">
                    <span>{{ is_numeric($maxCategories) ? $catPercent . '% utilizado' : '0% utilizado' }}</span>
                    <span>{{ $catRemaining }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- COMPARAR PLANES GRID -->
    <div class="pt-4">
        <div>
            <h3 class="text-lg font-black text-slate-800 dark:text-white tracking-tight">Comparar planes</h3>
            <p class="text-xs text-slate-450 dark:text-slate-500 font-semibold mt-0.5">Actualiza tu plan en cualquier momento</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <!-- 1. PLAN BÁSICO CARD -->
            <div class="bg-white dark:bg-slate-900 border-2 rounded-[24px] p-6 shadow-sm flex flex-col justify-between relative transition-all duration-300 hover:shadow-md
                        {{ $shop->plan === 'free_trial' ? 'border-purple-600/60 dark:border-purple-500/50 ring-4 ring-purple-500/10' : 'border-slate-100 dark:border-slate-800/80' }}">
                
                @if($shop->plan === 'free_trial')
                <!-- Plan Actual Badge -->
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-purple-600 text-white font-extrabold text-[9px] uppercase tracking-widest px-4 py-1.5 rounded-full shadow-md">
                    ✓ Plan actual
                </div>
                @endif

                <div>
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400">
                            <i class="far fa-star text-sm"></i>
                        </div>
                        <h4 class="text-sm font-extrabold text-slate-700 dark:text-slate-200">Básico</h4>
                    </div>

                    <!-- Pricing -->
                    <div class="mb-6">
                        <span class="text-3xl font-black text-slate-800 dark:text-white">Bs 0</span>
                        <span class="text-xs font-semibold text-slate-400">/mes</span>
                    </div>

                    <!-- Features -->
                    <div class="space-y-5 border-t border-slate-100 dark:border-slate-800/80 pt-5">
                        <!-- Catálogo group -->
                        <div>
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Catálogo</span>
                            <ul class="space-y-2 mt-2 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 25 productos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 5 categorías</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 2 foto(s) por producto</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Soporte</li>
                            </ul>
                        </div>

                        <!-- Ventas group -->
                        <div>
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Ventas</span>
                            <ul class="space-y-2 mt-2 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 1 usuario(s)</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Mensaje de bienvenida</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Modo Restaurante (menú)</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> QR del catálogo</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Link compatible</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Botón pedido WhatsApp</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Búsqueda y filtros básicos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Actualización en tiempo real</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Stock visible</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Colores personalizado</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> Compartir redes sociales</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> Carrito de pedidos</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> Productos destacados</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> Analíticas</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> PDF lista de precios</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> Historial de pedidos</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-8">
                    @if($shop->plan === 'free_trial')
                    <button disabled class="w-full text-center bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-extrabold text-xs py-3.5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 cursor-not-allowed">
                        Plan actual
                    </button>
                    @else
                    <button disabled class="w-full text-center bg-slate-50 dark:bg-slate-900/50 text-slate-350 dark:text-slate-600 font-extrabold text-xs py-3.5 rounded-xl border border-slate-100 dark:border-slate-800 cursor-not-allowed">
                        No disponible
                    </button>
                    @endif
                </div>
            </div>

            <!-- 2. PLAN PRO CARD -->
            <div class="bg-white dark:bg-slate-900 border-2 rounded-[24px] p-6 shadow-sm flex flex-col justify-between relative transition-all duration-300 hover:shadow-md
                        {{ $shop->plan === 'standard' ? 'border-purple-600/60 dark:border-purple-500/50 ring-4 ring-purple-500/10' : 'border-slate-100 dark:border-slate-800/80' }}">
                
                @if($shop->plan === 'standard')
                <!-- Plan Actual Badge -->
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-purple-600 text-white font-extrabold text-[9px] uppercase tracking-widest px-4 py-1.5 rounded-full shadow-md">
                    ✓ Plan actual
                </div>
                @endif

                <div>
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400">
                            <i class="fas fa-bolt text-sm text-amber-500"></i>
                        </div>
                        <h4 class="text-sm font-extrabold text-slate-700 dark:text-slate-200">Pro</h4>
                    </div>

                    <!-- Pricing -->
                    <div class="mb-6">
                        <span class="text-3xl font-black text-slate-800 dark:text-white">Bs 220</span>
                        <span class="text-xs font-semibold text-slate-400">/mes</span>
                    </div>

                    <!-- Features -->
                    <div class="space-y-5 border-t border-slate-100 dark:border-slate-800/80 pt-5">
                        <!-- Catálogo group -->
                        <div>
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Catálogo</span>
                            <ul class="space-y-2 mt-2 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 150 productos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 15 categorías</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 6 foto(s) por producto</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Soporte prioritario</li>
                            </ul>
                        </div>

                        <!-- Ventas group -->
                        <div>
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Ventas</span>
                            <ul class="space-y-2 mt-2 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 3 usuario(s)</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Mensaje de bienvenida</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Modo Restaurante (menú)</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> QR del catálogo</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Link compatible</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Botón pedido WhatsApp</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Búsqueda y filtros básicos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Actualización en tiempo real</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Stock visible</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Colores personalizado</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Compartir redes sociales</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Carrito de pedidos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Productos destacados</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Analíticas</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> PDF lista de precios</li>
                                <li class="flex items-center gap-2 text-slate-400/60 dark:text-slate-650 line-through"><i class="fas fa-times text-[10px] text-slate-350 shrink-0"></i> Historial de pedidos</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-8">
                    @if($shop->plan === 'standard')
                    <button disabled class="w-full text-center bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-extrabold text-xs py-3.5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 cursor-not-allowed">
                        Plan actual
                    </button>
                    @elseif($shop->plan === 'premium')
                    <button disabled class="w-full text-center bg-slate-50 dark:bg-slate-900/50 text-slate-350 dark:text-slate-600 font-extrabold text-xs py-3.5 rounded-xl border border-slate-100 dark:border-slate-800 cursor-not-allowed">
                        No disponible
                    </button>
                    @else
                    <a href="/{{ $shop->slug }}/admin/billing/expired?plan=standard" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-extrabold text-xs py-3.5 rounded-xl transition duration-300 shadow-md hover:shadow-lg active:scale-95">
                        Cambiar a Pro →
                    </a>
                    @endif
                </div>
            </div>

            <!-- 3. PLAN NEGOCIO CARD -->
            <div class="bg-white dark:bg-slate-900 border-2 rounded-[24px] p-6 shadow-sm flex flex-col justify-between relative transition-all duration-300 hover:shadow-md
                        {{ $shop->plan === 'premium' ? 'border-purple-600/60 dark:border-purple-500/50 ring-4 ring-purple-500/10' : 'border-slate-100 dark:border-slate-800/80' }}">
                
                @if($shop->plan === 'premium')
                <!-- Plan Actual Badge -->
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-purple-600 text-white font-extrabold text-[9px] uppercase tracking-widest px-4 py-1.5 rounded-full shadow-md">
                    ✓ Plan actual
                </div>
                @endif

                <div>
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400">
                            <i class="fas fa-crown text-sm text-yellow-500"></i>
                        </div>
                        <h4 class="text-sm font-extrabold text-slate-700 dark:text-slate-200">Negocio</h4>
                    </div>

                    <!-- Pricing -->
                    <div class="mb-6">
                        <span class="text-3xl font-black text-slate-800 dark:text-white">Bs 400</span>
                        <span class="text-xs font-semibold text-slate-400">/mes</span>
                    </div>

                    <!-- Features -->
                    <div class="space-y-5 border-t border-slate-100 dark:border-slate-800/80 pt-5">
                        <!-- Catálogo group -->
                        <div>
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Catálogo</span>
                            <ul class="space-y-2 mt-2 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Productos ilimitados</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Categorías ilimitadas</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 8 foto(s) por producto</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Soporte personalizado</li>
                            </ul>
                        </div>

                        <!-- Ventas group -->
                        <div>
                            <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Ventas</span>
                            <ul class="space-y-2 mt-2 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> 5 usuario(s)</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Mensaje de bienvenida</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Modo Restaurante (menú)</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> QR del catálogo</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Link compatible</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Botón pedido WhatsApp</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Búsqueda y filtros básicos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Actualización en tiempo real</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Stock visible</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Colores personalizado</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Compartir redes sociales</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Carrito de pedidos</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Productos destacados</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Analíticas</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> PDF lista de precios</li>
                                <li class="flex items-center gap-2 text-slate-500"><i class="fas fa-check text-[10px] text-purple-500 shrink-0"></i> Historial de pedidos</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-8">
                    @if($shop->plan === 'premium')
                    <button disabled class="w-full text-center bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-extrabold text-xs py-3.5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 cursor-not-allowed">
                        Plan actual
                    </button>
                    @else
                    <a href="/{{ $shop->slug }}/admin/billing/expired?plan=premium" class="block w-full text-center bg-transparent border-2 border-purple-650 hover:bg-purple-650 hover:text-white text-purple-650 dark:border-purple-500 dark:hover:bg-purple-500 dark:text-purple-400 dark:hover:text-white font-extrabold text-xs py-3.5 rounded-xl transition duration-300 shadow-sm active:scale-95">
                        Contactar a ventas →
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
