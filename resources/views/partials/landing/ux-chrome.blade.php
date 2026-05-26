<!-- Barra de progreso al hacer scroll -->
<div class="fixed top-0 left-0 right-0 h-1 z-[60] bg-[#0e1228]/60 pointer-events-none">
    <div id="landing-scroll-progress"
         class="landing-scroll-progress h-full w-full bg-gradient-to-r from-purple-500 via-fuchsia-500 to-cyan-400"></div>
</div>

<!-- Menú móvil -->
<div x-show="isMobileMenuOpen" x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[55] md:hidden">
    <div class="absolute inset-0 bg-[#0e1228]/85 backdrop-blur-md" @click="isMobileMenuOpen = false"></div>
    <nav class="absolute right-0 top-0 bottom-0 w-[min(100%,320px)] bg-slate-950 border-l border-white/10 p-6 flex flex-col gap-2 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <span class="text-lg font-black text-white">Menú</span>
            <button type="button" @click="isMobileMenuOpen = false"
                    class="w-10 h-10 rounded-xl border border-white/10 text-slate-300 hover:text-white flex items-center justify-center"
                    aria-label="Cerrar menú">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <button type="button" @click="scrollTo('explorar')"
                class="text-left text-base font-bold text-slate-300 py-3 px-4 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/10 text-sm">
            <i class="fas fa-eye text-slate-500 mr-2"></i> Vista previa en landing
        </button>
        <button type="button" @click="scrollTo('como-funciona')"
                class="text-left text-base font-bold text-white py-3 px-4 rounded-xl hover:bg-white/5">
            <i class="fas fa-list-ol text-cyan-400 mr-2"></i> Cómo funciona
        </button>
        <button type="button" @click="scrollTo('precios')"
                class="text-left text-base font-bold text-white py-3 px-4 rounded-xl hover:bg-white/5">
            <i class="fas fa-tags text-pink-400 mr-2"></i> Planes y precios
        </button>
        <a href="{{ route('tiendas.index') }}"
                class="text-left text-base font-bold text-white py-3 px-4 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/10">
            <i class="fas fa-store text-purple-400 mr-2"></i> Marketplace
        </a>
        <a href="/login"
           class="text-left text-base font-bold text-slate-300 py-3 px-4 rounded-xl hover:bg-white/5">
            <i class="fas fa-sign-in-alt mr-2"></i> Iniciar sesión
        </a>
        <a href="/register"
           class="mt-4 text-center bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-black py-4 rounded-2xl shadow-lg">
            Crear mi tienda gratis
        </a>
    </nav>
</div>
