<!-- MODAL TODAS LAS NOTIFICACIONES -->
<div x-show="showAllNotifs" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div x-show="showAllNotifs" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showAllNotifs = false"></div>
    <div x-show="showAllNotifs" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative ui-card rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[85vh] transition-colors duration-300">
        
        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between bg-primary text-white sticky top-0 z-10 transition-colors duration-300 shadow-md">
            <div class="flex items-center gap-3">
                <h3 class="text-base md:text-lg font-black text-white">Todas las Notificaciones</h3>
                <span class="bg-white/20 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full" x-text="unreadCount > 99 ? '+99 Nuevas' : unreadCount + ' Nuevas'">2 Nuevas</span>
            </div>
            <button @click="showAllNotifs = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        
        <!-- Modal Body (Scrollable list) -->
        <div class="overflow-y-auto flex-grow p-4 space-y-3">
            <template x-for="notif in notifications" :key="notif.id">
                <div class="p-4 rounded-2xl border border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition flex gap-4 items-start relative group" :class="notif.is_read ? 'opacity-70' : 'bg-slate-50/30 dark:bg-slate-800/20'">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                         :class="notif.type === 'new_order' ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400'">
                        <template x-if="notif.type === 'new_order'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </template>
                        <template x-if="notif.type !== 'new_order'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </template>
                    </div>
                    <div class="flex-grow pr-8 cursor-pointer" @click="markAsRead(notif)">
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200" x-text="notif.title" :class="{'font-black': !notif.is_read}"></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed" x-text="notif.content"></p>
                        <span class="text-[10px] font-bold text-primary mt-2 block" x-text="formatTime(notif.created_at)"></span>
                    </div>
                    
                    <!-- Delete single notification button -->
                    <button @click.stop="deleteNotification(notif.id)" class="absolute right-4 top-4 w-7 h-7 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-rose-100 text-slate-400 hover:text-rose-600 dark:bg-slate-800 dark:hover:bg-rose-950/50 dark:hover:text-rose-400 transition-all opacity-0 group-hover:opacity-100 md:opacity-100 duration-200" title="Eliminar notificación">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </div>
            </template>
            
            <template x-if="notifications.length === 0">
                <div class="py-12 text-center">
                    <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <p class="text-sm font-bold text-slate-400 dark:text-slate-600">No tienes notificaciones en tu bandeja</p>
                </div>
            </template>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-primary flex justify-between items-center sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
            <button x-show="notifications.length > 0" @click="clearAllNotifications()" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm active:scale-95 flex items-center gap-1.5 border border-white/20">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                <span>Limpiar Bandeja</span>
            </button>
            <button @click="showAllNotifs = false" class="bg-white hover:bg-white/95 text-primary font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm active:scale-95 ml-auto">
                Cerrar
            </button>
        </div>
    </div>
</div>
