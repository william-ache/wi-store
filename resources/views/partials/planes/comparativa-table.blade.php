{{-- Comparativa resumida + filas expandibles (Alpine) --}}
@php
    $check = '<i class="fas fa-check text-purple-400/70 text-sm"></i>';
    $cross = '<i class="fas fa-times text-slate-600 text-sm"></i>';
    $summaryRows = [
        ['Catálogo y pedidos a WhatsApp', [$check, $check, $check, $check]],
        ['Productos activos', ['Hasta 15', 'Ilimitados', 'Ilimitados', 'Ilimitados']],
        ['Personalización de marca', ['Básica', 'Completa', 'Completa', 'A medida']],
        ['Métodos de pago (Pago Móvil / Zelle)', [$cross, $cross, $check, $check]],
        ['Tasa BCV automática', [$cross, $check, $check, $check]],
        ['Soporte técnico', ['48h', '24h', 'VIP 12h', '24/7 dedicado']],
    ];
    $detailRows = [
        ['Enlace corto personalizado', [$check, $check, $check, $check]],
        ['Categorías de productos', ['Hasta 3', 'Ilimitadas', 'Ilimitadas', 'Ilimitadas']],
        ['Comisiones por venta', ['0%', '0%', '0%', '0%']],
        ['Logo y portada', [$check, $check, $check, $check]],
        ['Insignia VIP en tienda', [$cross, $cross, $check, 'Opcional']],
        ['Dominio propio', [$cross, $cross, $cross, $check]],
        ['Infraestructura', ['SaaS', 'SaaS', 'SaaS', 'Servidor dedicado']],
        ['Panel super admin', [$cross, $cross, $cross, 'Opcional']],
    ];
@endphp

<div class="overflow-x-auto pb-2 scrollbar-none rounded-2xl border border-white/10 bg-white/[0.03] backdrop-blur-md"
     x-data="{ showAll: false }">
    <table class="w-full text-left border-collapse min-w-[720px] text-sm">
        <thead>
            <tr class="border-b border-white/10">
                <th class="p-4 w-[28%]">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Característica</span>
                </th>
                <th class="p-4 border-l border-white/5 text-center">
                    <span class="text-xs font-black text-white uppercase">Prueba</span>
                    <p class="text-[10px] text-slate-500 mt-1">7 días gratis</p>
                </th>
                <th class="p-4 border-l border-white/5 text-center">
                    <span class="text-xs font-black text-white uppercase">Standard</span>
                    <p class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-300/90 to-cyan-300/90 mt-1">Muy pronto</p>
                </th>
                <th class="p-4 border-l border-purple-500/20 text-center bg-purple-500/[0.06] relative">
                    <span class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-purple-500/50 via-fuchsia-500/40 to-cyan-400/50"></span>
                    <span class="landing-plan-badge landing-plan-badge--vip-premium text-[8px] px-2 py-0.5 rounded-full inline-block mb-1">Recomendado</span>
                    <span class="text-xs font-black text-white uppercase block">Premium</span>
                    <p class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-cyan-300 mt-1">Muy pronto</p>
                </th>
                <th class="p-4 border-l border-white/5 text-center">
                    <span class="text-xs font-black text-white uppercase">Custom</span>
                    <p class="text-[10px] text-slate-500 mt-1">A medida</p>
                </th>
            </tr>
        </thead>
        <tbody class="text-slate-300 divide-y divide-white/5">
            @foreach ($summaryRows as [$label, $cells])
                <tr class="hover:bg-white/[0.02]">
                    <td class="p-3.5 pl-4 font-semibold text-xs text-slate-200">{{ $label }}</td>
                    @foreach ($cells as $i => $cell)
                        <td class="p-3.5 border-l border-white/5 text-center text-xs {{ $i === 2 ? 'bg-purple-500/[0.04]' : '' }}">
                            {!! str_contains($cell, '<') ? $cell : e($cell) !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            @foreach ($detailRows as [$label, $cells])
                <tr x-show="showAll" x-cloak class="hover:bg-white/[0.02]">
                    <td class="p-3.5 pl-4 font-medium text-xs text-slate-400">{{ $label }}</td>
                    @foreach ($cells as $i => $cell)
                        <td class="p-3.5 border-l border-white/5 text-center text-xs {{ $i === 2 ? 'bg-purple-500/[0.04]' : '' }}">
                            {!! str_contains($cell, '<') ? $cell : e($cell) !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 border-t border-white/10 text-center">
        <button type="button" @click="showAll = !showAll"
            class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wide text-purple-300/90 hover:text-cyan-300/90 transition-colors">
            <span x-text="showAll ? 'Ver menos detalle' : 'Ver comparativa completa'"></span>
            <i class="fas fa-chevron-down text-[10px] transition-transform" :class="showAll && 'rotate-180'"></i>
        </button>
    </div>
</div>
