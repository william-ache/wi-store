<!-- MODAL DE CREACIÓN / EDICIÓN -->
<template x-teleport="body">
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div x-show="showModal" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
        
        <!-- Contenedor del Modal -->
        <form id="announcementForm" @submit.prevent="submitForm($data)"
          x-show="showModal" 
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          class="relative ui-card rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">
        
        <!-- Encabezado -->
        <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
            <div>
                <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Campaña' : 'Nueva Campaña'">Nueva Campaña</span>
                <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Anuncio' : 'Registrar Anuncio'">Registrar Anuncio</h3>
            </div>
            <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Formulario -->
        <div class="p-6 space-y-4 overflow-y-auto flex-grow">
            <!-- Título -->
            <div>
                <label for="title" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Título del Anuncio</label>
                <input type="text" id="title" x-model="announcementTitle" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: ¡50% de Descuento en Tortas! 🎂">
                <p x-show="errors.title" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.title"></p>
            </div>

            <!-- Contenido -->
            <div>
                <label for="content" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Mensaje o Contenido del Anuncio</label>
                <textarea id="content" x-model="announcementContent" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition resize-none" placeholder="Describe los detalles de tu promoción aquí..."></textarea>
                <p x-show="errors.content" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.content"></p>
            </div>

            <!-- Imagen Destacada -->
            <div>
                <label class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Imagen del Anuncio (Opcional - Recomendado)</label>
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div class="relative w-full md:w-32 h-32 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-800 shrink-0">
                        <template x-if="announcementImagePreview">
                            <img :src="announcementImagePreview" alt="Previsualización" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!announcementImagePreview">
                            <span class="text-[10px] text-slate-400 font-extrabold uppercase text-center p-2">Sin Imagen</span>
                        </template>
                    </div>
                    <div class="flex-grow w-full">
                        <input type="file" id="image" accept="image/*" @change="handleImageChange" class="hidden">
                        <label for="image" class="w-full ui-inset hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 font-extrabold text-[11px] uppercase tracking-wider px-5 py-3 rounded-xl cursor-pointer flex items-center justify-center gap-2 border-dashed transition active:scale-98">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            Cargar Imagen
                        </label>
                        <p class="text-[9px] text-slate-400 mt-1.5 leading-relaxed font-semibold">Carga una foto llamativa para destacar tu anuncio. Tamaño ideal: 800x600px. Máximo 2MB.</p>
                    </div>
                </div>
            </div>

            <!-- Configuración Botón CTA -->
            <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 space-y-4">
                <span class="block text-[10px] font-black text-primary uppercase tracking-widest">Botón de Acción / CTA (Opcional)</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="button_text" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Texto del Botón</label>
                        <input type="text" id="button_text" x-model="announcementButtonText" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: ¡Ver Oferta!">
                        <p x-show="errors.button_text" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.button_text"></p>
                    </div>
                    <div>
                        <label for="button_link" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Enlace del Botón</label>
                        <input type="text" id="button_link" x-model="announcementButtonLink" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: https://tutienda.com/producto">
                        <p x-show="errors.button_link" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.button_link"></p>
                    </div>
                </div>
            </div>

            <!-- Fecha Límite y Estado -->
            <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="expires_at" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Fecha Límite (Expiración)</label>
                    <input type="date" id="expires_at" x-model="announcementExpiresAt" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-primary transition">
                    <p class="text-[9px] text-slate-400 mt-1 font-semibold">El anuncio dejará de mostrarse automáticamente después de esta fecha.</p>
                    <p x-show="errors.expires_at" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.expires_at"></p>
                </div>
                <div>
                    <label for="is_active" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado</label>
                    <select id="is_active" x-model="announcementIsActive" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                        <option value="1">Activo / Visible</option>
                        <option value="0">Inactivo / Oculto</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
            <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95 cursor-pointer">
                Cancelar
            </button>
            <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2 cursor-pointer">
                <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Anuncio'">Crear Anuncio</span>
            </button>
        </div>
        </form>
    </div>
</template>
