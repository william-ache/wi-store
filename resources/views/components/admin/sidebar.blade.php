<!-- SIDEBAR DE ESCRITORIO (Fijo a la izquierda, oculto en móvil) -->
<aside class="hidden md:flex md:w-64 bg-slate-900 text-slate-300 flex-col justify-between border-r border-slate-800 shrink-0 sticky top-0 h-screen">
    <div>
        <!-- Brand Logo Header -->
        <div class="h-16 px-6 border-b border-slate-800/80 flex items-center justify-between">
            <span class="text-xl font-black text-white">WI<span class="text-primary">Store</span></span>
            <span class="bg-primary/10 text-primary text-[9px] uppercase font-bold px-2 py-0.5 rounded-full border border-primary/20">Admin</span>
        </div>

        <!-- Navlinks -->
        <nav class="p-4 space-y-1.5">
            <a href="/{{ config('current_shop')->slug }}/admin/dashboard" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/dashboard') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Inicio</span>
            </a>
            @if(in_array('categories', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'announcements']))
            <a href="/{{ config('current_shop')->slug }}/admin/categories" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/categories*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                <span>Categorías</span>
            </a>
            @endif
            @if(in_array('products', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'announcements']))
            <a href="/{{ config('current_shop')->slug }}/admin/products" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/products*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <span>Productos</span>
            </a>
            @endif
            @if(in_array('orders', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'announcements']))
            <a href="/{{ config('current_shop')->slug }}/admin/orders" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/orders*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <span>Órdenes</span>
            </a>
            @endif
            @if(in_array('clients', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'announcements']))
            <a href="/{{ config('current_shop')->slug }}/admin/clients" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/clients*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>Clientes</span>
            </a>
            @endif
            @if(in_array('announcements', $currentShop->enabled_modules ?? ['categories', 'products', 'orders', 'clients', 'announcements']))
            <a href="/{{ config('current_shop')->slug }}/admin/announcements" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/announcements*') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                <span>Anuncios</span>
            </a>
            @endif
            <a href="/{{ config('current_shop')->slug }}/admin/settings" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium {{ request()->is('*/admin/settings') ? 'bg-slate-800 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
                <span>Configuración</span>
            </a>
        </nav>
    </div>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-slate-800/60 space-y-2">
        <a href="/{{ config('current_shop')->slug }}" target="_blank" class="w-full bg-slate-800 hover:bg-primary hover:text-white text-slate-300 font-bold py-2.5 rounded-xl border border-slate-700/80 hover:border-primary transition text-xs flex items-center justify-center gap-2">
            Ver Menú Digital →
        </a>
        <a href="/" class="w-full bg-rose-600/10 hover:bg-rose-600 hover:text-white text-rose-400 font-bold py-2 rounded-xl border border-rose-500/20 hover:border-rose-600 transition text-[11px] flex items-center justify-center gap-1.5">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Volver a WIStore
        </a>
    </div>
</aside>
