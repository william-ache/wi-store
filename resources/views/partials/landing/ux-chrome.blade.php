@php
    $landingNavExternal = $landingNavExternal ?? false;
    $hideLoginNavLink = $hideLoginNavLink ?? false;
    $landingHomeUrl = url('/');
@endphp

<!-- Barra de progreso al hacer scroll (crece desde la izquierda) -->
<div class="landing-scroll-progress-track fixed top-0 left-0 right-0 z-[60] h-1 pointer-events-none overflow-hidden" aria-hidden="true">
    <div id="landing-scroll-progress"
         class="landing-scroll-progress h-full bg-gradient-to-r from-purple-500 via-fuchsia-500 to-cyan-500"></div>
</div>

<!-- Menú móvil -->
<div x-show="isMobileMenuOpen" x-cloak
     class="fixed inset-0 z-[55] md:hidden"
     role="dialog"
     aria-modal="true"
     aria-labelledby="landing-mobile-nav-title"
     @keydown.escape.window="isMobileMenuOpen = false">
    <div x-show="isMobileMenuOpen"
         x-transition:enter="landing-motion-enter"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="landing-motion-leave"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm"
         @click="isMobileMenuOpen = false"
         aria-hidden="true"></div>
    <nav id="landing-mobile-nav"
         x-show="isMobileMenuOpen"
         x-transition:enter="landing-motion-enter"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="landing-motion-leave"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="absolute right-0 top-0 bottom-0 w-[min(100%,320px)] bg-white border-l border-slate-200 p-6 flex flex-col gap-2 shadow-2xl"
         aria-label="Menú de navegación móvil">
        <div class="flex items-center justify-between mb-4">
            <span id="landing-mobile-nav-title" class="text-lg font-black text-slate-900">Menú</span>
            <button type="button" @click="isMobileMenuOpen = false"
                    class="w-10 h-10 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center justify-center"
                    aria-label="Cerrar menú de navegación">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        {{-- <button type="button" @click="scrollTo('explorar')"
                class="text-left text-base font-bold text-slate-600 py-3 px-4 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 text-sm">
            <i class="fas fa-eye text-purple-500 mr-2"></i> Vista previa en landing
        </button> --}}
        @if ($landingNavExternal)
            <a href="{{ $landingHomeUrl }}#como-funciona" @click="isMobileMenuOpen = false"
               class="text-left text-base font-bold text-slate-800 py-3 px-4 rounded-xl hover:bg-slate-50 block">
                <i class="fas fa-list-ol text-cyan-600 mr-2"></i> Cómo funciona
            </a>
            <a href="{{ $landingHomeUrl }}#precios" @click="isMobileMenuOpen = false"
               class="text-left text-base font-bold text-slate-800 py-3 px-4 rounded-xl hover:bg-slate-50 block">
                <i class="fas fa-tags text-pink-500 mr-2"></i> Planes y precios
            </a>
        @else
            <button type="button" @click="scrollTo('como-funciona')"
                    class="text-left text-base font-bold text-slate-800 py-3 px-4 rounded-xl hover:bg-slate-50">
                <i class="fas fa-list-ol text-cyan-600 mr-2"></i> Cómo funciona
            </button>
            <button type="button" @click="scrollTo('precios')"
                    class="text-left text-base font-bold text-slate-800 py-3 px-4 rounded-xl hover:bg-slate-50">
                <i class="fas fa-tags text-pink-500 mr-2"></i> Planes y precios
            </button>
        @endif
        <a href="{{ route('tiendas.index') }}"
                class="text-left text-base font-bold text-slate-800 py-3 px-4 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200">
            <i class="fas fa-store text-purple-600 mr-2"></i> Marketplace
        </a>
        @auth
            @php
                $authUser = auth()->user();
                $shopSlug = optional($authUser->shop)->slug;
                $panelUrl = $shopSlug
                    ? route('admin.dashboard', ['shop_slug' => $shopSlug])
                    : url('/login');
            @endphp
            <a href="{{ $panelUrl }}"
               class="mt-4 text-center bg-lime-300 text-slate-900 font-black py-4 rounded-full border border-lime-400 shadow-lg hover:brightness-95 active:scale-[0.98]">
                <i class="fas fa-cube mr-2"></i> Ir al panel
            </a>
            <div class="mt-4 rounded-2xl border border-slate-200 overflow-hidden">
                <p class="px-4 py-3 text-sm font-black text-slate-900 break-all border-b border-slate-200">{{ $authUser->email }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 font-bold text-sm">
                        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        @else
            @unless ($hideLoginNavLink)
                <a href="{{ route('login') }}"
                   class="text-left text-base font-bold text-slate-600 py-3 px-4 rounded-xl hover:bg-slate-50 block">
                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar sesión
                </a>
            @endunless
            <a href="/register"
               class="mt-4 text-center bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-bold py-4 rounded-full shadow-lg hover:scale-[1.02] active:scale-[0.98]">
                Crear menú
            </a>
        @endauth
    </nav>
</div>
