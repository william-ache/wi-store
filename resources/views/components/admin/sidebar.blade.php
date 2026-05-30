<!-- SIDEBAR (overlay en móvil, fijo en escritorio) -->
<aside
    class="admin-sidebar flex flex-col h-full min-h-0 overflow-hidden md:w-64 w-0 max-md:overflow-visible max-md:border-0 bg-slate-900 text-slate-300 border-r border-slate-800 shrink-0"
    :class="{ 'admin-sidebar--open': sidebarOpen }"
>
        <!-- Brand Logo Header -->
        <div class="h-16 px-6 border-b border-slate-800/80 flex items-center justify-between shrink-0">
            <span class="text-xl font-black text-white tracking-tight">WIStore</span>
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                    @click="closeSidebar()"
                    aria-label="Cerrar menú"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        </div>

        <!-- Navlinks -->
        <nav class="admin-sidebar-nav flex-1 min-h-0 p-3.5 pb-2 space-y-1.5 custom-scrollbar overflow-y-auto" @click="onSidebarNavClick($event)">
            <!-- Inicio -->
            <a href="/{{ config('current_shop')->slug }}/admin/dashboard" 
               class="admin-nav-link {{ request()->is('*/admin/dashboard') ? 'admin-nav-link--active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Inicio</span>
            </a>

            <!-- Analítica -->
            <a href="/{{ config('current_shop')->slug }}/admin/analytics" 
               class="admin-nav-link {{ request()->is('*/admin/analytics*') ? 'admin-nav-link--active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                <span>Analítica</span>
            </a>

            <!-- Inventario -->
            <div x-data="{ open: {{ request()->is('*/admin/products*') || request()->is('*/admin/categories*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="admin-nav-link admin-nav-link--parent w-full {{ request()->is('*/admin/products*') || request()->is('*/admin/categories*') ? 'admin-nav-link--active' : '' }} group">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-white"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Inventario</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-200" :class="open ? 'rotate-180 text-white' : 'text-slate-500 group-hover:text-slate-300'"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 mt-1 space-y-1 border-l border-slate-800 ml-5">
                    @if(in_array('products', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals']))
                    <a href="/{{ config('current_shop')->slug }}/admin/products" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/products*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Productos</span>
                    </a>
                    @endif
                    @if(in_array('categories', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals']))
                    <a href="/{{ config('current_shop')->slug }}/admin/categories" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/categories*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                        <span>Categorías</span>
                    </a>
                    @endif
                    <a href="#" onclick="Swal.fire({ title: 'Inventario 📦', text: 'El módulo de control de stock en tiempo real, almacenes y alertas de inventario bajo estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Inventario</span>
                    </a>
                </div>
            </div>

            @if (\App\Support\PlanFeatures::hasBusinessPanel($currentShop ?? config('current_shop')))
            <!-- Ventas -->
            <div x-data="{ open: {{ request()->is('*/admin/orders*') || request()->is('*/admin/bookings*') || request()->is('*/admin/abandoned-carts*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="admin-nav-link admin-nav-link--parent w-full {{ request()->is('*/admin/orders*') || request()->is('*/admin/bookings*') || request()->is('*/admin/abandoned-carts*') ? 'admin-nav-link--active' : '' }} group">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-white"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>Ventas</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-200" :class="open ? 'rotate-180 text-white' : 'text-slate-500 group-hover:text-slate-300'"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 mt-1 space-y-1 border-l border-slate-800 ml-5">
                    @if(in_array('orders', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals']))
                    <a href="/{{ config('current_shop')->slug }}/admin/orders" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/orders*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Pedidos</span>
                    </a>
                    @endif
                    <a href="/{{ config('current_shop')->slug }}/admin/bookings" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/bookings*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>Reservas</span>
                    </a>
                    <a href="#" onclick="Swal.fire({ title: 'Zonas & Delivery 🛵', text: 'El módulo de tarifas dinámicas por KM, asignación de motorizados y mapas estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Delivery</span>
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/abandoned-carts" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/abandoned-carts*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>Carritos Abandonados</span>
                    </a>
                </div>
            </div>
            @endif

            @if (\App\Support\PlanFeatures::hasBusinessPanel($currentShop ?? config('current_shop')))
            <!-- Contactos -->
            <div x-data="{ open: {{ request()->is('*/admin/clients*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="admin-nav-link admin-nav-link--parent w-full {{ request()->is('*/admin/clients*') ? 'admin-nav-link--active' : '' }} group">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-white"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Contactos</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-200" :class="open ? 'rotate-180 text-white' : 'text-slate-500 group-hover:text-slate-300'"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 mt-1 space-y-1 border-l border-slate-800 ml-5">
                    @if(in_array('clients', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals']))
                    <a href="/{{ config('current_shop')->slug }}/admin/clients" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/clients*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        <span>Clientes</span>
                    </a>
                    @endif
                    <a href="#" onclick="Swal.fire({ title: 'Proveedores 📦', text: 'El módulo de gestión de proveedores, compras y reabastecimiento de inventario estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline></svg>
                        <span>Proveedores</span>
                    </a>
                    <a href="#" onclick="Swal.fire({ title: 'Empleados 👥', text: 'El módulo de control de personal, roles, permisos y turnos de trabajo estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle></svg>
                        <span>Empleados</span>
                    </a>
                </div>
            </div>
            @endif

            @if (\App\Support\PlanFeatures::hasBusinessPanel($currentShop ?? config('current_shop')))
            <!-- Finanzas -->
            <div x-data="{ open: false }" class="space-y-1">
                <button @click="open = !open" 
                        class="admin-nav-link admin-nav-link--parent w-full group">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-white"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span>Finanzas</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-200" :class="open ? 'rotate-180 text-white' : 'text-slate-500 group-hover:text-slate-300'"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 mt-1 space-y-1 border-l border-slate-800 ml-5">
                    <a href="#" onclick="Swal.fire({ title: 'Facturas 🧾', text: 'El módulo de gestión y control de facturas estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><rect x="3" y="4" width="18" height="16" rx="2"></rect></svg>
                        <span>Facturas</span>
                    </a>
                    <a href="#" onclick="Swal.fire({ title: 'Flujo de Caja 💰', text: 'El módulo de gestión de ingresos, flujo de caja y balances financieros estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span>Flujo de Caja</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Marketing -->
            <div x-data="{ open: {{ request()->is('*/admin/announcements*') || request()->is('*/admin/coupons*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="admin-nav-link admin-nav-link--parent w-full {{ request()->is('*/admin/announcements*') || request()->is('*/admin/coupons*') ? 'admin-nav-link--active' : '' }} group">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-white"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        <span>Marketing</span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-200" :class="open ? 'rotate-180 text-white' : 'text-slate-500 group-hover:text-slate-300'"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 mt-1 space-y-1 border-l border-slate-800 ml-5">
                    @if(in_array('announcements', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'invoices', 'delivery', 'analytics', 'announcements', 'referrals']))
                    <a href="/{{ config('current_shop')->slug }}/admin/announcements" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/announcements*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        <span>Campañas</span>
                    </a>
                    @endif
                    <a href="/{{ config('current_shop')->slug }}/admin/coupons" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/coupons*') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path></svg>
                        <span>Cupones</span>
                    </a>
                    <a href="#" onclick="Swal.fire({ title: 'Sistema de Referidos 🔗', text: 'El programa de promotores de marca, recompensas y cupones compartidos de afiliados estará disponible muy pronto.', icon: 'info', confirmButtonText: '¡Entendido!', confirmButtonColor: '{{ config('current_shop')->color_primary ?? '#E60067' }}', background: '#0d1127', color: '#fff' })"
                       class="admin-nav-link admin-nav-link--sub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path></svg>
                        <span>Referidos</span>
                    </a>
                    <a href="#"
                       @click.prevent="showRateModal = true"
                       class="admin-nav-link admin-nav-link--sub"
                       :class="{ 'admin-nav-link--active': showRateModal }">
                        <i class="fas fa-star text-[13px] w-[15px] text-center shrink-0 text-amber-400"></i>
                        <span>Calificar</span>
                    </a>
                </div>
            </div>

            <!-- Sistema -->
            <div x-data="{ open: {{ request()->is('*/admin/subscription*') || request()->is('*/admin/feedback*') || request()->is('*/admin/settings*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        class="admin-nav-link admin-nav-link--parent w-full {{ request()->is('*/admin/subscription*') || request()->is('*/admin/feedback*') || request()->is('*/admin/settings*') ? 'admin-nav-link--active' : '' }} group">
                    <div class="flex items-center gap-2.5">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-white"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span class="flex items-center gap-1.5">
                            <span>Sistema</span>
                        </span>
                    </div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="transition-transform duration-200" :class="open ? 'rotate-180 text-white' : 'text-slate-500 group-hover:text-slate-300'"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="open" 
                     x-collapse 
                     class="pl-4 mt-1 space-y-1 border-l border-slate-800 ml-5">
                    <a href="/{{ config('current_shop')->slug }}/admin/subscription" 
                       class="admin-nav-link admin-nav-link--sub justify-between {{ request()->is('*/admin/subscription') ? 'admin-nav-link--active' : '' }}">
                        <div class="flex items-center gap-2">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><rect x="3" y="4" width="18" height="16" rx="2"></rect><line x1="16" y1="2" x2="16" y2="4"></line><line x1="8" y1="2" x2="8" y2="4"></line></svg>
                            <span>Suscripción</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->is('*/admin/subscription') ? 'bg-white animate-pulse' : 'bg-purple-500' }} shrink-0"></span>
                    </a>
                    <a href="#" 
                       @click.prevent="showFeedbackModal = true"
                       class="admin-nav-link admin-nav-link--sub justify-between"
                       :class="{ 'admin-nav-link--active': showFeedbackModal }">
                        <div class="flex items-center gap-2">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 shrink-0"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <span>Feedback</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 bg-purple-500" :class="{ 'bg-white animate-pulse': showFeedbackModal }"></span>
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/settings" 
                       class="admin-nav-link admin-nav-link--sub {{ request()->is('*/admin/settings') ? 'admin-nav-link--active' : '' }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-1 shrink-0"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Configuración</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Footer Sidebar (fijo al pie del panel) -->
        <div class="admin-sidebar-footer px-3.5 pt-3 pb-4 border-t border-slate-800/60 space-y-2 shrink-0 bg-slate-900">
        <a href="mailto:{{ $wiStoreSupportEmail }}" class="w-full text-slate-500 hover:text-cyan-300 font-semibold py-1.5 text-[10px] flex items-center justify-center gap-1.5 transition-colors break-all">
            <i class="fas fa-envelope opacity-70"></i>
            <span>{{ $wiStoreSupportEmail }}</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}" target="_blank" class="w-full bg-slate-800 hover:bg-primary hover:text-white text-slate-300 font-bold py-2.5 rounded-xl border border-slate-700/80 hover:border-primary transition text-xs flex items-center justify-center gap-2">
            Ver Menú Digital →
        </a>
        <a href="/" class="w-full bg-rose-600/10 hover:bg-rose-600 hover:text-white text-rose-400 font-bold py-2 rounded-xl border border-rose-500/20 hover:border-rose-600 transition text-[11px] flex items-center justify-center gap-1.5">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Volver a WI-Store
        </a>
        </div>
</aside>
