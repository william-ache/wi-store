<template x-teleport="body">
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div x-show="showModal" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
             <!-- Contenedor del Modal -->
        <form id="clientForm" @submit.prevent="submitForm($data)"
         x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative ui-card rounded-3xl shadow-2xl w-full max-w-md overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">
        
        <!-- Encabezado (Header Sticky con color primario) -->
        <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
            <div>
                <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Registro' : 'Nuevo Registro'">Nuevo Registro</span>
                <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Cliente' : 'Registrar Cliente'">Registrar Cliente</h3>
            </div>
            <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Formulario (Scrollable Body) -->
        <div class="p-6 space-y-4 overflow-y-auto flex-grow">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre Completo</label>
                <input type="text" id="name" x-model="clientName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Aníbal Peralta">
                <p x-show="errors.name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.name"></p>
            </div>

            <!-- Teléfono -->
            <div>
                <label for="phone" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Teléfono de Contacto</label>
                <input type="text" id="phone" x-model="clientPhone" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: +58 412-5551234">
                <p x-show="errors.phone" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.phone"></p>
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Correo Electrónico (Opcional)</label>
                <input type="email" id="email" x-model="clientEmail" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: comprador@correo.com">
                <p x-show="errors.email" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.email"></p>
            </div>

            <!-- Estado -->
            <div>
                <label for="status" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado</label>
                <select id="status" x-model="clientStatus" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>

        <!-- Botones de Acción (Footer Sticky con color primario) -->
        <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
            <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                Cancelar
            </button>
            <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                <span x-text="isEdit ? 'Guardar Cambios' : 'Registrar Cliente'">Registrar Cliente</span>
            </button>
        </div>
        </form>
    </div>
</template>
