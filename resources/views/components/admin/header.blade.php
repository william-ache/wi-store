<!-- TOP HEADER -->
<header class="admin-topbar accent-surface px-3 md:px-8 py-2.5 md:py-3 z-40 w-full">
    <div class="admin-topbar-inner">
        <div class="admin-topbar-brand">
            <button
                type="button"
                class="md:hidden accent-icon-btn p-2 rounded-full shrink-0 -ml-0.5"
                @click="toggleSidebar()"
                :aria-expanded="sidebarOpen"
                aria-label="Abrir menú de navegación"
            >
                <svg x-show="!sidebarOpen" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <svg x-show="sidebarOpen" x-cloak width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="min-w-0 flex-1">
                <span class="hidden md:block text-[10px] uppercase font-extrabold tracking-widest accent-muted leading-none">Panel Administrativo</span>
                <h1 class="text-base sm:text-lg md:text-xl font-black tracking-tight leading-tight mt-0 md:mt-0.5 truncate">
                    {{ config('current_shop')->name ?? 'Mi Tienda' }}
                </h1>
            </div>
        </div>

        <div class="admin-topbar-actions">
            <!-- Buscador móvil: solo lupa -->
            <button
                type="button"
                class="md:hidden accent-icon-btn p-2 rounded-full shrink-0"
                @click="openSearchModal()"
                aria-label="Buscar"
            >
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>

            <!-- Buscador escritorio -->
            <div class="hidden md:flex relative group" @click.away="searchPanelOpen = false">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-slate-400 group-focus-within:text-slate-500 transition-colors"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <input type="text"
                       x-model="searchQuery"
                       @input.debounce.300ms="runSearch()"
                       @focus="if (hasSearchResults()) searchPanelOpen = true"
                       class="w-80 text-xs font-semibold rounded-full pl-9 pr-8 py-2 shadow-inner transition-all bg-white/95 text-slate-800 placeholder-slate-400 border border-white/60 focus:bg-white focus:border-white/80 focus:outline-none"
                       placeholder="Buscar categorías, productos, órdenes...">
                <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                    <template x-if="searchLoading">
                        <svg class="animate-spin h-3.5 w-3.5 accent-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <template x-if="searchQuery && !searchLoading">
                        <button type="button" @click="clearSearch()" class="accent-muted hover:opacity-100 transition-opacity cursor-pointer">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </template>
                </div>
                <div x-show="searchPanelOpen && searchQuery.trim().length >= 2"
                     x-cloak
                     x-transition.opacity.duration.200ms
                     class="absolute top-full left-0 right-0 mt-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] rounded-2xl overflow-hidden z-[100] max-h-96 overflow-y-auto text-slate-800 dark:text-slate-200">
                    <!-- Categorías -->
                    <template x-if="searchResults.categories && searchResults.categories.length > 0">
                        <div>
                            <div class="px-4 py-2 ui-inset border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Categorías</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="searchResults.categories.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in searchResults.categories" :key="'cat-'+item.id">
                                    <button @click="handleSearchSelect('category', item)"
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
                    <template x-if="searchResults.products && searchResults.products.length > 0">
                        <div>
                            <div class="px-4 py-2 ui-inset border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Productos</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="searchResults.products.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in searchResults.products" :key="'prod-'+item.id">
                                    <button @click="handleSearchSelect('product', item)"
                                            class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-2">
                                            <template x-if="item.image_path">
                                                <img :src="item.image_path.startsWith('http') ? item.image_path : '/storage/' + item.image_path" class="w-7 h-7 rounded-lg object-cover border border-slate-100 dark:border-slate-800" alt="">
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
                    <template x-if="searchResults.orders && searchResults.orders.length > 0">
                        <div>
                            <div class="px-4 py-2 ui-inset border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Órdenes</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="searchResults.orders.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in searchResults.orders" :key="'ord-'+item.id">
                                    <button @click="handleSearchSelect('order', item)"
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
                    <template x-if="searchResults.clients && searchResults.clients.length > 0">
                        <div>
                            <div class="px-4 py-2 ui-inset border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                                <span class="text-[9px] uppercase font-black tracking-widest text-primary">Clientes</span>
                                <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="searchResults.clients.length"></span>
                            </div>
                            <div class="p-1.5 space-y-0.5">
                                <template x-for="item in searchResults.clients" :key="'cli-'+item.id">
                                    <button @click="handleSearchSelect('client', item)"
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

                    <template x-if="searchQuery.trim().length >= 2 && !hasSearchResults() && !searchLoading">
                        <div class="p-6 text-center text-xs text-slate-400 font-bold ui-surface transition-colors duration-300">
                            No se encontraron resultados
                        </div>
                    </template>
                </div>
            </div>

            <!-- Acciones escritorio -->
            <button type="button" @click="showDarkModeComingSoon()" class="accent-icon-btn relative p-2 rounded-full transition-colors cursor-pointer hidden md:block" title="Modo oscuro">
                <svg x-show="!darkMode" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
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

            <button type="button" @click="$dispatch('open-qr-modal')"
                    class="accent-icon-btn relative p-2 rounded-full transition-colors cursor-pointer hidden md:block"
                    title="Compartir catálogo">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/>
                    <path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21h.01"/>
                </svg>
            </button>

            <button type="button" @click="showTutorialsComingSoon()"
                    class="accent-icon-btn relative p-2 rounded-full transition-colors cursor-pointer hidden md:block"
                    title="Tutoriales del sistema">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                </svg>
            </button>

            <div class="relative z-50 hidden md:block">
                <button type="button" @click="notifOpen = !notifOpen; if(notifOpen) { $nextTick(() => { $dispatch('notif-dropdown-opened'); }); }" @click.away="notifOpen = false" class="accent-icon-btn relative p-2 rounded-full transition-colors cursor-pointer">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <span x-cloak x-show="unreadCount > 0" class="absolute top-0 right-0 w-[18px] h-[18px] bg-rose-500 rounded-full border-2 border-primary flex items-center justify-center text-[8px] font-black text-white shadow-sm" x-text="unreadCount > 99 ? '+99' : unreadCount"></span>
                </button>
                <div x-show="notifOpen" x-cloak x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-80 ui-surface border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden origin-top-right">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-sm font-black text-slate-800 dark:text-slate-200">Notificaciones</span>
                        <span class="text-[10px] bg-rose-100 text-rose-600 font-bold px-2 py-0.5 rounded-full" x-text="unreadCount > 99 ? '+99 Nuevas' : unreadCount + ' Nuevas'"></span>
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

            <div class="hidden md:block w-px h-6 opacity-20 bg-[var(--color-on-primary)]"></div>

            <!-- Perfil -->
            <div class="relative z-50 shrink-0" @click.away="closeProfileMenu()">
                <button type="button" @click="toggleProfileMenu()" class="flex items-center gap-2 accent-icon-btn p-1 md:pr-3 rounded-full border border-transparent hover:border-[rgba(var(--color-on-primary-rgb),0.12)] transition-all cursor-pointer">
                    <span
                        class="admin-avatar-status shrink-0 rounded-full"
                        :class="$store.connection.online ? 'admin-avatar-status--online' : 'admin-avatar-status--offline'"
                        :title="$store.connection.online ? 'Conectado a internet' : 'Sin conexión a internet'"
                    >
                        @if(config('current_shop') && config('current_shop')->logoUrl())
                            <img src="{{ config('current_shop')->logoUrl() }}" alt="" class="w-9 h-9 md:w-9 md:h-9 rounded-full object-cover block shadow-sm" loading="lazy" decoding="async">
                        @else
                            <span class="w-9 h-9 md:w-9 md:h-9 rounded-full bg-[rgba(var(--color-on-primary-rgb),0.2)] flex items-center justify-center font-black text-sm shadow-sm">A</span>
                        @endif
                    </span>
                    <span class="text-sm font-bold hidden md:inline">{{ config('current_shop')->name ?? 'Admin' }}</span>
                    <svg class="w-4 h-4 accent-muted hidden md:inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>

                <!-- Móvil: iconos rápidos + cuenta -->
                <div
                    x-show="profileMenuOpen"
                    x-cloak
                    x-transition.opacity.duration.200ms
                    class="md:hidden absolute right-0 mt-3 z-[60] w-[min(18rem,calc(100vw-1.5rem))]"
                >
                    <div class="accent-surface rounded-2xl shadow-xl border border-white/15 overflow-hidden">
                        <div class="flex items-center justify-around gap-1 px-3 py-3 border-b border-white/15">
                            <button type="button" @click="showDarkModeComingSoon()" class="accent-icon-btn p-2.5 rounded-full" title="Modo oscuro">
                                <svg x-show="!darkMode" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                <svg x-show="darkMode" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line></svg>
                            </button>
                            <button type="button" @click="closeProfileMenu(); $dispatch('open-qr-modal')" class="accent-icon-btn p-2.5 rounded-full" title="Compartir catálogo">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/></svg>
                            </button>
                            <button type="button" @click="closeProfileMenu(); showTutorialsComingSoon()" class="accent-icon-btn p-2.5 rounded-full" title="Tutoriales">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
                            </button>
                            <button type="button" @click="notifOpen = !notifOpen" class="accent-icon-btn p-2.5 rounded-full relative" title="Notificaciones">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <span x-cloak x-show="unreadCount > 0" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-rose-500 rounded-full border-2 border-primary text-[7px] font-black text-white flex items-center justify-center" x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                            </button>
                        </div>
                        <div x-show="notifOpen" x-collapse class="ui-surface border-t border-slate-100 dark:border-slate-800">
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200">Notificaciones</span>
                                <span class="text-[9px] bg-rose-100 text-rose-600 font-bold px-2 py-0.5 rounded-full" x-text="unreadCount + ' nuevas'"></span>
                            </div>
                            <div class="max-h-52 overflow-y-auto">
                                <template x-for="notif in notifications.slice(0, 5)" :key="notif.id">
                                    <div @click="markAsRead(notif)" class="p-3 border-b border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer flex gap-3" :class="{'opacity-70 bg-slate-50/20 dark:bg-slate-800/10': notif.is_read}">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
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
                                        </div>
                                    </div>
                                </template>
                                <template x-if="notifications.length === 0">
                                    <div class="p-5 text-center text-xs text-slate-400 font-semibold">No tienes notificaciones</div>
                                </template>
                            </div>
                            <button type="button" @click="showAllNotifs = true; notifOpen = false; profileMenuOpen = false" class="block w-full text-center p-3 text-xs font-bold text-primary bg-slate-50 dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors border-t border-slate-100 dark:border-slate-800">
                                Ver todas las notificaciones
                            </button>
                        </div>
                        <div class="ui-surface text-slate-800 dark:text-slate-200">
                            <a href="/{{ config('current_shop')->slug }}" target="_blank" @click="closeProfileMenu()" class="px-4 py-3 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-2.5">Ver Menú Digital</a>
                            <a href="/{{ config('current_shop')->slug }}/admin/subscription" @click="closeProfileMenu()" class="px-4 py-3 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-2.5 border-t border-slate-100 dark:border-slate-800">Mi Suscripción</a>
                            <a href="{{ route('logout') }}" class="px-4 py-3 text-xs font-bold text-[#d83434] hover:bg-rose-50 dark:hover:bg-slate-800 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2.5">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>

                <!-- Escritorio: menú cuenta -->
                <div x-show="profileMenuOpen" x-cloak x-transition.opacity.duration.200ms class="hidden md:block absolute right-0 mt-3 w-56 ui-surface border border-slate-100 dark:border-slate-800 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl overflow-hidden origin-top-right">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 ui-inset">
                        <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Mi Cuenta</span>
                        <span class="block text-sm font-black text-slate-800 dark:text-slate-200 mt-0.5">Administrador</span>
                    </div>
                    <a href="/{{ config('current_shop')->slug }}" target="_blank" class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-colors flex items-center gap-2.5">
                        <span>Ver Menú Digital</span>
                    </a>
                    <a href="/{{ config('current_shop')->slug }}/admin/subscription" class="px-4 py-3 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-colors flex items-center gap-2.5 border-t border-slate-100 dark:border-slate-800/80">
                        <span>Mi Suscripción</span>
                    </a>
                    <a href="{{ route('logout') }}" class="px-4 py-3.5 text-xs font-bold text-[#d83434] hover:bg-rose-50 dark:hover:bg-slate-800 border-t border-slate-100 dark:border-slate-800 transition-colors flex items-center gap-2.5">
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Modal buscador móvil -->
<div
    x-show="searchModalOpen"
    x-cloak
    class="md:hidden fixed inset-0 z-[70]"
    @keydown.escape.window="closeSearchModal()"
