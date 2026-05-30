@extends('layouts.admin')

@section('title', 'Inicio')
@section('subtitle', 'Tu Panel Principal')
@section('header_title', config('current_shop')->name ?? 'Mi Tienda')

@section('content')
@php
    $shopName = config('current_shop')->name ?? 'Comerciante';
    $formattedWeekly = number_format($weeklyTotal, 2);
    $weeklyParts = explode('.', $formattedWeekly);
    $dashPlan = config('current_shop')->plan ?? 'free_trial';
    if ($dashPlan === 'free_trial') {
        $dashPlanName = 'Básico / Gratis';
    } elseif ($dashPlan === 'standard') {
        $dashPlanName = 'Emprendedor';
    } else {
        $dashPlanName = 'Negocio';
    }
@endphp

<div class="admin-dashboard-page">
    {{-- Bienvenida --}}
    <div class="admin-dash-welcome rounded-2xl p-4 md:p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="space-y-1 min-w-0">
                <h1 class="text-xl md:text-2xl font-extrabold text-[var(--ui-text)] tracking-tight truncate">
                    ¡Hola de nuevo, {{ $shopName }}! 👋
                </h1>
                <p class="text-xs md:text-sm text-[var(--ui-text-muted)] max-w-xl leading-snug font-medium">
                    Resumen de tu tienda: pedidos, inventario y rendimiento semanal.
                </p>
            </div>
            <a href="/{{ config('current_shop')->slug }}" target="_blank" class="admin-btn-store-live shrink-0">
                <span>Ver Tu Tienda en Vivo</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
            </a>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="admin-dash-kpis grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <div class="admin-dash-stat rounded-2xl p-4 relative">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Pedidos Totales</span>
                    <p class="text-xl md:text-2xl font-black text-[var(--ui-text)] leading-none">{{ number_format($ordersCount) }}</p>
                    <span class="text-[9px] {{ $weeklyTrendUp ? 'text-emerald-600' : 'text-rose-600' }} font-bold mt-1.5 inline-flex items-center gap-1">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="{{ $weeklyTrendUp ? '23 6 13.5 15.5 8.5 10.5 1 18' : '23 18 13.5 8.5 8.5 13.5 1 6' }}"></polyline></svg>
                        {{ $weeklyTrendLabel }}
                    </span>
                </div>
                @if($sparklinePoints)
                <svg class="shrink-0 mt-0.5" width="64" height="24" viewBox="0 0 72 28" aria-hidden="true">
                    <polyline fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="{{ $sparklinePoints }}"/>
                </svg>
                @endif
            </div>
        </div>

        <div class="admin-dash-stat rounded-2xl p-4">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Productos</span>
                    <p class="text-xl md:text-2xl font-black text-[var(--ui-text)] leading-none">{{ number_format($productsCount) }}</p>
                    <span class="text-[9px] text-[var(--ui-text-muted)] font-semibold mt-1.5 block">{{ $categoriesCount }} Categorías Activas</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                </div>
            </div>
        </div>

        <div class="admin-dash-stat rounded-2xl p-4">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Clientes</span>
                    <p class="text-xl md:text-2xl font-black text-[var(--ui-text)] leading-none">{{ number_format($clientsCount) }}</p>
                    <span class="text-[9px] text-[var(--ui-text-muted)] font-semibold mt-1.5 block">{{ $newClientsThisMonth }} nuevos este mes</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-sky-500/10 text-sky-600 flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
            </div>
        </div>

        <div class="admin-dash-stat rounded-2xl p-4">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <span class="text-[9px] font-extrabold text-[var(--ui-text-muted)] uppercase tracking-widest block mb-1">Plan de Negocio</span>
                    <p class="text-base font-black text-[var(--ui-text)] leading-tight">{{ $dashPlanName }}</p>
                    <span class="inline-block mt-1.5 text-[8px] font-black uppercase tracking-wider text-emerald-600 bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded-full">Plan Activo</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-violet-500/10 text-violet-600 flex items-center justify-center shrink-0 text-base">👑</div>
            </div>
        </div>
    </div>

    {{-- Gráfico + accesos rápidos --}}
    <div class="admin-dash-bottom grid grid-cols-1 lg:grid-cols-5 gap-3 md:gap-4 min-h-0">
        <div class="lg:col-span-3 admin-dash-panel rounded-2xl p-4 md:p-5 flex flex-col min-h-0">
            <div class="flex flex-wrap items-end justify-between gap-2 mb-2 shrink-0">
                <div>
                    <h2 class="text-[9px] font-extrabold uppercase tracking-[0.18em] text-[var(--ui-text-muted)]">Resumen de rendimiento de la semana</h2>
                    <p class="text-xl md:text-2xl font-black text-[var(--ui-text)] mt-1 tracking-tight">
                        ${{ $weeklyParts[0] }}<span class="text-base text-[var(--ui-text-muted)]">.{{ $weeklyParts[1] }}</span>
                        <span class="text-xs font-bold {{ $weeklyTrendUp ? 'text-emerald-600' : 'text-rose-600' }} ml-1">({{ $weeklyTrendLabel }})</span>
                    </p>
                </div>
                <a href="/{{ config('current_shop')->slug }}/admin/analytics" class="text-[9px] font-bold text-primary hover:underline uppercase tracking-wider shrink-0">Ver analítica →</a>
            </div>
            <div class="admin-dash-chart-wrap flex-1 min-h-[120px] lg:min-h-0">
                <canvas id="dashboardWeekChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 admin-dash-panel rounded-2xl p-4 md:p-5 flex flex-col min-h-0">
            <h2 class="text-[9px] font-extrabold uppercase tracking-[0.18em] text-[var(--ui-text-muted)] mb-3 shrink-0">Accesos Rápidos</h2>
            <div class="admin-dash-quick-list">
                @php
                    $quickLinks = [
                        ['/' . config('current_shop')->slug . '/admin/products', '📦', 'Cargar Productos', 'bg-amber-500/15'],
                        ['/' . config('current_shop')->slug . '/admin/settings', '🎨', 'Personalizar Tienda', 'bg-violet-500/15'],
                        ['/' . config('current_shop')->slug . '/admin/analytics', '📊', 'Ver Rendimiento', 'bg-sky-500/15'],
                    ];
                    if ($planHasBusinessModules ?? true) {
                        $quickLinks[] = ['/' . config('current_shop')->slug . '/admin/orders', '📋', 'Gestionar Pedidos', 'bg-emerald-500/15'];
                    }
                @endphp
                @foreach($quickLinks as [$href, $icon, $title, $iconBg])
                <a href="{{ $href }}" class="admin-quick-link group">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="admin-quick-icon {{ $iconBg }}">{{ $icon }}</span>
                        <span class="text-xs md:text-sm font-bold text-[var(--ui-text)] truncate">{{ $title }}</span>
                    </div>
                    <span class="text-[var(--ui-text-muted)] group-hover:text-primary transition-colors text-sm font-black shrink-0">→</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('dashboardWeekChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const primaryColor = '{{ config('current_shop')->color_primary ?? '#2563eb' }}';
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(148, 163, 184, 0.12)' : 'rgba(148, 163, 184, 0.25)';
        const textColor = isDark ? '#94a3b8' : '#64748b';

        const gradient = ctx.createLinearGradient(0, 0, 0, 160);
        gradient.addColorStop(0, primaryColor + '35');
        gradient.addColorStop(1, primaryColor + '00');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Ventas',
                    data: {!! json_encode($chartData) !!},
                    borderColor: primaryColor,
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    pointBackgroundColor: isDark ? '#1e293b' : '#ffffff',
                    pointBorderColor: primaryColor,
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#fff',
                        titleColor: isDark ? '#f1f5f9' : '#0f172a',
                        bodyColor: isDark ? '#cbd5e1' : '#475569',
                        borderColor: isDark ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 8,
                        callbacks: {
                            label: function(ctx) {
                                return ' $' + Number(ctx.parsed.y).toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, font: { size: 10, weight: '600' }, maxRotation: 0 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: {
                            color: textColor,
                            font: { size: 9 },
                            maxTicksLimit: 5,
                            callback: function(v) { return '$' + v; }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
