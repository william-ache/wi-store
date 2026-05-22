<!-- MODAL DE CREACIÓN / EDICIÓN -->
<template x-teleport="body">
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div x-show="showModal" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
        
        <!-- Contenedor del Modal -->
        <form id="categoryForm" @submit.prevent="submitForm($data)"
          x-show="showModal" 
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden flex flex-col transition-colors duration-300">
        
        <!-- Encabezado (Header Sticky con color primario) -->
        <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
            <div>
                <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Registro' : 'Nuevo Registro'">Nuevo Registro</span>
                <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Categoría' : 'Registrar Categoría'">Registrar Categoría</h3>
            </div>
            <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Formulario (Scrollable Body) -->
        <div class="p-6 space-y-4 overflow-y-auto flex-grow">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre de la Categoría</label>
                <input type="text" id="name" x-model="categoryName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Globos y Detalles">
                <p x-show="errors.name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.name"></p>
            </div>

            <!-- Icono -->
            <div>
                <label for="icon" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Icono (FontAwesome)</label>
                <div class="flex gap-2">
                    <div class="relative flex-grow">
                        <input type="text" id="icon" x-model="categoryIcon" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: fa-fire, fa-star, fa-glass-water">
                    </div>
                    <div class="w-12 h-12 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 bg-slate-50 dark:bg-slate-800 shrink-0 shadow-sm">
                        <i class="fas text-lg" :class="categoryIcon || 'fa-folder'" :style="'color: ' + categoryColor"></i>
                    </div>
                </div>
                <p class="text-[9px] text-slate-400 mt-1 font-semibold">Ingresa una clase de FontAwesome 6 o usa los pre-selectores rápidos a continuación.</p>
                
                <!-- Pre-selectores Rápidos -->
                <div class="mt-2 flex flex-wrap gap-1.5">
                    <button type="button" @click="categoryIcon = 'fa-fire'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-fire text-amber-500"></i> Clásico
                    </button>
                    <button type="button" @click="categoryIcon = 'fa-star'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-star text-yellow-500"></i> Estrella
                    </button>
                    <button type="button" @click="categoryIcon = 'fa-glass-water'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-glass-water text-blue-500"></i> Bebida
                    </button>
                    <button type="button" @click="categoryIcon = 'fa-candy-cane'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-candy-cane text-pink-500"></i> Dulce
                    </button>
                    <button type="button" @click="categoryIcon = 'fa-basket-shopping'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-basket-shopping text-indigo-500"></i> Conveniencia
                    </button>
                    <button type="button" @click="categoryIcon = 'fa-hamburger'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-hamburger text-amber-600"></i> Hamburguesa
                    </button>
                    <button type="button" @click="categoryIcon = 'fa-pizza-slice'" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-[10px] font-bold text-slate-600 dark:text-slate-300 transition flex items-center gap-1">
                        <i class="fas fa-pizza-slice text-red-500"></i> Pizza
                    </button>
                </div>
            </div>

            <!-- Color -->
            <div>
                <label for="color" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Color de la Categoría</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="color" x-model="categoryColor" class="w-12 h-12 cursor-pointer bg-transparent border-0 outline-none rounded-xl shrink-0">
                    <input type="text" x-model="categoryColor" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="#E60067">
                </div>
                <p class="text-[9px] text-slate-400 mt-1 font-semibold">Selecciona un color para teñir la tarjeta y sus badges distintivos.</p>
            </div>

            <!-- Estado -->
            <div>
                <label for="status" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado</label>
                <select id="status" x-model="categoryStatus" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                    <option value="1">Activa</option>
                    <option value="0">Inactiva</option>
                </select>
            </div>
        </div>

        <!-- Botones de Acción (Footer Sticky con color primario) -->
        <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
            <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                Cancelar
            </button>
            <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Categoría'">Crear Categoría</span>
            </button>
        </div>
        </form>
    </div>
</template>
