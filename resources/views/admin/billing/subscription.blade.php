@extends('layouts.admin')

@section('title', 'Suscripción')

@push('page-styles')
    @include('partials.admin.billing.subscription-plan-page-styles')
@endpush

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
                <span class="text-xl font-black text-white mt-1 block">{{ $nextChargeLabel }}</span>
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

    <!-- COMPARAR PLANES (misma presentación que la landing) -->
    <div class="pt-4">
        <div>
            <h3 class="text-lg font-black text-slate-800 dark:text-white tracking-tight">Comparar planes</h3>
            <p class="text-xs text-slate-450 dark:text-slate-500 font-semibold mt-0.5">Emprendedor y Negocio · precios en USD con referencia en Bs al pagar</p>
        </div>

        <div class="mt-6">
            @include('partials.admin.billing.subscription-plans')
        </div>
    </div>
</div>
@endsection