>
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeSearchModal()"></div>
    <div
        class="absolute left-3 right-3 top-[calc(env(safe-area-inset-top,0px)+4.5rem)] max-h-[calc(100dvh-6rem)] flex flex-col rounded-2xl shadow-2xl overflow-hidden ui-surface border border-slate-200 dark:border-slate-700"
        @click.stop
    >
        <div class="flex items-center gap-2 p-3 border-b border-slate-100 dark:border-slate-800 shrink-0">
            <div class="relative flex-1 min-w-0">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <input
                    id="mobile-search-input"
                    type="search"
                    x-model="searchQuery"
                    @input.debounce.300ms="runSearch()"
                    class="ui-field w-full text-sm font-semibold rounded-xl pl-9 pr-9 py-2.5"
                    placeholder="Buscar categorías, productos..."
                    autocomplete="off"
                >
                <template x-if="searchLoading">
                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </template>
            </div>
            <button type="button" @click="closeSearchModal()" class="shrink-0 p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Cerrar búsqueda">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="overflow-y-auto flex-1 min-h-0 text-slate-800 dark:text-slate-200">
            <template x-if="searchQuery.trim().length < 2">
                <p class="p-6 text-center text-xs text-slate-400 font-semibold">Escribe al menos 2 caracteres para buscar</p>
            </template>
            <div x-show="searchQuery.trim().length >= 2" class="pb-2">
                <!-- Categorías -->
                <template x-if="searchResults.categories && searchResults.categories.length > 0">
                    <div>
                        <div class="px-4 py-2 ui-inset border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                            <span class="text-[9px] uppercase font-black tracking-widest text-primary">Categorías</span>
                            <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="searchResults.categories.length"></span>
                        </div>
                        <div class="p-1.5 space-y-0.5">
                            <template x-for="item in searchResults.categories" :key="'cat-m-'+item.id">
                                <button @click="handleSearchSelect('category', item)"
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
                <template x-if="searchResults.products && searchResults.products.length > 0">
                    <div>
                        <div class="px-4 py-2 ui-inset border-b border-slate-100/50 dark:border-slate-800/50 flex items-center justify-between">
                            <span class="text-[9px] uppercase font-black tracking-widest text-primary">Productos</span>
                            <span class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold" x-text="searchResults.products.length"></span>
                        </div>
                        <div class="p-1.5 space-y-0.5">
                            <template x-for="item in searchResults.products" :key="'prod-m-'+item.id">
                                <button @click="handleSearchSelect('product', item)"
                                        class="w-full flex items-center justify-between text-left px-3 py-2 rounded-xl hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors group cursor-pointer">
                                    <div class="flex items-center gap-2">
                                        <template x-if="item.image_path">
                                            <img :src="item.image_path.startsWith('http') ? item.image_path : '/storage/' + item.image_path" class="w-7 h-7 rounded-lg object-cover border border-slate-100 dark:border-slate-800" alt="">
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

                <template x-if="searchQuery.trim().length >= 2 && !hasSearchResults() && !searchLoading">
                    <div class="p-6 text-center text-xs text-slate-400 font-bold ui-surface transition-colors duration-300">
                        No se encontraron resultados
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
