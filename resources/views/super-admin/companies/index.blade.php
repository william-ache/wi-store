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
            last_payment_amount: shop.last_payment_amount != null && shop.last_payment_amount !== '' ? String(shop.last_payment_amount) : '',
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

                    <div class="sa-table-wrap">
                        <table class="sa-table w-full text-left border-collapse">
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
                                            <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg">
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

            <div class="sa-panel p-5 md:p-6 lg:p-7">
                @include('partials.super-admin.companies-table')
            </div>

        </div>

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
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Agregar Nueva Empresa</h2>
                        <p class="text-[10px] text-purple-600 font-bold uppercase tracking-wider mt-0.5">Registra una
                            tienda y su administrador inicial</p>
                    </div>
                </div>
                <button type="button" @click="showCreateModal = false"
                    class="text-slate-500 hover:text-slate-800 w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center transition duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable Form) -->
            <div class="sa-modal-scroll py-6 pr-2 shrink grow">
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
                                <div class="sa-field-wrap">
                                    <i class="fas fa-shop sa-field-wrap__icon" aria-hidden="true"></i>
                                    <input type="text" name="name" required placeholder="Ej: Burger Palace"
                                        value="{{ old('name') }}"
                                        class="sa-modal-field sa-modal-field--icon">
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">WhatsApp
                                    de Pedidos</label>
                                <div class="sa-field-wrap">
                                    <i class="fab fa-whatsapp sa-field-wrap__icon" aria-hidden="true"></i>
                                    <input type="text" name="whatsapp_number" required
                                        placeholder="Ej: +584121234567" value="{{ old('whatsapp_number') }}"
                                        class="sa-modal-field sa-modal-field--icon">
                                </div>
                            </div>

                            <!-- Shop Category -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Categoría
                                    de la Tienda</label>
                                @include('partials.super-admin.shop-category-select', ['selected' => old('shop_category', 'otros')])
                            </div>

                            <!-- Plan Selection -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Plan
                                    de Suscripción</label>
                                <div class="sa-field-wrap">
                                    <i class="fas fa-crown sa-field-wrap__icon" aria-hidden="true"></i>
                                    <select name="plan" required x-model="createPlan"
                                        class="sa-modal-field sa-modal-field--icon sa-modal-field--select">
                                        <option value="free_trial">Prueba Gratis ({{ $wiStoreTrialDays }} Días)</option>
                                        <option value="standard">Plan Emprendedor</option>
                                        <option value="premium">Plan Negocio</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Billing Cycle Selection (Dynamic) -->
                            <div x-show="createPlan !== 'free_trial'" x-transition>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Frecuencia
                                    de Facturación</label>
                                <div class="sa-field-wrap">
                                    <i class="fas fa-arrows-spin sa-field-wrap__icon" aria-hidden="true"></i>
                                    <select name="billing_cycle" x-model="createBillingCycle" required
                                        class="sa-modal-field sa-modal-field--icon sa-modal-field--select">
                                        <option value="mensual">Pago Mensual (Precio Regular)</option>
                                        <option value="anual">Pago Anual (Descuento 20% - 30%)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Subscription Initial Settings -->
                            <div class="sa-modal-subsection space-y-3">
                                <h4 class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Detalles de
                                    Suscripción Inicial</h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            Límite</label>
                                        <input type="date" name="plan_expires_at"
                                            value="{{ now()->addDays(30)->format('Y-m-d') }}"
                                            class="sa-modal-field text-sm">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            de Pago</label>
                                        <input type="date" name="last_payment_date"
                                            value="{{ now()->format('Y-m-d') }}"
                                            class="sa-modal-field text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Monto
                                        de Pago ($)</label>
                                    <input type="number" step="0.01" name="last_payment_amount"
                                        placeholder="Dejar vacío para el monto por defecto del plan"
                                        class="sa-modal-field text-sm" placeholder="Vacío = monto por defecto del plan">
                                </div>
                            </div>

                            <!-- Description & Address -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Descripción</label>
                                    <textarea name="description" placeholder="Descripción de la tienda..." rows="2"
                                        class="sa-modal-field resize-none">{{ old('description') }}</textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Dirección
                                        Física</label>
                                    <textarea name="address" placeholder="Dirección del local..." rows="2"
                                        class="sa-modal-field resize-none">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: Color Branding, Admin User & Images -->
                        <div class="space-y-4">
                            <h3
                                class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-slate-200 pb-1">
                                Administración y Estilos</h3>

                            <!-- Admin Email & Password -->
                            <div class="sa-modal-subsection space-y-3">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Correo
                                        Administrador</label>
                                    <input type="email" name="email" required placeholder="Ej: admin@tienda.com"
                                        value="{{ old('email') }}"
                                        class="sa-modal-field">
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Contraseña
                                        de Acceso</label>
                                    <input type="password" name="password" required placeholder="Mínimo 6 caracteres"
                                        class="sa-modal-field">
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
                                    <input type="file" name="logo" accept="image/*" class="sa-modal-file w-full">
                                    <input type="text" name="logo_url" placeholder="URL opcional..."
                                        value="{{ old('logo_url') }}"
                                        class="sa-modal-field text-sm mt-1">
                                </div>

                                <!-- Cover -->
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Portada</label>
                                    <input type="file" name="cover" accept="image/*" class="sa-modal-file w-full">
                                    <input type="text" name="cover_url" placeholder="URL opcional..."
                                        value="{{ old('cover_url') }}"
                                        class="sa-modal-field text-sm mt-1">
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
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Gestionar tienda</h2>
                        <p class="text-[10px] text-purple-700 font-bold uppercase tracking-wider mt-0.5">Editando:
                            <span class="text-slate-900 font-black" x-text="editingShop.name"></span></p>
                    </div>
                </div>
                <button type="button" @click="showEditModal = false"
                    class="text-slate-500 hover:text-slate-800 w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center transition duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable Form) -->
            <div class="sa-modal-scroll py-6 pr-2 shrink grow">
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
                                <div class="sa-field-wrap">
                                    <i class="fas fa-shop sa-field-wrap__icon" aria-hidden="true"></i>
                                    <input type="text" name="name" required x-model="editingShop.name"
                                        placeholder="Ej: Burger Palace"
                                        class="sa-modal-field sa-modal-field--icon">
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">WhatsApp
                                    de Pedidos</label>
                                <div class="sa-field-wrap">
                                    <i class="fab fa-whatsapp sa-field-wrap__icon" aria-hidden="true"></i>
                                    <input type="text" name="whatsapp_number" required
                                        x-model="editingShop.whatsapp_number" placeholder="Ej: +584121234567"
                                        class="sa-modal-field sa-modal-field--icon">
                                </div>
                            </div>

                            <!-- Shop Category -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Categoría
                                    de la Tienda</label>
                                @include('partials.super-admin.shop-category-select', ['model' => 'editingShop.shop_category'])
                            </div>

                            <!-- Plan Selection -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Plan
                                    de Suscripción</label>
                                <div class="sa-field-wrap">
                                    <i class="fas fa-crown sa-field-wrap__icon" aria-hidden="true"></i>
                                    <select name="plan" required x-model="editingShop.plan"
                                        class="sa-modal-field sa-modal-field--icon sa-modal-field--select">
                                        <option value="free_trial">Prueba Gratis ({{ $wiStoreTrialDays }} Días)</option>
                                        <option value="standard">Plan Emprendedor</option>
                                        <option value="premium">Plan Negocio</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Billing Cycle Selection (Dynamic) -->
                            <div x-show="editingShop.plan !== 'free_trial'" x-transition>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Frecuencia
                                    de Facturación</label>
                                <div class="sa-field-wrap">
                                    <i class="fas fa-arrows-spin sa-field-wrap__icon" aria-hidden="true"></i>
                                    <select name="billing_cycle" required x-model="editingShop.billing_cycle"
                                        class="sa-modal-field sa-modal-field--icon sa-modal-field--select">
                                        <option value="mensual">Pago Mensual</option>
                                        <option value="anual">Pago Anual</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Subscription Details Editing -->
                            <div class="sa-modal-subsection space-y-3">
                                <h4 class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Detalles de
                                    Suscripción</h4>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            Límite</label>
                                        <input type="date" name="plan_expires_at"
                                            x-model="editingShop.plan_expires_at"
                                            class="sa-modal-field text-sm">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Fecha
                                            de Pago</label>
                                        <input type="date" name="last_payment_date"
                                            x-model="editingShop.last_payment_date"
                                            class="sa-modal-field text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[9px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Monto
                                        de Pago ($)</label>
                                    <input type="number" step="0.01" name="last_payment_amount"
                                        x-model="editingShop.last_payment_amount" placeholder="Ej: 10.00"
                                        class="sa-modal-field text-sm">
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Descripción</label>
                                <textarea name="description" x-model="editingShop.description" placeholder="Descripción de la tienda..."
                                    rows="2"
                                    class="sa-modal-field resize-none"></textarea>
                            </div>

                            <!-- Address -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Dirección
                                    Física</label>
                                <textarea name="address" x-model="editingShop.address" placeholder="Dirección del local..." rows="2"
                                    class="sa-modal-field resize-none"></textarea>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: Color Branding, Admin User & Images -->
                        <div class="space-y-4">
                            <h3
                                class="text-xs font-black text-purple-600 uppercase tracking-widest border-b border-slate-200 pb-1">
                                Administración y Estilos</h3>

                            <!-- Admin Email & Password -->
                            <div class="sa-modal-subsection space-y-3">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-slate-600 uppercase mb-1 tracking-wider">Correo
                                        Administrador</label>
                                    <input type="email" name="email" required x-model="editingShop.email"
                                        placeholder="admin@tienda.com"
                                        class="sa-modal-field">
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label
                                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Nueva
                                            Contraseña</label>
                                        <div class="text-[10px] text-slate-500">
                                            Contraseña actual:
                                            <code class="sa-temp-password">
                                                <span
                                                    x-text="showPassword ? (editingShop.temp_password || 'Sin registrar') : '••••••'"></span>
                                                <button type="button" @click="showPassword = !showPassword"
                                                    class="focus:outline-none hover:text-purple-900 text-purple-600 ml-0.5"
                                                    aria-label="Mostrar contraseña temporal">
                                                    <i class="fas text-[9px]"
                                                        :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                                </button>
                                            </code>
                                        </div>
                                    </div>
                                    <input :type="showPassword ? 'text' : 'password'" name="password"
                                        placeholder="Dejar en blanco para mantener la misma..."
                                        class="sa-modal-field">
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
                                            class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center shrink-0">
                                            <img :src="editingShop.logo_path && editingShop.logo_path.startsWith('http') ?
                                                editingShop.logo_path : '/storage/' + editingShop.logo_path"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <input type="file" name="logo" accept="image/*" class="sa-modal-file w-full">
                                    <input type="text" name="logo_url" x-model="editingShop.logo_path"
                                        placeholder="URL opcional..."
                                        class="sa-modal-field text-sm mt-1">
                                </div>

                                <!-- Cover -->
                                <div>
                                    <div class="flex items-center gap-1.5 mb-1 justify-between">
                                        <label
                                            class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Portada</label>
                                        <!-- Thumbnail -->
                                        <div x-show="editingShop.cover_path"
                                            class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center shrink-0">
                                            <img :src="editingShop.cover_path && editingShop.cover_path.startsWith('http') ?
                                                editingShop.cover_path : '/storage/' + editingShop.cover_path"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <input type="file" name="cover" accept="image/*" class="sa-modal-file w-full">
                                    <input type="text" name="cover_url" x-model="editingShop.cover_path"
                                        placeholder="URL opcional..."
                                        class="sa-modal-field text-sm mt-1">
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
            const table = $('#shops-table');
            if (!table.length || table.find('tbody tr td[colspan]').length) {
                return;
            }

            table.DataTable({
                dom: '<"sa-dt-toolbar"lf>rt<"sa-dt-footer"ip>',
                language: {
                    search: '',
                    searchPlaceholder: 'Buscar por nombre, email o slug…',
                    lengthMenu: 'Mostrar _MENU_',
                    info: 'Mostrando _START_–_END_ de _TOTAL_',
                    infoEmpty: 'Sin resultados',
                    infoFiltered: '(filtrado de _MAX_)',
                    zeroRecords: 'No hay coincidencias',
                    emptyTable: 'No hay empresas registradas',
                    paginate: { previous: '‹', next: '›' },
                },
                columnDefs: [
                    { orderable: false, targets: [3, 7] },
                    { className: 'sa-table__td--actions', targets: 7 },
                ],
                pageLength: 10,
                order: [[0, 'asc']],
                autoWidth: false,
                scrollX: false,
            });
        });
    </script>

@endpush
