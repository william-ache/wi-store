@php
    $landingNavExternal = $landingNavExternal ?? false;
    $hideLoginNavLink = $hideLoginNavLink ?? false;
    $landingHomeUrl = url('/');
@endphp

<header id="landing-header"
        class="sticky top-0 z-50 backdrop-blur-xl border-b transition-[background-color,border-color,box-shadow] duration-300"
        :class="isHeaderScrolled ? 'landing-header--scrolled' : 'landing-header--top'">
    <div class="landing-container">
        <div class="landing-header-bar h-16">
            <div class="landing-header-bar__brand shrink-0">
                @if ($landingNavExternal)
                    <a href="{{ $landingHomeUrl }}"
                       class="flex items-center gap-2.5 active:scale-[0.98] transition-transform group">
                @else
                    <a href="#inicio" @click.prevent="scrollTo('inicio')"
                       class="flex items-center gap-2.5 active:scale-[0.98] transition-transform group">
                @endif
                    <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-purple-600 to-cyan-500 flex items-center justify-center shadow-md shadow-purple-500/20 group-hover:shadow-purple-500/30 transition-shadow"
                          aria-hidden="true">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 17L17 7M17 7H9M17 7V15"/>
                        </svg>
                    </span>
                    <span class="text-xl font-black tracking-tight text-slate-900 whitespace-nowrap">
                        WI<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-cyan-500">Store</span>
                    </span>
                </a>
            </div>

            <nav class="landing-header-bar__nav hidden md:flex items-center justify-center min-w-0 px-2"
                 aria-label="Navegación principal">
                <ul class="flex items-center justify-center gap-5 lg:gap-7 flex-wrap">
                    <li>
                        @if ($landingNavExternal)
                            <a href="{{ $landingHomeUrl }}#como-funciona" class="landing-nav-link">Cómo funciona</a>
                        @else
                            <button type="button" @click="scrollTo('como-funciona')"
                                    :class="activeSection === 'como-funciona' ? 'landing-nav-link is-active' : ''"
                                    class="landing-nav-link">Cómo funciona</button>
                        @endif
                    </li>
                    <li>
                        @if ($landingNavExternal)
                            <a href="{{ $landingHomeUrl }}#precios" class="landing-nav-link">Precios</a>
                        @else
                            <button type="button" @click="scrollTo('precios')"
                                    :class="activeSection === 'precios' ? 'landing-nav-link is-active' : ''"
                                    class="landing-nav-link">Precios</button>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('tiendas.index') }}" class="landing-nav-link">Marketplace</a>
                    </li>
                </ul>
            </nav>

            <div class="landing-header-bar__actions flex items-center justify-end gap-3 sm:gap-4 shrink-0">
                @auth
                    @php
                        $authUser = auth()->user();
                        $shopSlug = optional($authUser->shop)->slug;
                        $panelUrl = $shopSlug
                            ? route('admin.dashboard', ['shop_slug' => $shopSlug])
                            : url('/login');
                        $userEmail = $authUser->email ?? '';
                        $avatarInitial = strtoupper(substr(trim($userEmail), 0, 1) ?: 'U');
                    @endphp

                    <div class="relative hidden md:flex items-center gap-3"
                         x-data="{ userMenuOpen: false }"
                         @keydown.escape.window="userMenuOpen = false">
                        <a href="{{ $panelUrl }}"
                           class="inline-flex items-center gap-2.5 rounded-2xl bg-lime-300 text-slate-900 font-black px-4 py-2.5 border border-lime-400 shadow-sm hover:brightness-95 transition">
                            <i class="fas fa-cube text-sm"></i>
                            <span class="text-sm leading-none">Ir al panel</span>
                        </a>
                        <button type="button"
                                @click="userMenuOpen = !userMenuOpen"
                                class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 text-white font-black text-sm border-2 border-white shadow-md hover:brightness-105 transition"
                                :aria-expanded="userMenuOpen"
                                aria-haspopup="true"
                                aria-label="Abrir menú de usuario">
                            {{ $avatarInitial }}
                        </button>

                        <div x-show="userMenuOpen" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             @click.outside="userMenuOpen = false"
                             class="absolute right-0 top-[calc(100%+0.65rem)] w-[20.5rem] bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden z-50">
                            <div class="px-5 py-4 border-b border-slate-200">
                                <p class="text-2xl leading-tight font-black text-slate-900 break-all">{{ $userEmail }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-5 py-4 text-red-600 hover:bg-red-50 font-bold text-xl leading-none flex items-center gap-2.5 transition">
                                    <i class="fas fa-sign-out-alt text-base"></i>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    @unless ($hideLoginNavLink)
                        <a href="{{ route('login') }}" class="landing-header-action-link {{ request()->routeIs('login') ? 'opacity-60 pointer-events-none' : '' }}">
                            Iniciar sesión
                        </a>
                    @endunless
                    <a href="/register" class="landing-header-cta">
                        Crear menú
                    </a>
                @endauth
                <button type="button" @click="isMobileMenuOpen = true"
                        class="md:hidden w-10 h-10 rounded-full border border-slate-200 text-slate-700 inline-flex items-center justify-center hover:bg-slate-50 shrink-0"
                        :aria-expanded="isMobileMenuOpen"
                        aria-controls="landing-mobile-nav"
                        aria-label="Abrir menú de navegación">
                    <i class="fas fa-bars text-sm" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</header>
