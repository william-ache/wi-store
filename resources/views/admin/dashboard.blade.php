@extends('layouts.admin')

@section('title', 'Inicio')
@section('subtitle', 'Tu Panel Principal')
@section('header_title', config('current_shop')->name ?? 'Mi Tienda')

@section('content')
<!-- ═══════════════════════════════════════════════ -->
<!-- 1. GREETING BANNER -->
<!-- ═══════════════════════════════════════════════ -->
<div class="bg-gradient-to-br from-slate-900 via-slate-900 to-primary/10 border border-slate-800 rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-xl transition-all duration-300">
    <div class="absolute -top-24 -right-24 w-80 h-80 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left">
            <div class="inline-flex items-center gap-1.5 bg-primary/10 border border-primary/20 text-primary text-[10px] font-black uppercase tracking-wider px-3.5 py-1.5 rounded-full">
                <span>🚀 ¡Panel Listo!</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                ¡Hola de nuevo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">{{ config('current_shop')->name ?? 'Comerciante' }}</span>! 👋
            </h1>
            <p class="text-xs text-slate-400 max-w-lg leading-relaxed font-medium">
                Este es el centro de control de tu tienda digital. Desde aquí puedes administrar tus productos, procesar pedidos y hacer crecer tu marca.
            </p>
        </div>
        
        <div class="shrink-0 flex gap-3">
            <a href="/{{ config('current_shop')->slug }}" target="_blank" 
               class="bg-gradient-to-r from-primary to-primary/95 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-300 hover:scale-[1.03] active:scale-[0.98] flex items-center gap-2 border border-white/10">
                <span>Ver Tu Tienda en Vivo</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
            </a>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- 2. QUICK METRIC CARDS -->
<!-- ═══════════════════════════════════════════════ -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">
    <!-- Pedidos -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Pedidos Totales</span>
        <p class="text-2xl font-black text-white leading-none">{{ $ordersCount }}</p>
        <span class="text-[9px] text-emerald-400 font-bold mt-2 inline-flex items-center gap-1">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            Flujo Operativo
        </span>
    </div>

    <!-- Productos -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-primary/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Productos</span>
        <p class="text-2xl font-black text-white leading-none">{{ $productsCount }}</p>
        <span class="text-[9px] text-primary font-bold mt-2 inline-flex items-center gap-1">
            🗂️ {{ $categoriesCount }} Categorías
        </span>
    </div>

    <!-- Clientes -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-secondary/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Clientes</span>
        <p class="text-2xl font-black text-white leading-none">{{ $clientsCount }}</p>
        <span class="text-[9px] text-secondary font-bold mt-2 inline-flex items-center gap-1">
            👥 Compradores
        </span>
    </div>

    <!-- Plan Actual -->
    @php
        $dashPlan = config('current_shop')->plan ?? 'free_trial';
        if ($dashPlan === 'free_trial') {
            $dashPlanName = 'Básico / Gratis';
            $dashPlanClass = 'text-purple-400';
            $dashPlanBadge = 'bg-purple-500/10 border-purple-500/20';
        } elseif ($dashPlan === 'standard') {
            $dashPlanName = 'Standard Pro';
            $dashPlanClass = 'text-sky-400';
            $dashPlanBadge = 'bg-sky-500/10 border-sky-500/20';
        } else {
            $dashPlanName = 'Premium Negocio';
            $dashPlanClass = 'text-emerald-400';
            $dashPlanBadge = 'bg-emerald-500/10 border-emerald-500/20';
        }
    @endphp
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-purple-500/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Plan de Negocio</span>
        <p class="text-sm font-black text-white leading-tight mt-1">{{ $dashPlanName }}</p>
        <span class="text-[9px] {{ $dashPlanClass }} font-black mt-2 inline-flex items-center gap-1 uppercase tracking-wider">
            👑 Plan Activo
        </span>
    </div>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- 3. WORKSPACE SECTIONS -->
