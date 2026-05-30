@extends('layouts.super-admin')

@section('title', 'Empresas — Super Admin')

@section('page-header')
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Empresas</h1>
    <p class="text-sm text-slate-500 mt-1">Lista global, activación de tiendas y aprobación de pagos.</p>
@endsection

@section('content')
<div class="w-full" x-data="{
    showCreateModal: false,
    showEditModal: false,
    showPassword: false,
    createPlan: 'standard',
    createBillingCycle: 'mensual',
    editingShop: {
        id: null,
        name: '',
        slug: '',
        shop_category: 'otros',
        whatsapp_number: '',
        email: '',
        password: '',
        temp_password: '',
        plan: 'standard',
        billing_cycle: 'mensual',
        plan_expires_at: '',
        last_payment_date: '',
        last_payment_amount: '',
        color_primary: '#E60067',
        color_secondary: '#0B132B',
        color_background: '#FFF0F8',
        logo_path: '',
        cover_path: '',
        description: '',
        address: ''
    },
    openEdit(shop) {
        this.editingShop = {
            id: shop.id,
            name: shop.name || '',
            slug: shop.slug || '',
            whatsapp_number: shop.whatsapp_number || '',
            email: shop.users && shop.users.length ? shop.users[0].email : '',
            password: '',
            temp_password: shop.users && shop.users.length ? (shop.users[0].temp_password || '') : '',
            plan: shop.plan || 'standard',
            billing_cycle: shop.billing_cycle || 'mensual',
            plan_expires_at: shop.plan_expires_at || '',
            last_payment_date: shop.last_payment_date || '',
            last_payment_amount: shop.last_payment_amount || '',
            color_primary: shop.color_primary || '#E60067',
            color_secondary: shop.color_secondary || '#0B132B',
            color_background: shop.color_background || '#FFF0F8',
            shop_category: shop.shop_category || 'otros',
            logo_path: shop.logo_path || '',
            cover_path: shop.cover_path || '',
            description: shop.description || '',
            address: shop.address || ''
        };
        this.showEditModal = true;
        this.showPassword = false;
    }
}">
<!-- MAIN LAYOUT GRID (ANCHO COMPLETO) -->
        <div class="w-full">

            @if(isset($pendingShops) && $pendingShops->count() > 0)
            <!-- PANEL: PENDING PAYMENTS (100% Ancho) -->
            <section class="w-full flex flex-col gap-6 mb-8">
                <!-- Pending Payments Card -->
                <div class="sa-panel rounded-3xl p-6 md:p-8 shadow-xl border border-rose-500/20 relative overflow-hidden">
                    <div class="absolute -top-24 -left-24 w-48 h-48 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="flex h-3.5 w-3.5 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-450 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-rose-500"></span>
                                </span>
                                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Pagos Pendientes de Aprobación</h2>
                            </div>
                            <p class="text-xs text-slate-500">Hay tiendas que han reportado un pago móvil. Verifica los datos y el comprobante antes de aprobar.</p>
                        </div>
                        <div class="shrink-0">
                            <span class="bg-rose-500/15 border border-rose-500/35 text-rose-700 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider animate-pulse font-mono">
                                {{ $pendingShops->count() }} Por Confirmar
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider pb-3">
                                    <th class="py-3 px-4">Tienda / Slug</th>
                                    <th class="py-3 px-4">Plan Solicitado</th>
                                    <th class="py-3 px-4">Referencia</th>
                                    <th class="py-3 px-4">Fecha de Envío</th>
                                    <th class="py-3 px-4 text-center">Comprobante</th>
                                    <th class="py-3 px-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingShops as $pendingShop)
                                    <tr class="border-b border-slate-200 hover:bg-slate-50 transition duration-200">
                                        <!-- Shop Column -->
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 flex items-center justify-center shrink-0">
                                                    @if ($pendingShop->logo_path)
                                                        <img src="{{ filter_var($pendingShop->logo_path, FILTER_VALIDATE_URL) ? $pendingShop->logo_path : asset('storage/' . $pendingShop->logo_path) }}"
                                                            alt="Logo" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fas fa-store text-slate-500 text-sm"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h3 class="text-sm font-bold text-slate-900">{{ $pendingShop->name }}</h3>
                                                    <span class="text-[10px] text-slate-500 font-semibold">/{{ $pendingShop->slug }}</span>
                                                    @if($pendingShop->payment_company_name)
                                                        <div class="text-[10px] text-purple-300 mt-1 flex items-center gap-1.5">
                                                            <i class="fas fa-building text-[8px] opacity-75"></i>
                                                            <span>Empresa: <strong class="text-slate-900 font-extrabold">{{ $pendingShop->payment_company_name }}</strong></span>
                                                        </div>
                                                    @endif
                                                    @if($pendingShop->payment_company_email)
                                                        <div class="text-[10px] text-slate-600 flex items-center gap-1.5 mt-0.5">
                                                            <i class="fas fa-envelope text-[8px] opacity-75"></i>
                                                            <span>Correo: <strong class="text-slate-200 font-extrabold">{{ $pendingShop->payment_company_email }}</strong></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Plan Solicitado -->
                                        <td class="py-4 px-4">
                                            <div class="flex flex-col gap-0.5">
                                                @if($pendingShop->pending_plan === 'premium')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-500/10 border border-amber-500/30 text-amber-400 uppercase tracking-wider max-w-max premium-glow">
                                                        <i class="fas fa-crown text-[9px]"></i> Negocio
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-500/10 border border-sky-500/20 text-sky-400 uppercase tracking-wider max-w-max">
                                                        <i class="fas fa-award text-[9px]"></i> Emprendedor
                                                    </span>
                                                @endif
                                                <span class="text-[9px] text-slate-500 uppercase tracking-wider pl-1.5 font-semibold">
                                                    Ciclo: {{ $pendingShop->pending_billing_cycle ?? 'mensual' }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Referencia -->
                                        <td class="py-4 px-4">
                                            <span class="text-xs font-mono font-black text-white bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg">
                                                {{ $pendingShop->payment_reference }}
                                            </span>
                                        </td>

                                        <!-- Fecha de Envío -->
                                        <td class="py-4 px-4">
                                            <span class="text-xs text-slate-600">
                                                {{ $pendingShop->payment_submitted_at ? $pendingShop->payment_submitted_at->format('d/m/Y h:i A') : 'No registrada' }}
                                            </span>
                                        </td>

                                        <!-- Comprobante -->
                                        <td class="py-4 px-4 text-center">
                                            @if ($pendingShop->payment_receipt_path)
                                                <a href="{{ asset('storage/' . $pendingShop->payment_receipt_path) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-600 hover:text-violet-300 bg-violet-500/10 hover:bg-violet-500/20 border border-violet-500/20 px-3 py-1.5 rounded-xl transition duration-200">
                                                    <i class="fas fa-image text-[11px]"></i>
                                                    <span>Ver Comprobante</span>
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-500 italic">Sin comprobante</span>
                                            @endif
                                        </td>

                                        <!-- Acciones -->
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            <div class="flex justify-end gap-2">
                                                <!-- Form Aprobar -->
                                                <form action="{{ route('super-admin.payments.approve', $pendingShop->id) }}" method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de que deseas APROBAR este pago? Esto actualizará la suscripción de la tienda y le restablecerá el acceso inmediato.');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-xs font-black bg-emerald-600/10 hover:bg-emerald-600 hover:text-white border border-emerald-500/20 text-emerald-700 px-3.5 py-1.5 rounded-xl transition duration-200 inline-flex items-center gap-1 cursor-pointer">
                                                        <i class="fas fa-check text-[10px]"></i> Aprobar
                                                    </button>
                                                </form>

                                                <!-- Form Rechazar -->
                                                <form action="{{ route('super-admin.payments.reject', $pendingShop->id) }}" method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de que deseas RECHAZAR este pago? El administrador de la tienda verá la notificación y tendrá que reportar su pago móvil nuevamente.');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-xs font-black bg-rose-600/10 hover:bg-rose-600 hover:text-white border border-rose-500/20 text-rose-700 px-3.5 py-1.5 rounded-xl transition duration-200 inline-flex items-center gap-1 cursor-pointer">
                                                        <i class="fas fa-times text-[10px]"></i> Rechazar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            @endif

            <!-- PANEL: SHIPS LIST (100% Ancho) -->
            <section class="w-full flex flex-col gap-6">

                <!-- Table Card -->
                <div class="sa-panel rounded-3xl p-6 md:p-8 shadow-xl">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <i class="fas fa-list text-purple-600"></i>
                                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Tiendas Registradas</h2>
                            </div>
                            <p class="text-xs text-slate-500">Lista global y gestión de activación/desactivación de tu
                                plataforma SaaS.</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span
                                class="bg-violet-600/20 border border-violet-500/20 text-violet-300 px-3 py-1.5 rounded-full text-xs font-black">
                                {{ $shops->count() }} Empresas
                            </span>
                            <button @click="showCreateModal = true"
                                class="sa-btn-primary px-4 py-2 rounded-xl text-xs font-black text-white flex items-center gap-2 transition duration-200">
                                <i class="fas fa-plus-circle text-sm"></i>
                                <span>Agregar Empresa</span>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar">
                        <table id="shops-table" class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider pb-3">
                                    <th class="py-3 px-4">Tienda / Slug</th>
                                    <th class="py-3 px-4">Categoría</th>
                                    <th class="py-3 px-4">Administrador</th>
                                    <th class="py-3 px-4">Plan Actual</th>
                                    <th class="py-3 px-4">Último Pago</th>
                                    <th class="py-3 px-4">Fecha Límite</th>
                                    <th class="py-3 px-4 text-center">Estado</th>
                                    <th class="py-3 px-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shops as $shop)
                                    <tr class="border-b border-slate-200 hover:bg-white/[0.01] transition duration-200">

                                        <!-- Shop Column -->
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 flex items-center justify-center shrink-0">
                                                    @if ($shop->logo_path)
                                                        <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/' . $shop->logo_path) }}"
                                                            alt="Logo" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fas fa-store text-slate-500 text-sm"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h3 class="text-sm font-bold text-slate-900">{{ $shop->name }}</h3>
                                                    <a href="/{{ $shop->slug }}" target="_blank"
                                                        class="text-[10px] text-purple-600 hover:underline font-semibold tracking-wide flex items-center gap-1 mt-0.5">
                                                        <span>/{{ $shop->slug }}</span>
                                                        <i class="fas fa-external-link-alt text-[8px] opacity-75"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Category -->
                                        <td class="py-4 px-4">
                                            @php
                                                $categoryLabels = [
                                                    'gastronomia' => '🍽️ Gastronomía',
                                                    'moda_estilo' => '👗 Moda y Estilo',
                                                    'detalles_regalos' => '🎁 Detalles y Regalos',
                                                    'servicios' => '🔧 Servicios',
                                                    'otros' => '📦 Otros',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-slate-900/70 border border-slate-200 text-slate-200 uppercase tracking-wider">
                                                {{ $categoryLabels[$shop->shop_category] ?? 'Sin categoría' }}
                                            </span>
                                        </td>

                                        <!-- Admin Email -->
                                        <td class="py-4 px-4">
                                            <div class="text-xs text-slate-600 font-semibold max-w-[140px] truncate">
                                                {{ $shop->users->first()->email ?? 'Sin admin' }}
                                            </div>
                                        </td>

                                        <!-- Plan -->
                                        <td class="py-4 px-4">
                                            <form action="{{ route('super-admin.shops.update-plan', $shop->id) }}" method="POST"
                                                class="flex flex-col items-start gap-1.5 min-w-[9.5rem]"
                                                @change="$event.target.form.requestSubmit()">
                                                @csrf
                                                @method('PATCH')
                                                <select name="plan"
                                                    class="w-full bg-white border border-white/15 rounded-lg py-1.5 pl-2 pr-7 text-[10px] font-bold text-white uppercase tracking-wide focus:outline-none focus:border-violet-500 cursor-pointer">
                                                    <option value="free_trial" @selected($shop->plan === 'free_trial')>Prueba {{ $wiStoreTrialDays }}d</option>
                                                    <option value="standard" @selected($shop->plan === 'standard')>Emprendedor</option>
                                                    <option value="premium" @selected($shop->plan === 'premium')>Negocio</option>
                                                </select>
                                                @if ($shop->plan !== 'free_trial')
                                                    <select name="billing_cycle"
                                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg py-1 pl-2 pr-6 text-[9px] font-semibold text-slate-600 uppercase tracking-wide focus:outline-none focus:border-violet-500 cursor-pointer">
                                                        <option value="mensual" @selected(($shop->billing_cycle ?? 'mensual') === 'mensual')>Mensual</option>
                                                        <option value="anual" @selected($shop->billing_cycle === 'anual')>Anual</option>
                                                    </select>
                                                @endif
                                            </form>
                                        </td>

                                        <!-- Last Payment Column -->
                                        <td class="py-4 px-4">
                                            @if ($shop->last_payment_amount)
                                                <div class="flex flex-col gap-0.5">
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-extrabold bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 max-w-max">
                                                        ${{ number_format($shop->last_payment_amount, 2) }}
                                                    </span>
                                                    @if ($shop->last_payment_date)
                                                        <span
                                                            class="text-[9px] text-slate-500">{{ $shop->last_payment_date->format('d/m/Y') }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-500 italic">No registrado</span>
                                            @endif
                                        </td>

                                        <!-- Plan Expiration Limit Date Column -->
                                        <td class="py-4 px-4">
                                            @if ($shop->plan_expires_at)
                                                @php
                                                    $isExpired = $shop->plan_expires_at->isPast();
                                                    $isExpiringSoon =
                                                        !$isExpired && $shop->plan_expires_at->diffInDays(now()) <= 3;
                                                @endphp
                                                @if ($isExpired)
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-black bg-rose-500/10 border border-rose-500/25 text-rose-400 uppercase tracking-wider">
                                                        <i class="fas fa-circle-exclamation text-[9px]"></i> Vencido
                                                        ({{ $shop->plan_expires_at->format('d/m/Y') }})
                                                    </span>
                                                @elseif($isExpiringSoon)
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-black bg-amber-500/10 border border-amber-500/25 text-amber-400 uppercase tracking-wider animate-pulse">
                                                        <i class="fas fa-clock text-[9px]"></i> Por vencer
                                                        ({{ $shop->plan_expires_at->format('d/m/Y') }})
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-50 border border-slate-200 text-slate-600 uppercase tracking-wider">
                                                        {{ $shop->plan_expires_at->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-xs text-slate-500 italic">Sin límite</span>
                                            @endif
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="py-4 px-4 text-center">
                                            @if ($shop->is_active)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 uppercase tracking-wider">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black bg-rose-500/10 border border-rose-500/30 text-rose-700 uppercase tracking-wider">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Toggle Status Action -->
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            @php
                                                $shopDataJson = json_encode([
                                                    'id' => $shop->id,
                                                    'name' => $shop->name,
                                                    'slug' => $shop->slug,
                                                    'whatsapp_number' => $shop->whatsapp_number,
                                                    'plan' => $shop->plan,
                                                    'shop_category' => $shop->shop_category ?? 'otros',
                                                    'billing_cycle' => $shop->billing_cycle ?? 'mensual',
                                                    'plan_expires_at' => $shop->plan_expires_at
                                                        ? $shop->plan_expires_at->format('Y-m-d')
                                                        : '',
                                                    'last_payment_date' => $shop->last_payment_date
                                                        ? $shop->last_payment_date->format('Y-m-d')
                                                        : '',
                                                    'last_payment_amount' => $shop->last_payment_amount ?? '',
                                                    'color_primary' => $shop->color_primary,
                                                    'color_secondary' => $shop->color_secondary,
                                                    'color_background' => $shop->color_background,
                                                    'logo_path' => $shop->logo_path,
                                                    'cover_path' => $shop->cover_path,
                                                    'description' => $shop->description,
                                                    'address' => $shop->address,
                                                    'users' => $shop->users->map(function ($u) {
                                                        return [
                                                            'email' => $u->email,
                                                            'temp_password' => $u->temp_password,
                                                        ];
                                                    }),
                                                ]);
                                            @endphp
                                            <button type="button" @click="openEdit({{ $shopDataJson }})"
                                                class="text-xs font-black bg-violet-600/10 hover:bg-violet-600 hover:text-white border border-violet-500/20 text-purple-600 px-3 py-1.5 rounded-xl transition duration-200 mr-1.5 inline-flex items-center gap-1">
                                                <i class="fas fa-gear text-[10px]"></i> Gestionar
                                            </button>
                                            <form action="{{ route('super-admin.shops.toggle', $shop->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @if ($shop->is_active)
                                                    <button type="submit"
                                                        class="text-xs font-black bg-rose-600/10 hover:bg-rose-600 hover:text-white border border-rose-500/20 text-rose-400 px-3 py-1.5 rounded-xl transition duration-200 inline-flex items-center">
                                                        Desactivar
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                        class="text-xs font-black bg-emerald-600/10 hover:bg-emerald-600 hover:text-white border border-emerald-500/20 text-emerald-400 px-3 py-1.5 rounded-xl transition duration-200 inline-flex items-center">
                                                        Activar
                                                    </button>
                                                @endif
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="py-8 text-center text-slate-500 text-xs font-semibold">
                                            <i class="fas fa-info-circle text-lg mb-2 block"></i>
                                            No hay tiendas registradas aún.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>

        </div>
    </main>

    <!-- CREATE STORE MODAL (Alpine interactive overlay) -->
    <div x-show="showCreateModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/30 backdrop-blur-sm flex items-center justify-center p-4 md:p-6"
        style="display: none;" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-205" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @keydown.escape.window="showCreateModal = false">

        <div class="relative w-full max-w-4xl sa-panel rounded-3xl p-6 md:p-8 border border-slate-200 shadow-2xl overflow-hidden max-h-[90vh] flex flex-col"
            @click.away="showCreateModal = false">

            <!-- Background Glows -->
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-violet-600/15 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none">
            </div>

            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-slate-200 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-violet-500/10">
                        <i class="fas fa-plus text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-white leading-tight">Agregar Nueva Empresa</h2>
                        <p class="text-[10px] text-purple-600 font-bold uppercase tracking-wider mt-0.5">Registra una
                            tienda y su administrador inicial</p>
                    </div>
                </div>
                <button type="button" @click="showCreateModal = false"
                    class="text-slate-500 hover:text-white w-8 h-8 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center transition duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable Form) -->
            <div class="overflow-y-auto py-6 pr-2 custom-scrollbar shrink grow">
                <form action="{{ route('super-admin.shops.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- LEFT COLUMN: Shop Core Info -->
                        <div class="space-y-4">
                            <h3
                                class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-slate-200 pb-1">
                                Información General</h3>

                            <!-- Shop Name -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Nombre
                                    de la Tienda</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-shop text-[11px]"></i>
                                    </span>
                                    <input type="text" name="name" required placeholder="Ej: Burger Palace"
                                        value="{{ old('name') }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">WhatsApp
                                    de Pedidos</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fab fa-whatsapp text-xs"></i>
                                    </span>
                                    <input type="text" name="whatsapp_number" required
                                        placeholder="Ej: +584121234567" value="{{ old('whatsapp_number') }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- Shop Category -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Categoría
                                    de la Tienda</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-tags text-[11px]"></i>
                                    </span>
                                    <select name="shop_category" required
                                        class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-8 text-xs text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                        <option value="gastronomia">🍽️ Gastronomía</option>
                                        <option value="moda_estilo">👗 Moda y Estilo</option>
                                        <option value="detalles_regalos">🎁 Detalles y Regalos</option>
                                        <option value="servicios">🔧 Servicios</option>
                                        <option value="otros">📦 Otros</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Plan Selection -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Plan
                                    de Suscripción</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-crown text-[11px]"></i>
                                    </span>
                                    <select name="plan" required x-model="createPlan"
                                        class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-8 text-xs text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                        <option value="free_trial">Prueba Gratis ({{ $wiStoreTrialDays }} Días)</option>
                                        <option value="standard">Plan Emprendedor</option>
                                        <option value="premium">Plan Negocio</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Billing Cycle Selection (Dynamic) -->
                            <div x-show="createPlan !== 'free_trial'" x-transition>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Frecuencia
                                    de Facturación</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-arrows-spin text-[11px]"></i>
                                    </span>
                                    <select name="billing_cycle" x-model="createBillingCycle" required
                                        class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-8 text-xs text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                        <option value="mensual">Pago Mensual (Precio Regular)</option>
                                        <option value="anual">Pago Anual (Descuento 20% - 30%)</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Subscription Initial Settings -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <h4 class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Detalles de
                                    Suscripción Inicial</h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            Límite</label>
                                        <input type="date" name="plan_expires_at"
                                            value="{{ now()->addDays(30)->format('Y-m-d') }}"
                                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-[10px] text-white focus:outline-none focus:border-violet-500 transition duration-200">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            de Pago</label>
                                        <input type="date" name="last_payment_date"
                                            value="{{ now()->format('Y-m-d') }}"
                                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-[10px] text-white focus:outline-none focus:border-violet-500 transition duration-200">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Monto
                                        de Pago ($)</label>
                                    <input type="number" step="0.01" name="last_payment_amount"
                                        placeholder="Dejar vacío para el monto por defecto del plan"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-[10px] text-white placeholder-slate-600 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- Description & Address -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Descripción</label>
                                    <textarea name="description" placeholder="Descripción de la tienda..." rows="2"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-white placeholder-slate-650 focus:outline-none focus:border-violet-500 transition duration-200 resize-none">{{ old('description') }}</textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Dirección
                                        Física</label>
                                    <textarea name="address" placeholder="Dirección del local..." rows="2"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-white placeholder-slate-650 focus:outline-none focus:border-violet-500 transition duration-200 resize-none">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: Color Branding, Admin User & Images -->
                        <div class="space-y-4">
                            <h3
                                class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-slate-200 pb-1">
                                Administración y Estilos</h3>

                            <!-- Admin Email & Password -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Correo
                                        Administrador</label>
                                    <input type="email" name="email" required placeholder="Ej: admin@tienda.com"
                                        value="{{ old('email') }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Contraseña
                                        de Acceso</label>
                                    <input type="password" name="password" required placeholder="Mínimo 6 caracteres"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- Colors Selection -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1.5 tracking-wider">Colores
                                    Corporativos</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <div
                                        class="flex flex-col items-center p-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <span
                                            class="text-[8px] font-bold text-slate-500 uppercase mb-0.5">Primario</span>
                                        <input type="color" name="color_primary" value="#E60067"
                                            class="w-6 h-6 rounded-full border-0 bg-transparent cursor-pointer">
                                    </div>
                                    <div
                                        class="flex flex-col items-center p-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <span
                                            class="text-[8px] font-bold text-slate-500 uppercase mb-0.5">Secundario</span>
                                        <input type="color" name="color_secondary" value="#0B132B"
                                            class="w-6 h-6 rounded-full border-0 bg-transparent cursor-pointer">
                                    </div>
                                    <div
                                        class="flex flex-col items-center p-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <span class="text-[8px] font-bold text-slate-500 uppercase mb-0.5">Fondo</span>
                                        <input type="color" name="color_background" value="#FFF0F8"
                                            class="w-6 h-6 rounded-full border-0 bg-transparent cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <!-- Media Uploads (Logo & Cover) -->
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Logo -->
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Logo</label>
                                    <input type="file" name="logo" accept="image/*"
                                        class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-650/20 file:text-violet-300 hover:file:bg-violet-650/30 cursor-pointer">
                                    <input type="text" name="logo_url" placeholder="URL opcional..."
                                        value="{{ old('logo_url') }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg py-1 px-2 text-[10px] text-white placeholder-slate-650 mt-1 focus:outline-none focus:border-violet-500">
                                </div>

                                <!-- Cover -->
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Portada</label>
                                    <input type="file" name="cover" accept="image/*"
                                        class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-650/20 file:text-violet-300 hover:file:bg-violet-650/30 cursor-pointer">
                                    <input type="text" name="cover_url" placeholder="URL opcional..."
                                        value="{{ old('cover_url') }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg py-1 px-2 text-[10px] text-white placeholder-slate-650 mt-1 focus:outline-none focus:border-violet-500">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Actions Footer -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 shrink-0">
                        <button type="button" @click="showCreateModal = false"
                            class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-50 border border-slate-200 text-slate-600 hover:bg-slate-100 transition duration-200">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-xl text-xs font-black text-white sa-btn-primary flex items-center gap-1.5">
                            <i class="fas fa-plus-circle"></i> Registrar Empresa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT STORE MODAL (Alpine interactive overlay) -->
    <div x-show="showEditModal"
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/30 backdrop-blur-sm flex items-center justify-center p-4 md:p-6"
        style="display: none;" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-205" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @keydown.escape.window="showEditModal = false">

        <div class="relative w-full max-w-4xl sa-panel rounded-3xl p-6 md:p-8 border border-slate-200 shadow-2xl overflow-hidden max-h-[90vh] flex flex-col"
            @click.away="showEditModal = false">

            <!-- Background Glows -->
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-violet-600/15 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none">
            </div>

            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b border-slate-200 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-tr from-violet-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-violet-500/10">
                        <i class="fas fa-sliders text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-white leading-tight">Gestionar Tienda</h2>
                        <p class="text-[10px] text-purple-600 font-bold uppercase tracking-wider mt-0.5">Editando:
                            <span class="text-white font-black" x-text="editingShop.name"></span></p>
                    </div>
                </div>
                <button type="button" @click="showEditModal = false"
                    class="text-slate-500 hover:text-white w-8 h-8 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center transition duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable Form) -->
            <div class="overflow-y-auto py-6 pr-2 custom-scrollbar shrink grow">
                <form :action="'/wydex-super-admin/shops/' + editingShop.id" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- LEFT COLUMN: Shop Core Info -->
                        <div class="space-y-4">
                            <h3
                                class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-slate-200 pb-1">
                                Información General</h3>

                            <!-- Shop Name -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Nombre
                                    de la Tienda</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-shop text-[11px]"></i>
                                    </span>
                                    <input type="text" name="name" required x-model="editingShop.name"
                                        placeholder="Ej: Burger Palace"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">WhatsApp
                                    de Pedidos</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fab fa-whatsapp text-xs"></i>
                                    </span>
                                    <input type="text" name="whatsapp_number" required
                                        x-model="editingShop.whatsapp_number" placeholder="Ej: +584121234567"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- Shop Category -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Categoría
                                    de la Tienda</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-tags text-[11px]"></i>
                                    </span>
                                    <select name="shop_category" required x-model="editingShop.shop_category"
                                        class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-8 text-xs text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                        <option value="gastronomia">🍽️ Gastronomía</option>
                                        <option value="moda_estilo">👗 Moda y Estilo</option>
                                        <option value="detalles_regalos">🎁 Detalles y Regalos</option>
                                        <option value="servicios">🔧 Servicios</option>
                                        <option value="otros">📦 Otros</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Plan Selection -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Plan
                                    de Suscripción</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-crown text-[11px]"></i>
                                    </span>
                                    <select name="plan" required x-model="editingShop.plan"
                                        class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-8 text-xs text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                        <option value="free_trial">Prueba Gratis ({{ $wiStoreTrialDays }} Días)</option>
                                        <option value="standard">Plan Emprendedor</option>
                                        <option value="premium">Plan Negocio</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Billing Cycle Selection (Dynamic) -->
                            <div x-show="editingShop.plan !== 'free_trial'" x-transition>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Frecuencia
                                    de Facturación</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 pointer-events-none">
                                        <i class="fas fa-arrows-spin text-[11px]"></i>
                                    </span>
                                    <select name="billing_cycle" required x-model="editingShop.billing_cycle"
                                        class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-8 text-xs text-white focus:outline-none focus:border-violet-500 transition duration-200 appearance-none cursor-pointer">
                                        <option value="mensual">Pago Mensual</option>
                                        <option value="anual">Pago Anual</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Subscription Details Editing -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <h4 class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Detalles de
                                    Suscripción</h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            Límite</label>
                                        <input type="date" name="plan_expires_at"
                                            x-model="editingShop.plan_expires_at"
                                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-[10px] text-white focus:outline-none focus:border-violet-500 transition duration-200">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            de Pago</label>
                                        <input type="date" name="last_payment_date"
                                            x-model="editingShop.last_payment_date"
                                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-[10px] text-white focus:outline-none focus:border-violet-500 transition duration-200">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Monto
                                        de Pago ($)</label>
                                    <input type="number" step="0.01" name="last_payment_amount"
                                        x-model="editingShop.last_payment_amount" placeholder="Ej: 10.00"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-[10px] text-white focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Descripción</label>
                                <textarea name="description" x-model="editingShop.description" placeholder="Descripción de la tienda..."
                                    rows="2"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-white placeholder-slate-650 focus:outline-none focus:border-violet-500 transition duration-200 resize-none"></textarea>
                            </div>

                            <!-- Address -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Dirección
                                    Física</label>
                                <textarea name="address" x-model="editingShop.address" placeholder="Dirección del local..." rows="2"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 px-3 text-xs text-white placeholder-slate-650 focus:outline-none focus:border-violet-500 transition duration-200 resize-none"></textarea>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: Color Branding, Admin User & Images -->
                        <div class="space-y-4">
                            <h3
                                class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-slate-200 pb-1">
                                Administración y Estilos</h3>

                            <!-- Admin Email & Password -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Correo
                                        Administrador</label>
                                    <input type="email" name="email" required x-model="editingShop.email"
                                        placeholder="admin@tienda.com"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label
                                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Nueva
                                            Contraseña</label>
                                        <div class="text-[10px] text-slate-500">
                                            Contraseña actual:
                                            <code
                                                class="bg-violet-950 px-1.5 py-0.5 rounded font-mono text-violet-300 relative inline-flex items-center gap-1">
                                                <span
                                                    x-text="showPassword ? (editingShop.temp_password || 'Sin registrar') : '••••••'"></span>
                                                <button type="button" @click="showPassword = !showPassword"
                                                    class="focus:outline-none hover:text-white text-purple-600 ml-0.5">
                                                    <i class="fas text-[9px]"
                                                        :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                                </button>
                                            </code>
                                        </div>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        placeholder="Dejar en blanco para mantener la misma..."
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-1.5 px-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-violet-500 transition duration-200">
                                </div>
                            </div>

                            <!-- Colors Selection -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1.5 tracking-wider">Colores
                                    Corporativos</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <div
                                        class="flex flex-col items-center p-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <span
                                            class="text-[8px] font-bold text-slate-500 uppercase mb-0.5">Primario</span>
                                        <input type="color" name="color_primary"
                                            x-model="editingShop.color_primary"
                                            class="w-6 h-6 rounded-full border-0 bg-transparent cursor-pointer">
                                    </div>
                                    <div
                                        class="flex flex-col items-center p-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <span
                                            class="text-[8px] font-bold text-slate-500 uppercase mb-0.5">Secundario</span>
                                        <input type="color" name="color_secondary"
                                            x-model="editingShop.color_secondary"
                                            class="w-6 h-6 rounded-full border-0 bg-transparent cursor-pointer">
                                    </div>
                                    <div
                                        class="flex flex-col items-center p-1.5 rounded-xl bg-slate-50 border border-slate-200">
                                        <span class="text-[8px] font-bold text-slate-500 uppercase mb-0.5">Fondo</span>
                                        <input type="color" name="color_background"
                                            x-model="editingShop.color_background"
                                            class="w-6 h-6 rounded-full border-0 bg-transparent cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <!-- Media Uploads (Logo & Cover) -->
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Logo -->
                                <div>
                                    <div class="flex items-center gap-1.5 mb-1 justify-between">
                                        <label
                                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Logo</label>
                                        <!-- Thumbnail -->
                                        <div x-show="editingShop.logo_path"
                                            class="w-5 h-5 rounded-full overflow-hidden border border-white/20 bg-slate-800 flex items-center justify-center shrink-0">
                                            <img :src="editingShop.logo_path && editingShop.logo_path.startsWith('http') ?
                                                editingShop.logo_path : '/storage/' + editingShop.logo_path"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <input type="file" name="logo" accept="image/*"
                                        class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-650/20 file:text-violet-300 hover:file:bg-violet-650/30 cursor-pointer">
                                    <input type="text" name="logo_url" x-model="editingShop.logo_path"
                                        placeholder="URL opcional..."
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg py-1 px-2 text-[10px] text-white placeholder-slate-650 mt-1 focus:outline-none focus:border-violet-500">
                                </div>

                                <!-- Cover -->
                                <div>
                                    <div class="flex items-center gap-1.5 mb-1 justify-between">
                                        <label
                                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Portada</label>
                                        <!-- Thumbnail -->
                                        <div x-show="editingShop.cover_path"
                                            class="w-5 h-5 rounded overflow-hidden border border-white/20 bg-slate-800 flex items-center justify-center shrink-0">
                                            <img :src="editingShop.cover_path && editingShop.cover_path.startsWith('http') ?
                                                editingShop.cover_path : '/storage/' + editingShop.cover_path"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <input type="file" name="cover" accept="image/*"
                                        class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-650/20 file:text-violet-300 hover:file:bg-violet-650/30 cursor-pointer">
                                    <input type="text" name="cover_url" x-model="editingShop.cover_path"
                                        placeholder="URL opcional..."
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg py-1 px-2 text-[10px] text-white placeholder-slate-650 mt-1 focus:outline-none focus:border-violet-500">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Actions Footer -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 shrink-0">
                        <button type="button" @click="showEditModal = false"
                            class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-50 border border-slate-200 text-slate-600 hover:bg-slate-100 transition duration-200">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-xl text-xs font-black text-white sa-btn-primary flex items-center gap-1.5">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
@endsection

@push('scripts')
<!-- Scripts -->
    <script>
        $(document).ready(function() {
            $('#shops-table').DataTable({
                language: {
                    processing: "Procesando...",
                    search: "Buscar tienda:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ empresas",
                    infoEmpty: "Mostrando 0 a 0 de 0 empresas",
                    infoFiltered: "(filtrado de _MAX_ registros en total)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ninguna empresa registrada en la plataforma",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    },
                    aria: {
                        sortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: 6
                    } // Disable sorting on actions column
                ],
                pageLength: 10,
                order: [
                    [0, "desc"]
                ] // Alphabetical or registration sorting by default
            });
        });
    </script>

@endpush
