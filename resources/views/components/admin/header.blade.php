<!-- TOP HEADER -->
<header class="bg-gradient-to-r from-primary to-primary/95 text-white shadow-md border-b border-white/10 px-4 md:px-8 py-4 sticky top-0 z-30 transition-all duration-300">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div>
                <span class="text-[10px] uppercase font-extrabold tracking-widest text-white/60">Panel Administrativo</span>
                <h1 class="text-lg md:text-2xl font-black text-white tracking-tight leading-none mt-0.5">
                    {{ config('current_shop')->name ?? 'Mi Tienda' }}
                </h1>
            </div>
        </div>
        
        <div class="flex items-center gap-3 md:gap-5">
            <!-- Buscador -->
            <div class="hidden md:flex relative group"
                 x-data="{ 
                     searchQuery: '', 
                     results: { categories: [], products: [], orders: [], clients: [] }, 
                     isOpen: false,
                     isLoading: false,
                     async search() {
                         if (this.searchQuery.trim().length < 2) {
                             this.results = { categories: [], products: [], orders: [], clients: [] };
                             this.isOpen = false;
                             return;
                         }
                         this.isLoading = true;
                         try {
                             let res = await fetch(`/{{ config('current_shop')->slug }}/admin/search?query=` + encodeURIComponent(this.searchQuery));
                             let data = await res.json();
                             if (data.success) {
                                 this.results = data.data;
                                 this.isOpen = true;
                             }
                         } catch(e) {
                             console.error(e);
                         } finally {
                             this.isLoading = false;
                         }
                     },
                     clearSearch() {
                         this.searchQuery = '';
                         this.results = { categories: [], products: [], orders: [], clients: [] };
                         this.isOpen = false;
                     },
                     hasResults() {
                         return (this.results.categories && this.results.categories.length > 0) || 
                                (this.results.products && this.results.products.length > 0) || 
                                (this.results.orders && this.results.orders.length > 0) || 
                                (this.results.clients && this.results.clients.length > 0);
                     },
                     handleSelect(type, item) {
                         const currentPath = window.location.pathname;
                         const shopSlug = '{{ config('current_shop')->slug }}';
                         
                         if (type === 'category') {
                             if (currentPath.includes('/admin/categories')) {
                                 this.clearSearch();
                                 editCategory(item.id, item.name, item.status);
                             } else {
                                 window.location.href = `/${shopSlug}/admin/categories?edit_id=${item.id}`;
                             }
                         } else if (type === 'product') {
                             if (currentPath.includes('/admin/products')) {
                                 this.clearSearch();
                                 editProduct(item.id, item.name, item.category_id, item.price, item.description || '', item.is_available, item.image_path || '', encodeURIComponent(JSON.stringify(item.features || null)));
                             } else {
                                 window.location.href = `/${shopSlug}/admin/products?edit_id=${item.id}`;
                             }
                         } else if (type === 'client') {
                             if (currentPath.includes('/admin/clients')) {
                                 this.clearSearch();
                                 editClient(item.id, item.name, item.phone, item.email || '', item.status);
                             } else {
                                 window.location.href = `/${shopSlug}/admin/clients?edit_id=${item.id}`;
                             }
                         } else if (type === 'order') {
                             if (currentPath.includes('/admin/orders')) {
                                 this.clearSearch();
                                 editOrder(item.id, item.client_id || '', item.customer_name, item.customer_phone, item.total, item.status, item.payment_method, item.payment_status);
                             } else {
                                 window.location.href = `/${shopSlug}/admin/orders?edit_id=${item.id}`;
                             }
                         }
                     }
                 }"
                 @click.away="isOpen = false">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-white/60 group-focus-within:text-white transition-colors"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <input type="text" 
                       x-model="searchQuery" 
                       @input.debounce.300ms="search()" 
                       @focus="if (hasResults()) isOpen = true"
                       class="w-80 bg-white/10 border border-white/10 text-white text-xs font-semibold rounded-full pl-9 pr-8 py-2 focus:outline-none focus:bg-white/20 focus:border-white/30 focus:ring-1 focus:ring-white/30 shadow-inner transition-all placeholder-white/60" 
                       placeholder="Buscar categorías, productos, órdenes...">
                
                <!-- Clear button / Loader -->
                <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                    <template x-if="isLoading">
                        <svg class="animate-spin h-3.5 w-3.5 text-white/70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <template x-if="searchQuery && !isLoading">
                        <button @click="clearSearch()" class="text-white/60 hover:text-white transition-colors cursor-pointer">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </template>
                </div>

                <!-- Dropdown de resultados -->
                <div x-show="isOpen && searchQuery.trim().length >= 2" 
                     x-cloak 
                     x-transition.opacity.duration.200ms
                     class="absolute top-full left-0 right-0 mt-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] rounded-2xl overflow-hidden z-[100] max-h-96 overflow-y-auto text-slate-800 dark:text-slate-200">
                    
                    <!-- Categorías -->
                    <template x-if="results.categories && results.categories.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Categorías</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="results.categories.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in results.categories" :key="'cat-'+item.id">
                                    <button @click="handleSelect('category', item)" 
                                            class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary transition-colors" x-text="item.name"></p>
                                                <p class="text-[9px] font-mono text-slate-400" x-text="item.slug"></p>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">Editar →</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Productos -->
                    <template x-if="results.products && results.products.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Productos</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="results.products.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in results.products" :key="'prod-'+item.id">
                                    <button @click="handleSelect('product', item)" 
                                            class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <template x-if="item.image_path">
                                                <img :src="item.image_path.startsWith('http') ? item.image_path : '/storage/' + item.image_path" class="w-7 h-7 rounded-lg object-cover border border-slate-100 dark:border-slate-800">
                                            </template>
                                            <template x-if="!item.image_path">
                                                <div class="w-7 h-7 rounded-lg bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                                </div>
                                            </template>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary transition-colors" x-text="item.name"></p>
                                                <p class="text-[9px] font-bold text-slate-400" x-text="'$' + parseFloat(item.price).toFixed(2)"></p>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">Editar →</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Órdenes -->
                    <template x-if="results.orders && results.orders.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Órdenes</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="results.orders.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in results.orders" :key="'ord-'+item.id">
                                    <button @click="handleSelect('order', item)" 
                                            class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary transition-colors" x-text="'Orden #' + item.id"></p>
                                                <p class="text-[9px] font-bold text-slate-400" x-text="item.customer_name + ' | $' + parseFloat(item.total).toFixed(2)"></p>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">Editar →</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Clientes -->
                    <template x-if="results.clients && results.clients.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Clientes</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="results.clients.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in results.clients" :key="'cli-'+item.id">
                                    <button @click="handleSelect('client', item)" 
                                            class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-700 dark:text-slate-200 group-hover:text-primary transition-colors" x-text="item.name"></p>
                                                <p class="text-[9px] font-bold text-slate-400" x-text="item.phone + (item.email ? ' | ' + item.email : '')"></p>
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">Editar →</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- No Results -->
                    <template x-if="!hasResults()">
                        <div class="p-6 text-center text-xs text-slate-400 font-bold bg-white dark:bg-slate-900 transition-colors duration-300">
                            No se encontraron resultados
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Botón Dark/Light Mode -->
            <button @click="darkMode = !darkMode" class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-colors cursor-pointer hidden md:block" title="Alternar tema">
                <!-- Icono Luna (Visible en Light Mode) -->
                <svg x-show="!darkMode" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
                <!-- Icono Sol (Visible en Dark Mode) -->
                <svg x-show="darkMode" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5"></circle>
                    <line x1="12" y1="1" x2="12" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="23"></line>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                    <line x1="1" y1="12" x2="3" y2="12"></line>
                    <line x1="21" y1="12" x2="23" y2="12"></line>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                </svg>
            </button>

            <!-- Botón Compartir Catálogo (QR) -->
            <button @click="$dispatch('open-qr-modal')" 
                    class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-colors cursor-pointer hidden md:block" 
                    title="Compartir catálogo">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="5" height="5" x="3" y="3" rx="1"/>
                    <rect width="5" height="5" x="16" y="3" rx="1"/>
                    <rect width="5" height="5" x="3" y="16" rx="1"/>
                    <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                    <path d="M21 21v.01"/>
                    <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                    <path d="M3 12h.01"/>
                    <path d="M12 3h.01"/>
                    <path d="M12 16v.01"/>
                    <path d="M16 12h1"/>
                    <path d="M21 12v.01"/>
                    <path d="M12 21h.01"/>
                </svg>
            </button>

            <!-- Botón Tutoriales -->
            <a href="/{{ config('current_shop')->slug }}/admin/tutorials" 
               class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-colors cursor-pointer hidden md:block" 
               title="Tutoriales del sistema">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                </svg>
            </a>

            <!-- Campana de Notificaciones -->
            <div x-data="{ notifOpen: false }" class="relative z-50">
                <button @click="notifOpen = !notifOpen; if(notifOpen) { $nextTick(() => { $dispatch('notif-dropdown-opened'); }); }" @click.away="notifOpen = false" class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-colors cursor-pointer hidden md:block">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <span x-cloak x-show="unreadCount > 0" class="absolute top-0 right-0 w-[18px] h-[18px] bg-rose-500 rounded-full border-2 border-primary flex items-center justify-center text-[8px] font-black text-white shadow-sm" x-text="unreadCount > 99 ? '+99' : unreadCount"></span>
                </button>

                <!-- Mini Modal de Notificaciones -->
                <div x-show="notifOpen" x-cloak x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden origin-top-right">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-sm font-black text-slate-800 dark:text-slate-200">Notificaciones</span>
                        <span class="text-[10px] bg-rose-100 text-rose-600 font-bold px-2 py-0.5 rounded-full" x-text="unreadCount > 99 ? '+99 Nuevas' : unreadCount + ' Nuevas'">Nuevas</span>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <template x-for="notif in notifications.slice(0, 5)" :key="notif.id">
                            <div @click="markAsRead(notif)" class="p-4 border-b border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer flex gap-3" :class="{'opacity-70 bg-slate-50/20 dark:bg-slate-800/10': notif.is_read}">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                                     :class="notif.type === 'new_order' ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400'">
                                    <template x-if="notif.type === 'new_order'">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </template>
                                    <template x-if="notif.type !== 'new_order'">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    </template>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate" x-text="notif.title" :class="{'font-black': !notif.is_read}"></p>
                                    <p class="text-[10px] text-slate-500 mt-0.5 truncate" x-text="notif.content"></p>
                                    <span class="text-[9px] font-bold text-primary mt-1 block" x-text="formatTime(notif.created_at)"></span>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="notifications.length === 0">
                            <div class="p-6 text-center text-xs text-slate-400 font-semibold">
                                No tienes notificaciones
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="showAllNotifs = true; notifOpen = false" class="block w-full text-center p-3 text-xs font-bold text-primary bg-slate-50 dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors border-t border-slate-100 dark:border-slate-800">
                        Ver todas las notificaciones
                    </button>
                </div>
            </div>
            
            <div class="hidden md:block w-px h-6 bg-white/20"></div>

            <!-- Perfil Dropdown -->
            <div x-data="{ open: false }" class="relative z-50">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 hover:bg-white/10 p-1 md:pr-3 rounded-full border border-transparent hover:border-white/10 transition-all cursor-pointer">
                    @if(config('current_shop') && config('current_shop')->logo_path)
                        <img src="{{ filter_var(config('current_shop')->logo_path, FILTER_VALIDATE_URL) ? config('current_shop')->logo_path : asset('storage/' . config('current_shop')->logo_path) }}" alt="Logo" class="w-8 h-8 md:w-9 md:h-9 rounded-full object-cover shadow-sm border border-slate-100 dark:border-slate-800">
                    @else
                        <div class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-[#00529b] flex items-center justify-center text-white font-black text-sm shadow-sm">
                            A
                        </div>
                    @endif
                    <span class="text-sm font-bold text-white hidden md:inline">
                         {{ config('current_shop')->name ?? 'Admin' }}
                     </span>
                     <svg class="w-4 h-4 text-white/70 hidden md:inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>

                <!-- Menú Desplegable -->
                <div x-show="open" x-cloak x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden origin-top-right">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                        <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Mi Cuenta</span>
                        <span class="block text-sm font-black text-slate-800 dark:text-slate-200 mt-0.5">Administrador</span>
                    </div>
                    <a href="/{{ config('current_shop')->slug }}" target="_blank" class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-colors flex items-center gap-2.5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        <span>Ver Menú Digital</span>
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/subscription" class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-colors flex items-center gap-2.5 border-t border-slate-100 dark:border-slate-800/80">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="16" rx="2"></rect><line x1="16" y1="2" x2="16" y2="4"></line><line x1="8" y1="2" x2="8" y2="4"></line><line x1="3" y1="8" x2="21" y2="8"></line></svg>
                        <span>Mi Suscripción</span>
                    </a>
                    <a href="{{ route('logout') }}" class="px-4 py-3.5 text-xs font-bold text-[#d83434] hover:bg-rose-50 dark:hover:bg-slate-800 border-t border-slate-100 dark:border-slate-800 transition-colors flex items-center gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