<!-- ═══════════════════════════════════════════════ -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
    
    <!-- Checklist de Onboarding (3 cols) -->
    <div class="lg:col-span-3 bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl relative overflow-hidden flex flex-col justify-between">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>
        
        <div>
            <h2 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400 mb-5 relative z-10 flex items-center justify-between">
                <span>Guía de Configuración Inicial</span>
                <span class="text-primary font-bold">4 / 4 Completados</span>
            </h2>
            
            <div class="space-y-4">
                <!-- Paso 1 -->
                <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-slate-800/30 border border-slate-800/80">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0 text-xs">
                        ✓
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-100">Crear tu tienda digital</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed font-medium">Registrado y configurado con tus colores corporativos y slug de marca único.</p>
                    </div>
                </div>

                <!-- Paso 2 -->
                <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-slate-800/30 border border-slate-800/80">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0 text-xs">
                        ✓
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-100">Agregar Categorías y Productos</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed font-medium">Tu inventario tiene cargados productos e imágenes listos para la compra del cliente.</p>
                    </div>
                </div>

                <!-- Paso 3 -->
                <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-slate-800/30 border border-slate-800/80">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0 text-xs">
                        ✓
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-100">Configurar Métodos de Pago</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed font-medium">Tienes habilitado el envío directo por WhatsApp para coordinar el pago cómodamente.</p>
                    </div>
                </div>

                <!-- Paso 4 -->
                <div class="flex items-start gap-3.5 p-3 rounded-2xl bg-slate-800/30 border border-slate-800/80">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0 text-xs">
                        ✓
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-100">Compartir el Código QR</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed font-medium">Tu menú digital cuenta con código QR generado en el sistema listo para imprimir.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos (2 cols) -->
    <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl relative overflow-hidden flex flex-col justify-between">
        <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>
        
        <div>
            <h2 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400 mb-5 relative z-10">Accesos Rápidos</h2>
            
            <div class="grid grid-cols-1 gap-3 relative z-10">
                <!-- Administrar Productos -->
                <a href="/{{ config('current_shop')->slug }}/admin/products" 
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-800/40 hover:bg-slate-800 border border-slate-800/80 hover:border-slate-700 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <span class="text-xl group-hover:scale-110 transition-transform">🍔</span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100">Cargar Productos</h4>
                            <p class="text-[9px] text-slate-400 font-medium">Agrega artículos y fotos</p>
                        </div>
                    </div>
                    <span class="text-slate-500 group-hover:text-white transition-colors text-xs font-black">→</span>
                </a>

                <!-- Configuración Visual -->
                <a href="/{{ config('current_shop')->slug }}/admin/settings" 
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-800/40 hover:bg-slate-800 border border-slate-800/80 hover:border-slate-700 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <span class="text-xl group-hover:scale-110 transition-transform">🎨</span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100">Personalizar Tienda</h4>
                            <p class="text-[9px] text-slate-400 font-medium">Colores, logo e información</p>
                        </div>
                    </div>
                    <span class="text-slate-500 group-hover:text-white transition-colors text-xs font-black">→</span>
                </a>

                <!-- Ver Analítica -->
                <a href="/{{ config('current_shop')->slug }}/admin/analytics" 
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-800/40 hover:bg-slate-800 border border-slate-800/80 hover:border-slate-700 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <span class="text-xl group-hover:scale-110 transition-transform">📊</span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100">Ver Rendimiento</h4>
                            <p class="text-[9px] text-slate-400 font-medium">Estadísticas y ventas comerciales</p>
                        </div>
                    </div>
                    <span class="text-slate-500 group-hover:text-white transition-colors text-xs font-black">→</span>
                </a>

                <!-- Ver Pedidos -->
                <a href="/{{ config('current_shop')->slug }}/admin/orders" 
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-800/40 hover:bg-slate-800 border border-slate-800/80 hover:border-slate-700 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <span class="text-xl group-hover:scale-110 transition-transform">📋</span>
                        <div>
                            <h4 class="text-xs font-bold text-slate-100">Gestionar Pedidos</h4>
                            <p class="text-[9px] text-slate-400 font-medium">Recibe y despacha órdenes</p>
                        </div>
                    </div>
                    <span class="text-slate-500 group-hover:text-white transition-colors text-xs font-black">→</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
