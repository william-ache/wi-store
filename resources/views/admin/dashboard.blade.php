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
    <div class="lg:col-span-3 bg-gradient-to-br from-primary to-primary/80 border-0 rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-xl shadow-primary/10 transition-all duration-300 hover:scale-[1.01]">
        <!-- Glass decorative blur elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4"></div>
        
        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-white/60 relative z-10">Resumen Semanal</span>
        
        <div class="grid grid-cols-3 gap-6 mt-5 relative z-10">
            <!-- Total Recibido -->
            <div>
                <span class="text-[10px] text-white/70 font-semibold block mb-1">Total Recibido</span>
                @php
                    $formattedTotal = number_format($totalReceived, 2);
                    $parts = explode('.', $formattedTotal);
                @endphp
                <p class="text-3xl md:text-4xl font-black tracking-tight text-white">${{ $parts[0] }}<span class="text-lg">.{{ $parts[1] }}</span></p>
            </div>
            <!-- Pedidos -->
            <div class="text-center">
                <span class="text-[10px] text-white/70 font-semibold block mb-1">Pedidos</span>
                <p class="text-3xl md:text-4xl font-black text-white">{{ $ordersCount }}</p>
                <div class="w-full bg-white/20 rounded-full h-1.5 mt-2 max-w-[100px] mx-auto">
                    <div class="bg-white h-1.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                </div>
                <span class="text-[9px] text-white/80 font-semibold mt-1 block">{{ $ordersCount }} / {{ $orderGoal }}</span>
            </div>
            <!-- Visitas -->
            <div class="text-right">
                <span class="text-[10px] text-white/70 font-semibold block mb-1">Visitas del Menú</span>
                <p class="text-3xl md:text-4xl font-black text-white">{{ number_format($visitsCount) }}</p>
            </div>
        </div>
        
        <div class="mt-5 relative z-10">
            <span class="inline-flex items-center gap-1 bg-white/15 text-white text-[10px] font-bold px-2.5 py-1 rounded-full border border-white/10 shadow-sm backdrop-blur-md">
                {!! $trendIcon !!}
                {{ $trendLabel }}
            </span>
        </div>
    </div>

    <!-- Tendencia de Ventas (Gráfico Chart.js) -->
    <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl flex flex-col justify-between relative overflow-hidden transition-all duration-300 hover:scale-[1.01]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl"></div>
        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400 relative z-10">Tendencia de Ventas</span>
        <div class="flex-grow flex items-end mt-4 relative w-full h-full min-h-[120px] z-10">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>



<!-- ═══════════════════════════════════════════════ -->
<!-- 3. CLIENTES TOP + PRODUCTOS MÁS PEDIDOS -->
<!-- ═══════════════════════════════════════════════ -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <!-- Clientes que Más Han Comprado -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden transition-all duration-300 hover:scale-[1.01]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl"></div>
        <h3 class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-slate-400 mb-5 relative z-10">Clientes que más han comprado</h3>
        
        <div class="space-y-4 relative z-10">
            @forelse($topClients as $index => $client)
            <div class="flex items-center gap-4">
                <span class="text-xs font-black text-slate-500 w-4 text-right shrink-0">{{ $index + 1 }}</span>
                <div class="w-9 h-9 rounded-full {{ $client['color'] }} flex items-center justify-center text-white font-black text-xs shadow-sm shrink-0">
                    {{ $client['initial'] }}
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-sm font-bold text-slate-100 truncate">{{ $client['name'] }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-black text-slate-100">Total: ${{ number_format($client['total'], 2) }}</p>
                    <span class="text-[10px] text-slate-400 font-semibold">{{ $client['orders'] }} compras</span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <span class="text-2xl block mb-2 opacity-60">👥</span>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Sin compras registradas</p>
                <p class="text-[10px] text-slate-500 mt-1">Los clientes que completen órdenes aparecerán aquí.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Productos Más Pedidos -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl text-white relative overflow-hidden transition-all duration-300 hover:scale-[1.01]">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl"></div>
        <h3 class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-slate-400 mb-5 relative z-10">Productos más pedidos</h3>
        
        <div class="space-y-4 relative z-10">
            @forelse($topProducts as $product)
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-lg shrink-0 overflow-hidden border border-slate-700">
                    @if($product['img'])
                        <img src="{{ $product['img'] }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="text-base">🛍️</span>
                    @endif
                </div>
                <div class="flex-grow min-w-0">
                    <p class="text-xs font-bold text-slate-100 truncate">{{ $product['name'] }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ $product['desc'] }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs font-black text-slate-100">Total: {{ $product['units'] }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <span class="text-2xl block mb-2 opacity-60">📦</span>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Sin productos ordenados</p>
                <p class="text-[10px] text-slate-500 mt-1">Las ventas de catálogo activarán este listado.</p>
            </div>
            @endforelse
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
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Ventas',
                    data: {!! json_encode($chartData) !!},
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

