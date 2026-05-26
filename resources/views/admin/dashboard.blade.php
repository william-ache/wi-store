@extends('layouts.admin')

@section('title', 'Inicio')
@section('subtitle', 'Tu Panel Principal')
@section('header_title', config('current_shop')->name ?? 'Mi Tienda')

@section('content')
<div class="ui-card rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-xl transition-all duration-300 bg-gradient-to-br from-[var(--ui-surface)] via-[var(--ui-surface)] to-primary/5">
    <div class="absolute -top-24 -right-24 w-80 h-80 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left">
            <div class="inline-flex items-center gap-1.5 bg-primary/10 border border-primary/20 text-primary text-[10px] font-black uppercase tracking-wider px-3.5 py-1.5 rounded-full">
                <span>🚀 ¡Panel Listo!</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[var(--ui-text)] tracking-tight">
                ¡Hola de nuevo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">{{ config('current_shop')->name ?? 'Comerciante' }}</span>! 👋
            </h1>
            <p class="text-xs text-[var(--ui-text-muted)] max-w-lg leading-relaxed font-medium">
                Este es el centro de control de tu tienda digital. Desde aquí puedes administrar tus productos, procesar pedidos y hacer crecer tu marca.
            </p>
        </div>
        
        <div class="shrink-0 flex gap-3">
            <a href="/{{ config('current_shop')->slug }}" target="_blank" 
               class="bg-primary text-[var(--color-on-primary)] text-xs font-bold px-5 py-3 rounded-2xl shadow-lg shadow-primary/20 hover:brightness-95 transition-all duration-300 hover:scale-[1.03] active:scale-[0.98] flex items-center gap-2">
                <span>Ver Tu Tienda en Vivo</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mt-6">
    <div class="ui-card rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Pedidos Totales</span>
        <p class="text-2xl font-black text-[var(--ui-text)] leading-none">{{ $ordersCount }}</p>
        <span class="text-[9px] text-emerald-600 dark:text-emerald-400 font-bold mt-2 inline-flex items-center gap-1">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            Flujo Operativo
        </span>
    </div>

    <div class="ui-card rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-primary/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Productos</span>
        <p class="text-2xl font-black text-[var(--ui-text)] leading-none">{{ $productsCount }}</p>
        <span class="text-[9px] text-primary font-bold mt-2 inline-flex items-center gap-1">🗂️ {{ $categoriesCount }} Categorías</span>
    </div>

    <div class="ui-card rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-secondary/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Clientes</span>
        <p class="text-2xl font-black text-[var(--ui-text)] leading-none">{{ $clientsCount }}</p>
        <span class="text-[9px] text-secondary font-bold mt-2 inline-flex items-center gap-1">👥 Compradores</span>
    </div>

    @php
        $dashPlan = config('current_shop')->plan ?? 'free_trial';
        if ($dashPlan === 'free_trial') {
            $dashPlanName = 'Básico / Gratis';
            $dashPlanClass = 'text-purple-600 dark:text-purple-400';
        } elseif ($dashPlan === 'standard') {
            $dashPlanName = 'Standard Pro';
            $dashPlanClass = 'text-sky-600 dark:text-sky-400';
        } else {
            $dashPlanName = 'Premium Negocio';
            $dashPlanClass = 'text-emerald-600 dark:text-emerald-400';
        }
    @endphp
    <div class="ui-card rounded-2xl p-5 shadow-lg relative overflow-hidden transition-all duration-300 hover:scale-[1.02]">
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-purple-500/5 rounded-full blur-xl"></div>
        <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Plan de Negocio</span>
        <p class="text-sm font-black text-[var(--ui-text)] leading-tight mt-1">{{ $dashPlanName }}</p>
        <span class="text-[9px] {{ $dashPlanClass }} font-black mt-2 inline-flex items-center gap-1 uppercase tracking-wider">👑 Plan Activo</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-5 mt-6">
    <div class="lg:col-span-3 ui-card rounded-3xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>
        <h2 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[var(--ui-text-muted)] mb-5 relative z-10 flex items-center justify-between">
            <span>Guía de Configuración Inicial</span>
            <span class="text-primary font-bold">4 / 4 Completados</span>
        </h2>
        <div class="space-y-4 relative z-10">
            @foreach([
                ['Crear tu tienda digital', 'Registrado y configurado con tus colores corporativos y slug de marca único.'],
                ['Agregar Categorías y Productos', 'Tu inventario tiene cargados productos e imágenes listos para la compra del cliente.'],
                ['Configurar Métodos de Pago', 'Tienes habilitado el envío directo por WhatsApp para coordinar el pago cómodamente.'],
                ['Compartir el Código QR', 'Tu menú digital cuenta con código QR generado en el sistema listo para imprimir.'],
            ] as [$title, $desc])
            <div class="flex items-start gap-3.5 p-3 rounded-2xl ui-inset border">
                <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0 text-xs">✓</div>
                <div>
                    <h4 class="text-xs font-bold text-[var(--ui-text)]">{{ $title }}</h4>
                    <p class="text-[10px] text-[var(--ui-text-muted)] mt-0.5 leading-relaxed font-medium">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="lg:col-span-2 ui-card rounded-3xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>
        <h2 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[var(--ui-text-muted)] mb-5 relative z-10">Accesos Rápidos</h2>
        <div class="grid grid-cols-1 gap-3 relative z-10">
            @foreach([
                ['/' . config('current_shop')->slug . '/admin/products', '🍔', 'Cargar Productos', 'Agrega artículos y fotos'],
                ['/' . config('current_shop')->slug . '/admin/settings', '🎨', 'Personalizar Tienda', 'Colores, logo e información'],
                ['/' . config('current_shop')->slug . '/admin/analytics', '📊', 'Ver Rendimiento', 'Estadísticas y ventas comerciales'],
                ['/' . config('current_shop')->slug . '/admin/orders', '📋', 'Gestionar Pedidos', 'Recibe y despacha órdenes'],
            ] as [$href, $icon, $title, $desc])
            <a href="{{ $href }}" class="flex items-center justify-between p-3.5 rounded-2xl ui-inset border hover:brightness-[0.98] dark:hover:brightness-110 transition-all duration-300 group">
                <div class="flex items-center gap-3">
                    <span class="text-xl group-hover:scale-110 transition-transform">{{ $icon }}</span>
                    <div>
                        <h4 class="text-xs font-bold text-[var(--ui-text)]">{{ $title }}</h4>
                        <p class="text-[9px] text-[var(--ui-text-muted)] font-medium">{{ $desc }}</p>
                    </div>
                </div>
                <span class="text-[var(--ui-text-muted)] group-hover:text-primary transition-colors text-xs font-black">→</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
