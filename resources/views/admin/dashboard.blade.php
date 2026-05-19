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

    <!-- Tendencia de Ventas (Gráfico Chart.js) -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl p-6 shadow-sm flex flex-col justify-between transition-colors duration-300">
        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">Tendencia de Ventas</span>
        <div class="flex-grow flex items-end mt-4 relative w-full h-full min-h-[120px]">
            <canvas id="salesChart"></canvas>
        </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const primaryColor = '{{ config('current_shop')->color_primary ?? '#E60067' }}';
        const secondaryColor = '{{ config('current_shop')->color_secondary ?? '#C6A100' }}';
        
        // Detectar modo oscuro
        const isDark = document.documentElement.classList.contains('dark');
        
        // Verificar luminancia del color primario
        const hex = primaryColor.replace('#', '');
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        const isPrimaryDark = ((r * 299) + (g * 587) + (b * 114)) / 1000 < 128;

        // Usar color secundario o blanco si el primario no hace contraste en modo oscuro
        const chartColor = (isDark && isPrimaryDark) ? (secondaryColor !== '#000000' && secondaryColor !== '#0f172a' ? secondaryColor : '#38bdf8') : primaryColor;
        
        // Crear gradiente debajo de la línea
        let gradient = ctx.createLinearGradient(0, 0, 0, 150);
        gradient.addColorStop(0, chartColor + '40'); // 25% opacidad
        gradient.addColorStop(1, chartColor + '00'); // Transparente

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
                datasets: [{
                    label: 'Ventas',
                    data: [120, 250, 180, 400, 300, 500, 600],
                    borderColor: chartColor,
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: isDark ? '#0f172a' : '#ffffff',
                    pointBorderColor: chartColor,
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#cbd5e1',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 10,
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        display: false,
                        min: 0
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush

