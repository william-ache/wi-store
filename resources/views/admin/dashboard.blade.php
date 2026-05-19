@extends('layouts.admin')

@section('title', 'Inicio')
@section('subtitle', 'Panel de Control')
@section('header_title', config('current_shop')->name ?? 'Mi Tienda')

@section('content')
<!-- ═══════════════════════════════════════════════ -->
<!-- 1. BANNER RESUMEN SEMANAL + TENDENCIA DE VENTAS -->
<!-- ═══════════════════════════════════════════════ -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
    <!-- Resumen Semanal -->
    <div class="lg:col-span-3 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-sm transition-colors duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-cyan-500/5 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
        
        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Resumen Semanal</span>
        
        <div class="grid grid-cols-3 gap-6 mt-5 relative z-10">
            <!-- Total Recibido -->
            <div>
                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold block mb-1">Total Recibido</span>
                <p class="text-3xl md:text-4xl font-black tracking-tight text-slate-800 dark:text-white">$1,245<span class="text-lg">.80</span></p>
            </div>
            <!-- Pedidos -->
            <div class="text-center">
                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold block mb-1">Pedidos</span>
                <p class="text-3xl md:text-4xl font-black text-primary">42</p>
                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 mt-2 max-w-[100px] mx-auto">
                    <div class="bg-primary h-1.5 rounded-full" style="width: 84%"></div>
                </div>
                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-semibold mt-1 block">42 / 50</span>
            </div>
            <!-- Visitas -->
            <div class="text-right">
                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold block mb-1">Visitas del Menú</span>
                <p class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white">890</p>
            </div>
        </div>
        
        <div class="mt-5 relative z-10">
            <span class="inline-flex items-center gap-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-500/20">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                +15% vs. anterior
            </span>
        </div>
    </div>

    <!-- Tendencia de Ventas (Gráfico SVG) -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm flex flex-col justify-between transition-colors duration-300">
        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Tendencia de Ventas</span>
        <div class="flex-grow flex items-end mt-4">
            <svg viewBox="0 0 280 100" class="w-full h-auto" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" style="stop-color:var(--tw-color-primary, #E60067);stop-opacity:0.3"/>
                        <stop offset="100%" style="stop-color:var(--tw-color-primary, #E60067);stop-opacity:0"/>
                    </linearGradient>
                </defs>
                <path d="M0,80 C20,75 40,70 60,60 C80,50 100,65 120,55 C140,45 160,40 180,35 C200,30 220,25 240,20 C260,15 270,18 280,15 L280,100 L0,100 Z" fill="url(#chartGrad)"/>
                <path d="M0,80 C20,75 40,70 60,60 C80,50 100,65 120,55 C140,45 160,40 180,35 C200,30 220,25 240,20 C260,15 270,18 280,15" fill="none" stroke="var(--tw-color-primary, #E60067)" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="280" cy="15" r="4" fill="var(--tw-color-primary, #E60067)" stroke="white" stroke-width="2"/>
            </svg>
        </div>
        <div class="flex justify-between text-[9px] text-slate-400 dark:text-slate-500 font-bold mt-3 px-1">
            <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- 2. TASA BCV + WHATSAPP DE PEDIDOS -->
<!-- ═══════════════════════════════════════════════ -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <!-- Tasa BCV Activa -->
    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 flex items-center justify-between shadow-sm transition-colors duration-300">
        <div>
            <span class="text-[9px] font-extrabold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500">Tasa BCV Activa</span>
            <p class="text-xl font-black text-slate-800 dark:text-white mt-0.5">{{ config('current_shop')->exchange_rate ?? 'Bs. 515.18' }}</p>
            <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium">Última actualización BCV</span>
        </div>
        <button class="bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-[11px] px-4 py-2 rounded-xl transition-colors active:scale-95">
            Actualizar Tasa
        </button>
    </div>

    <!-- WhatsApp de Pedidos -->
    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl px-6 py-4 flex items-center justify-between shadow-sm transition-colors duration-300">
        <div>
            <span class="text-[9px] font-extrabold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500">WhatsApp de Pedidos</span>
            <p class="text-xl font-black text-slate-800 dark:text-white mt-0.5">{{ config('current_shop')->whatsapp_number ?? '---' }}</p>
        </div>
        <a href="/{{ config('current_shop')->slug }}/admin/settings" class="bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-[11px] px-4 py-2 rounded-xl transition-colors active:scale-95">
            Modificar
        </a>
    </div>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- 3. CLIENTES TOP + PRODUCTOS MÁS PEDIDOS -->
<!-- ═══════════════════════════════════════════════ -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <!-- Clientes que Más Han Comprado -->
    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm transition-colors duration-300">
        <h3 class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 mb-5">Clientes que más han comprado</h3>
        
        <div class="space-y-4">
            @php
                $topClients = [
                    ['name' => 'Aníbal Peralta', 'initial' => 'A', 'color' => 'bg-cyan-500', 'total' => 850.30, 'orders' => 43],
                    ['name' => 'Elena González', 'initial' => 'E', 'color' => 'bg-violet-500', 'total' => 707.40, 'orders' => 30],
                    ['name' => 'Carmen Ruiz', 'initial' => 'C', 'color' => 'bg-amber-500', 'total' => 475.90, 'orders' => 21],
                    ['name' => 'Flarcia Hama', 'initial' => 'M', 'color' => 'bg-rose-500', 'total' => 250.30, 'orders' => 22],
                    ['name' => 'Aníbal Palato', 'initial' => 'D', 'color' => 'bg-indigo-500', 'total' => 800.00, 'orders' => 20],
                ];
            @endphp
            @foreach($topClients as $index => $client)
            <div class="flex items-center gap-4">
                <span class="text-xs font-black text-slate-400 dark:text-slate-500 w-4 text-right shrink-0">{{ $index + 1 }}</span>
                <div class="w-9 h-9 rounded-full {{ $client['color'] }} flex items-center justify-center text-white font-black text-xs shadow-sm shrink-0">
                    {{ $client['initial'] }}
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $client['name'] }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-black text-slate-800 dark:text-slate-200">Total: ${{ number_format($client['total'], 2) }}</p>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold">{{ $client['orders'] }} compras</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Productos Más Pedidos -->
    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm transition-colors duration-300">
        <h3 class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 mb-5">Productos más pedidos</h3>
        
        <div class="space-y-4">
            @php
                $topProducts = [
                    ['name' => 'Arreglo Globos Premium 🎈', 'desc' => 'Descripción de descripción a arreglo dicitur usos.', 'units' => 42, 'img' => null],
                    ['name' => 'Bouquet Rosas 🌹', 'desc' => 'Bouquet rosas y chocolates como esas chocolates.', 'units' => 42, 'img' => null],
                    ['name' => 'Caja de Chocolates 🍫', 'desc' => 'Globos y arreglos', 'units' => 32, 'img' => null],
                    ['name' => 'Arreglo Globos Premium 🎈', 'desc' => 'Globos y arreglos', 'units' => 32, 'img' => null],
                    ['name' => 'Arreglo Globos Premium 🎈', 'desc' => 'Arreglo globos', 'units' => 32, 'img' => null],
                ];
            @endphp
            @foreach($topProducts as $product)
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg shrink-0 overflow-hidden border border-slate-200 dark:border-slate-700">
                    @if($product['img'])
                        <img src="{{ $product['img'] }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="text-base">🛍️</span>
                    @endif
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate">{{ $product['name'] }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate">{{ $product['desc'] }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-black text-slate-800 dark:text-slate-200">Total: {{ $product['units'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
