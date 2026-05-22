<!-- MOBILE NAVIGATION TAB BAR -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-gradient-to-r from-primary to-primary/95 text-white border-t border-white/10 flex justify-around items-center z-40 max-w-md mx-auto shadow-2xl transition-all duration-300">
    <div class="flex justify-around items-center w-full px-2">
        <a href="/{{ config('current_shop')->slug }}/admin/dashboard" 
           class="flex flex-col items-center justify-center py-1 px-3 rounded-xl transition {{ request()->is('*/admin/dashboard') ? 'text-white font-black active:scale-95 bg-white/15 shadow-sm' : 'text-white/60 hover:text-white' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span class="text-[9px] mt-0.5 tracking-wider font-semibold">Inicio</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/categories" 
           class="flex flex-col items-center justify-center py-1 px-3 rounded-xl transition {{ request()->is('*/admin/categories*') ? 'text-white font-black active:scale-95 bg-white/15 shadow-sm' : 'text-white/60 hover:text-white' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
            <span class="text-[9px] mt-0.5 tracking-wider font-semibold">Categorías</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/products" 
           class="flex flex-col items-center justify-center py-1 px-3 rounded-xl transition {{ request()->is('*/admin/products*') ? 'text-white font-black active:scale-95 bg-white/15 shadow-sm' : 'text-white/60 hover:text-white' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            <span class="text-[9px] mt-0.5 tracking-wider font-semibold">Productos</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/orders" 
           class="flex flex-col items-center justify-center py-1 px-3 rounded-xl transition {{ request()->is('*/admin/orders*') ? 'text-white font-black active:scale-95 bg-white/15 shadow-sm' : 'text-white/60 hover:text-white' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span class="text-[9px] mt-0.5 tracking-wider font-semibold">Órdenes</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/announcements" 
           class="flex flex-col items-center justify-center py-1 px-3 rounded-xl transition {{ request()->is('*/admin/announcements*') ? 'text-white font-black active:scale-95 bg-white/15 shadow-sm' : 'text-white/60 hover:text-white' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
            <span class="text-[9px] mt-0.5 tracking-wider font-semibold">Anuncios</span>
        </a>
        <a href="/{{ config('current_shop')->slug }}/admin/settings" 
           class="flex flex-col items-center justify-center py-1 px-3 rounded-xl transition {{ request()->is('*/admin/settings') ? 'text-white font-black active:scale-95 bg-white/15 shadow-sm' : 'text-white/60 hover:text-white' }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path><line x1="12" y1="2" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22"></line><line x1="2" y1="12" x2="4" y2="12"></line><line x1="20" y1="12" x2="22" y2="12"></line></svg>
            <span class="text-[9px] mt-0.5 tracking-wider font-semibold">Config.</span>
        </a>
    </div>
</nav>
