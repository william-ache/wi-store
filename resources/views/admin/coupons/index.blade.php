@extends('layouts.admin')

@section('title', 'Cupones de Descuento')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <!-- CABECERA DE LA PÁGINA -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-white tracking-tight">Cupones de Descuento</h2>
            <p class="text-xs text-slate-450 dark:text-slate-500 font-semibold mt-0.5">
                Crea códigos promocionales por porcentaje o monto fijo para incentivar compras en tu menú.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
            <x-admin.excel-toolbar entity="coupons" />
            <button type="button" @click="document.getElementById('new-coupon-card').classList.toggle('hidden'); document.getElementById('new-coupon-card').scrollIntoView({ behavior: 'smooth' })"
                class="px-5 py-3 bg-purple-650 hover:bg-purple-750 text-white font-extrabold text-xs uppercase tracking-widest rounded-2xl shadow-md hover:shadow-lg active:scale-[0.98] transition-all duration-300 flex items-center gap-2 cursor-pointer border border-white/5 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
            <span>Nuevo Cupón</span>
        </button>
        </div>
    </div>

    <!-- MENSAJES DE ÉXITO O ERROR -->
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-4 text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-2.5 shadow-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- FORMULARIO NUEVO CUPÓN (Oculto por defecto, se revela al pulsar el botón) -->
    <div id="new-coupon-card" class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-[28px] p-6 sm:p-8 shadow-sm transition-colors duration-300 hidden">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800/40 mb-6">
            <h3 class="text-sm font-black text-slate-850 dark:text-white uppercase tracking-wider">Crear Nuevo Cupón de Descuento</h3>
            <button type="button" @click="document.getElementById('new-coupon-card').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.coupons.store', ['shop_slug' => config('current_shop')->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- 1. CÓDIGO DE CUPÓN -->
                <div class="space-y-1.5">
                    <label for="code" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Código de Cupón</label>
                    <input type="text" name="code" id="code" required placeholder="Ej: VERANO20, CLIENTEVIP" value="{{ old('code') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300 uppercase">
                    @error('code')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 2. TIPO DE DESCUENTO -->
                <div class="space-y-1.5">
                    <label for="type" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Tipo de Descuento</label>
                    <select name="type" id="type" required
                            class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Monto Fijo ($)</option>
                    </select>
                    @error('type')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- 3. VALOR DEL DESCUENTO -->
                <div class="space-y-1.5">
                    <label for="value" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Valor del Descuento</label>
                    <input type="number" step="0.01" name="value" id="value" required placeholder="Ej: 20 (para 20%) o 5.00 (para $5.00)" value="{{ old('value') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                    @error('value')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 4. COMPRA MÍNIMA REQUERIDA -->
                <div class="space-y-1.5">
                    <label for="min_order_amount" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Monto Mínimo de Compra ($)</label>
                    <input type="number" step="0.01" name="min_order_amount" id="min_order_amount" required placeholder="Ej: 10.00 (Opcional, 0 por defecto)" value="{{ old('min_order_amount', '0.00') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                    @error('min_order_amount')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- 5. LÍMITE MÁXIMO DE USOS -->
                <div class="space-y-1.5">
                    <label for="usage_limit" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Límite Máximo de Usos (Total)</label>
                    <input type="number" name="usage_limit" id="usage_limit" placeholder="Ej: 100 (Vacío para usos ilimitados)" value="{{ old('usage_limit') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                    @error('usage_limit')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 6. FECHA DE EXPIRACIÓN -->
                <div class="space-y-1.5">
                    <label for="expires_at" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">Fecha de Expiración</label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                    @error('expires_at')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- BOTONES ACCIÓN -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" @click="document.getElementById('new-coupon-card').classList.add('hidden')"
                        class="px-5 py-3.5 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-slate-500 dark:text-slate-350 font-extrabold text-xs uppercase tracking-widest rounded-2xl transition active:scale-[0.98] cursor-pointer">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-4 bg-purple-650 hover:bg-purple-750 text-white font-extrabold text-xs uppercase tracking-widest rounded-2xl shadow-md hover:shadow-lg active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer border border-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Guardar Cupón</span>
                </button>
            </div>
        </form>
    </div>

    <!-- MIS CUPONES EXISTENTES -->
    <div class="space-y-4">
        <h3 class="text-sm font-black text-slate-850 dark:text-white pl-1 uppercase tracking-wider">
            Cupones Activos e Historial
        </h3>

        @if($coupons->isEmpty())
            <!-- ESTADO VACÍO CARD -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-[28px] p-12 text-center shadow-sm transition-colors duration-300 select-none">
                <div class="w-16 h-16 rounded-3xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100/50 dark:border-slate-800/40 flex items-center justify-center mx-auto mb-4 text-slate-350 dark:text-slate-600 shadow-inner">
                    <i class="fa-solid fa-tags text-2xl"></i>
                </div>
                <p class="text-xs font-extrabold text-slate-400 dark:text-slate-500">
                    Aún no has creado ningún cupón de descuento.
                </p>
                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 max-w-xs mx-auto">
                    Haz clic en "Nuevo Cupón" para crear el primero y habilitar promociones en tu menú digital.
                </p>
            </div>
        @else
            <!-- LISTADO DE CUPONES -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($coupons as $coupon)
                    <div class="bg-white dark:bg-slate-900 border {{ $coupon->is_active ? 'border-slate-100 dark:border-slate-850/80' : 'border-slate-200/50 dark:border-slate-800/40 opacity-75' }} rounded-[24px] p-5 shadow-sm transition-colors duration-300 flex flex-col justify-between gap-4">
                        
                        <!-- Top Row: Code & Toggle -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="bg-purple-600/10 border border-purple-500/20 text-purple-600 dark:text-purple-400 font-black rounded-lg px-2.5 py-1 text-[11px] uppercase tracking-wider select-all select-none">
                                        🏷️ {{ $coupon->code }}
                                    </span>
                                    
                                    @if($coupon->expires_at && $coupon->expires_at->isPast())
                                        <span class="bg-rose-500/15 border border-rose-500/20 text-rose-550 dark:text-rose-400 font-extrabold rounded-md px-2 py-0.5 text-[8px] uppercase tracking-wide">
                                            Expirado
                                        </span>
                                    @elseif($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit)
                                        <span class="bg-amber-500/15 border border-amber-500/20 text-amber-600 dark:text-amber-400 font-extrabold rounded-md px-2 py-0.5 text-[8px] uppercase tracking-wide">
                                            Límite Agotado
                                        </span>
                                    @elseif(!$coupon->is_active)
                                        <span class="bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 font-extrabold rounded-md px-2 py-0.5 text-[8px] uppercase tracking-wide">
                                            Inactivo
                                        </span>
                                    @else
                                        <span class="bg-emerald-500/15 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-extrabold rounded-md px-2 py-0.5 text-[8px] uppercase tracking-wide animate-pulse">
                                            Activo
                                        </span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-black text-slate-800 dark:text-white leading-tight">
                                    @if($coupon->type === 'percentage')
                                        Descuento del {{ number_format($coupon->value, 0) }}%
                                    @else
                                        Descuento de ${{ number_format($coupon->value, 2) }}
                                    @endif
                                </h4>
                            </div>

                            <!-- Switch Toggle form -->
                            <form action="{{ route('admin.coupons.update', ['shop_slug' => config('current_shop')->slug, 'coupon' => $coupon->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="flex items-center justify-center p-2 rounded-lg {{ $coupon->is_active ? 'bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:bg-slate-200' }} transition-colors cursor-pointer" title="{{ $coupon->is_active ? 'Desactivar cupón' : 'Activar cupón' }}">
                                    <i class="fa-solid {{ $coupon->is_active ? 'fa-toggle-on text-lg' : 'fa-toggle-off text-lg' }}"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Mid row: Usage limits & Min Amount -->
                        <div class="space-y-2">
                            <!-- Progress usages bar -->
                            @if($coupon->usage_limit !== null)
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-400">
                                        <span>Usos consumidos</span>
                                        <span class="font-mono text-slate-600 dark:text-slate-350">{{ $coupon->used_count }} / {{ $coupon->usage_limit }}</span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 transition-all"
                                             style="width: {{ min(($coupon->used_count / $coupon->usage_limit) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 bg-slate-50 dark:bg-slate-800/30 px-3 py-1.5 rounded-lg border border-slate-100/50 dark:border-slate-800/30">
                                    <span>Límite de usos:</span>
                                    <span class="text-emerald-500 font-extrabold uppercase tracking-wider text-[8px]"><i class="fas fa-infinity mr-1"></i> Usos Ilimitados</span>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-3 text-[10px] font-bold text-slate-400 pt-1">
                                <div class="bg-slate-50 dark:bg-slate-800/30 p-2 rounded-xl border border-slate-100/50 dark:border-slate-800/30">
                                    <span class="block text-[8px] uppercase tracking-wider text-slate-500">Compra Mínima</span>
                                    <span class="text-slate-700 dark:text-slate-200 font-mono mt-0.5 block">${{ number_format($coupon->min_order_amount, 2) }}</span>
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-800/30 p-2 rounded-xl border border-slate-100/50 dark:border-slate-800/30">
                                    <span class="block text-[8px] uppercase tracking-wider text-slate-500">Expiración</span>
                                    <span class="text-slate-700 dark:text-slate-200 font-mono mt-0.5 block">
                                        {{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y') : 'Sin Límite' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom row: Delete -->
                        <div class="flex items-center justify-between pt-2 border-t border-slate-50 dark:border-slate-800/40">
                            <span class="text-[9px] font-bold text-slate-450 dark:text-slate-500">
                                Creado el {{ $coupon->created_at->format('d/m/Y') }}
                            </span>

                            <form action="{{ route('admin.coupons.destroy', ['shop_slug' => config('current_shop')->slug, 'coupon' => $coupon->id]) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cupón de descuento permanentemente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 hover:bg-rose-500/10 px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider transition-colors cursor-pointer">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
