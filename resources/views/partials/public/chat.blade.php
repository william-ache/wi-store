<!-- Client Support Floating Chat Widget -->
<div x-data="publicChatWidget()"
     x-init="initWidget()"
     class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-[9999] select-none font-sans"
     x-cloak>

    <div class="relative">
    <div class="relative w-14 h-14 shrink-0">
        {{-- Aviso de cookies (Wibi) — bloquea el chat hasta aceptar --}}
        <div x-show="!cookiesAccepted"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             role="dialog"
             aria-labelledby="wibi-cookie-title"
             aria-describedby="wibi-cookie-desc"
             class="wi-wibi-cookie-banner absolute bottom-[calc(100%+10px)] right-0 z-20 rounded-[18px] border border-slate-600/80 shadow-[0_12px_40px_rgba(0,0,0,0.45)] p-5 sm:p-6">
            <div class="flex items-start gap-3 mb-3">
                <div class="wi-wibi-cookie-icon w-9 h-9 rounded-lg flex items-center justify-center shrink-0" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved text-slate-200 text-sm"></i>
                </div>
                <h3 id="wibi-cookie-title" class="text-[15px] font-bold text-white pt-1.5 leading-tight">Cookies</h3>
            </div>
            <p id="wibi-cookie-desc" class="text-[12px] text-slate-300 leading-relaxed mb-5">
                Utilizamos cookies esenciales para el funcionamiento de la plataforma y cookies analíticas para mejorar tu experiencia. Conoce más en nuestra
                <a href="{{ route('legal.privacidad') }}" target="_blank" rel="noopener noreferrer" class="text-violet-400 underline underline-offset-2 hover:text-violet-300 font-medium">Política de Privacidad</a>.
            </p>
            <div class="flex items-center justify-end gap-2 sm:gap-3">
                <button type="button"
                        @click="acceptCookies('essential')"
                        class="px-2 py-2 text-[12px] font-semibold text-slate-400 hover:text-slate-200 transition-colors rounded-lg">
                    Solo esenciales
                </button>
                <button type="button"
                        @click="acceptCookies('all')"
                        class="px-4 py-2 text-[12px] font-bold text-white bg-violet-600 hover:bg-violet-500 rounded-full shadow-[0_4px_14px_rgba(124,58,237,0.4)] transition-colors active:scale-95">
                    Aceptar todas
                </button>
            </div>
            <span class="wi-wibi-cookie-tail absolute -bottom-1.5 right-5 w-3 h-3 rotate-45 border-r border-b border-slate-600/80" aria-hidden="true"></span>
        </div>

        {{-- Mensaje flotante de Wibi --}}
        <button type="button"
                x-show="showFloatingTeaser"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                @click="toggleChat()"
                class="wi-wibi-teaser absolute bottom-[calc(100%+10px)] right-0 max-w-[min(calc(100vw-88px),200px)] z-10 cursor-pointer group/teaser focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#0e1228] rounded-2xl"
                :aria-label="'Wibi dice: ' + teaserMessages[teaserIndex] + '. Abrir chat'">
            <span class="relative block px-3.5 py-2 rounded-2xl rounded-br-md bg-white/95 border border-purple-200/90 shadow-[0_8px_24px_rgba(88,28,135,0.22)] backdrop-blur-sm group-hover/teaser:border-purple-400/80 group-hover/teaser:shadow-[0_10px_28px_rgba(168,85,247,0.28)] transition-shadow">
                <span class="text-[12px] font-extrabold text-slate-800 leading-snug whitespace-nowrap" x-text="teaserMessages[teaserIndex]"></span>
            </span>
            <span class="absolute -bottom-1.5 right-3 w-3 h-3 rotate-45 bg-white border-r border-b border-purple-200/90 group-hover/teaser:border-purple-400/80" aria-hidden="true"></span>
        </button>

        <!-- Un solo botón toggle -->
        <button @click="toggleChat()"
                :disabled="!cookiesAccepted && !chatOpen"
                class="wi-wibi-fab absolute inset-0 rounded-full flex items-center justify-center transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#0e1228] hover:scale-105 active:scale-95 disabled:cursor-not-allowed disabled:hover:scale-100"
                :class="chatOpen ? 'wi-wibi-fab--open wi-wibi-bob-paused' : 'wi-wibi-fab--closed wi-wibi-bob'"
                :aria-label="!cookiesAccepted ? 'Acepta las cookies para abrir el chat con Wibi' : (chatOpen ? 'Cerrar chat' : 'Abrir chat con Wibi')">
            <span x-show="!chatOpen" class="relative flex items-center justify-center wi-wibi-face">
                @include('partials.public.chat-bot-face', ['size' => 'md', 'class' => 'text-white'])
                <span class="absolute -top-0.5 -right-0.5 flex h-3.5 w-3.5 items-center justify-center pointer-events-none">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border-2 border-white"></span>
                </span>
            </span>
            <i x-show="chatOpen" x-cloak class="fa-solid fa-xmark text-purple-600 text-2xl font-bold"></i>
        </button>
    </div>

    <div x-show="chatOpen"
         x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
         class="absolute bottom-[calc(100%+12px)] right-0 w-[min(calc(100vw-40px),385px)] h-[min(520px,calc(100vh-120px))] bg-white rounded-[24px] border border-purple-500/20 shadow-[0_16px_48px_rgba(88,28,135,0.18)] flex flex-col overflow-hidden">

        <!-- Header -->
        <div class="px-4 py-3.5 border-b border-purple-100/80 flex items-center justify-between bg-gradient-to-r from-purple-600/10 via-fuchsia-500/5 to-cyan-500/10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 flex items-center justify-center shadow-md shadow-purple-500/25 shrink-0">
                    @include('partials.public.chat-bot-face', ['size' => 'sm', 'class' => 'text-white'])
                </div>
                <div>
                    <span class="font-extrabold text-slate-800 text-sm tracking-tight block leading-tight">Wibi · Soporte</span>
                    <span class="text-[10px] font-semibold text-emerald-600 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        En línea
                    </span>
                </div>
            </div>
            <button type="button" @click="toggleChat()" class="w-8 h-8 rounded-full hover:bg-purple-100/80 text-purple-500 flex items-center justify-center shrink-0 transition-colors" aria-label="Cerrar chat">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Aviso -->
        <div class="px-4 py-3 bg-gradient-to-r from-purple-50 via-fuchsia-50/80 to-cyan-50 border-b border-purple-100/60 flex items-start gap-3 shrink-0">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500/20 to-cyan-500/20 flex items-center justify-center shrink-0">
                @include('partials.public.chat-bot-face', ['size' => 'xs', 'class' => 'text-purple-600'])
            </div>
            <div>
                <h4 class="text-xs font-black text-purple-700">¡Hola! Soy tu asistente</h4>
                <p class="text-[11px] text-slate-500 leading-normal">Pregúntame lo que quieras sobre WI-Store.</p>
            </div>
        </div>

        <!-- Preguntas rápidas (siempre arriba; compactas tras el primer mensaje) -->
        <div class="shrink-0 border-b border-purple-100/70 bg-white">
            <div x-show="!hasUserMessage" x-cloak class="px-4 py-3">
                <div class="text-[10px] uppercase font-black tracking-wider text-purple-400/90 mb-2">Preguntas rápidas</div>
                <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                    <template x-for="chip in quickChips" :key="chip.label">
                        <button type="button"
                                @click="sendUserMessage(chip.label)"
                                class="bg-white border border-purple-200/80 hover:border-purple-400 hover:bg-purple-50 text-slate-700 hover:text-purple-700 px-2 py-2 sm:px-3 rounded-xl text-[10px] sm:text-[11px] font-bold shadow-sm transition-all active:scale-95 text-center sm:text-left leading-tight min-h-[2.75rem] sm:min-h-0">
                            <span class="sm:hidden" x-text="chip.mobile"></span>
                            <span class="hidden sm:inline" x-text="chip.label"></span>
                        </button>
                    </template>
                </div>
            </div>
            <div x-show="hasUserMessage" x-cloak class="px-3 py-2 flex items-center gap-2">
                <span class="text-[9px] uppercase font-black tracking-wider text-purple-400/80 shrink-0">Rápidas</span>
                <div class="flex gap-1.5 overflow-x-auto wi-chat-quick-scroll flex-1 min-w-0 pb-0.5">
                    <template x-for="chip in quickChips" :key="'compact-' + chip.label">
                        <button type="button"
                                @click="sendUserMessage(chip.label)"
                                class="shrink-0 bg-slate-50 border border-purple-200/70 hover:border-purple-400 hover:bg-purple-50 text-slate-600 hover:text-purple-700 px-2.5 py-1 rounded-lg text-[10px] font-bold transition-all active:scale-95 whitespace-nowrap"
                                x-text="chip.short"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Mensajes -->
        <div x-ref="messageFeed"
             class="flex-1 overflow-y-auto px-4 py-4 space-y-4 bg-slate-50/80 scroll-smooth">

            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start items-end gap-2'">
                    <template x-if="msg.sender === 'bot'">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 flex items-center justify-center shadow-sm shrink-0 mb-0.5"
                             aria-hidden="true">
                            @include('partials.public.chat-bot-face', ['size' => 'xs', 'class' => 'text-white'])
                        </div>
                    </template>
                    <div :class="msg.sender === 'user'
                                 ? 'bg-gradient-to-br from-purple-600 to-cyan-600 text-white rounded-[18px] rounded-tr-sm shadow-[0_3px_12px_rgba(147,51,234,0.25)]'
                                 : 'bg-white text-slate-700 rounded-[18px] rounded-tl-sm border border-purple-100/80 shadow-sm wi-chat-bot-msg'"
                         class="max-w-[78%] px-4 py-3 text-xs leading-relaxed break-words">
                        <span x-html="msg.text"></span>
                    </div>
                </div>
            </template>

            <div x-show="isTyping" class="flex justify-start items-end gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 flex items-center justify-center shadow-sm shrink-0">
                    @include('partials.public.chat-bot-face', ['size' => 'xs', 'class' => 'text-white'])
                </div>
                <div class="bg-white text-slate-400 rounded-[18px] rounded-tl-sm border border-purple-100 px-4 py-3 shadow-sm flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 bg-fuchsia-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>

        </div>

        <!-- Input -->
        <div class="p-3 border-t border-purple-100/80 bg-white flex flex-col gap-2 shrink-0">
            <div class="flex items-center bg-slate-50 border border-purple-200/60 rounded-full px-4 py-2 focus-within:border-purple-400 focus-within:ring-2 focus-within:ring-purple-500/15 transition-all">
                <label for="wibi-chat-input" class="sr-only">Escribe tu mensaje a Wibi</label>
                <input id="wibi-chat-input" type="text"
                       x-model="inputText"
                       @keydown.enter="sendUserMessage()"
                       placeholder="Escribe tu mensaje..."
                       autocomplete="off"
                       class="flex-1 bg-transparent text-xs text-slate-700 placeholder-slate-400 focus:outline-none py-1">
                <button @click="sendUserMessage()"
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 hover:brightness-110 text-white flex items-center justify-center shadow-md active:scale-95 transition-all shrink-0 ml-2">
                    <i class="fa-solid fa-paper-plane text-[11px]"></i>
                </button>
            </div>
            <div class="text-[9px] text-slate-400 text-center font-medium">
                Powered by <span class="font-extrabold bg-gradient-to-r from-purple-600 to-cyan-500 bg-clip-text text-transparent">WI-Store</span>
            </div>
        </div>
    </div>
    </div>
</div>

<style>
    .wi-wibi-cookie-banner {
        width: min(calc(100vw - 40px), 400px);
        background-color: #1e222e;
        background-image: none;
    }

    .wi-wibi-cookie-icon {
        background-color: #2a3142;
    }

    .wi-wibi-cookie-tail {
        background-color: #1e222e;
    }

    .wi-wibi-fab.wi-wibi-fab--closed {
        background: linear-gradient(135deg, #9333ea 0%, #d946ef 50%, #06b6d4 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 28px rgba(168, 85, 247, 0.45);
    }

    .wi-wibi-fab.wi-wibi-fab--open {
        background: #ffffff;
        border: 1px solid rgba(233, 213, 255, 0.8);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .wi-chat-bot-msg a {
        color: #7c3aed;
        font-weight: 700;
        text-decoration: underline;
    }
    .wi-chat-bot-msg a:hover {
        color: #0891b2;
    }
    .wi-chat-quick-scroll {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .wi-chat-quick-scroll::-webkit-scrollbar {
        display: none;
    }

    @keyframes wi-wibi-bob {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        35% { transform: translateY(-5px) rotate(-1.5deg); }
        70% { transform: translateY(-2px) rotate(1deg); }
    }

    @keyframes wi-wibi-face-wiggle {
        0%, 100% { transform: rotate(0deg) scale(1); }
        25% { transform: rotate(-4deg) scale(1.02); }
        75% { transform: rotate(4deg) scale(1.02); }
    }

    @keyframes wi-wibi-teaser-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }

    .wi-wibi-bob {
        animation: wi-wibi-bob 2.6s ease-in-out infinite;
    }

    .wi-wibi-bob-paused {
        animation: none;
    }

    .wi-wibi-bob:hover {
        animation-play-state: paused;
    }

    .wi-wibi-face {
        animation: wi-wibi-face-wiggle 4s ease-in-out infinite;
    }

    .wi-wibi-bob:hover .wi-wibi-face {
        animation-duration: 1.2s;
    }

    .wi-wibi-teaser {
        animation: wi-wibi-teaser-float 3s ease-in-out infinite;
    }

    @media (prefers-reduced-motion: reduce) {
        .wi-wibi-bob,
        .wi-wibi-face,
        .wi-wibi-teaser {
            animation: none;
        }
    }
</style>

<script>
    function publicChatWidget() {
        return {
            chatOpen: false,
            cookieConsent: null,
            inputText: '',
            messages: [],
            isTyping: false,
            hasUserMessage: false,
            get cookiesAccepted() {
                return this.cookieConsent === 'essential' || this.cookieConsent === 'all';
            },
            teaserMessages: [
                '¡Hey!',
                '¡Hola!',
                'Soy Wibi',
                '¿Necesitas ayuda?',
                '¡Aquí estoy!',
                '¿Te ayudo?',
                'Pregúntame algo',
            ],
            teaserIndex: 0,
            teaserVisible: true,
            teaserTimer: null,
            teaserCycleDone: false,
            teaserDismissed: false,
            get showFloatingTeaser() {
                return this.cookiesAccepted && !this.chatOpen && !this.teaserDismissed && this.teaserVisible;
            },
            quickChips: [
                { label: 'Planes de Precios 💎', mobile: 'Planes 💎', short: 'Planes' },
                { label: @json('Probar ' . $wiStoreTrialDays . ' Días Gratis ⚡'), mobile: @json($wiStoreTrialLabel . ' ⚡'), short: @json((string) $wiStoreTrialDays . ' días') },
                { label: 'Métodos de Pago 💸', mobile: 'Pagos 💸', short: 'Pagos' },
                { label: 'Hablar con Asesor Humano 📞', mobile: 'Asesor 📞', short: 'Asesor' },
            ],

            initWidget() {
                try {
                    const stored = localStorage.getItem('wibi_cookie_consent');
                    if (stored === 'essential' || stored === 'all') {
                        this.cookieConsent = stored;
                    }
                } catch (e) { /* localStorage no disponible */ }
                if (this.cookiesAccepted) {
                    this.loadWelcomeMessages();
                    this.startTeaserRotation();
                }
            },

            acceptCookies(level) {
                this.cookieConsent = level;
                try {
                    localStorage.setItem('wibi_cookie_consent', level);
                } catch (e) { /* ignore */ }
                this.loadWelcomeMessages();
                if (!this.chatOpen) {
                    this.startTeaserRotation();
                }
            },

            loadWelcomeMessages() {
                if (this.messages.length > 0) return;
                this.messages = [
                    {
                        sender: 'bot',
                        text: '¡Hola! 👋 Soy <b>Wibi</b>, el asistente de <b>WI-Store</b>. Estoy aquí para ayudarte paso a paso.'
                    },
                    {
                        sender: 'bot',
                        text: '¿Qué te gustaría saber? Elige una pregunta rápida arriba o escríbeme:'
                    }
                ];
            },

            stopTeaser() {
                this.teaserDismissed = true;
                this.teaserVisible = false;
                this.teaserCycleDone = true;
                if (this.teaserTimer) {
                    clearInterval(this.teaserTimer);
                    this.teaserTimer = null;
                }
            },

            startTeaserRotation() {
                if (this.teaserTimer) {
                    clearInterval(this.teaserTimer);
                    this.teaserTimer = null;
                }
                if (this.teaserDismissed || this.teaserCycleDone) {
                    return;
                }
                const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const intervalMs = reducedMotion ? 6000 : 3200;
                const fadeMs = reducedMotion ? 0 : 260;
                this.teaserTimer = setInterval(() => {
                    if (this.chatOpen || this.teaserDismissed) {
                        return;
                    }
                    if (this.teaserIndex >= this.teaserMessages.length - 1) {
                        clearInterval(this.teaserTimer);
                        this.teaserTimer = null;
                        this.teaserCycleDone = true;
                        setTimeout(() => this.stopTeaser(), intervalMs);
                        return;
                    }
                    this.teaserVisible = false;
                    setTimeout(() => {
                        if (this.chatOpen || this.teaserDismissed) {
                            return;
                        }
                        this.teaserIndex += 1;
                        this.teaserVisible = true;
                        if (this.teaserIndex >= this.teaserMessages.length - 1) {
                            clearInterval(this.teaserTimer);
                            this.teaserTimer = null;
                            this.teaserCycleDone = true;
                            setTimeout(() => this.stopTeaser(), intervalMs);
                        }
                    }, fadeMs);
                }, intervalMs);
            },

            destroy() {
                this.stopTeaser();
            },

            toggleChat() {
                if (!this.cookiesAccepted && !this.chatOpen) {
                    return;
                }
                this.chatOpen = !this.chatOpen;
                if (this.chatOpen) {
                    this.stopTeaser();
                    this.$nextTick(() => this.scrollToBottom());
                }
            },

            sendUserMessage(text = null) {
                if (!this.cookiesAccepted) return;
                const messageText = text ? text.trim() : this.inputText.trim();
                if (!messageText) return;

                this.hasUserMessage = true;
                this.messages.push({ sender: 'user', text: messageText });
                if (!text) this.inputText = '';

                this.$nextTick(() => this.scrollToBottom());

                this.isTyping = true;
                this.$nextTick(() => this.scrollToBottom());

                setTimeout(() => {
                    this.isTyping = false;
                    this.messages.push({
                        sender: 'bot',
                        text: this.generateBotReply(messageText)
                    });
                    this.$nextTick(() => this.scrollToBottom());
                }, 800);
            },

            generateBotReply(query) {
                const cleanQuery = query.toLowerCase();
                const linkClass = 'underline font-bold text-purple-600 hover:text-cyan-600';

                if (cleanQuery.includes('precio') || cleanQuery.includes('plan') || cleanQuery.includes('costo') || cleanQuery.includes('planes')) {
                    return `Estamos actualizando nuestros planes. Los precios estarán <b>muy pronto</b>.<br><br>` +
                           `💎 <b>Emprendedor:</b> Catálogo, pedidos por WhatsApp y 0% comisiones.<br><br>` +
                           `👑 <b>Negocio:</b> Todo lo anterior + pagos integrados y soporte VIP.<br><br>` +
                           `👉 <a href="/comparativa" class="${linkClass}">Ver comparativa de planes</a>`;
                }

                if (cleanQuery.includes('registro') || cleanQuery.includes('crear') || cleanQuery.includes('cuenta') || cleanQuery.includes('probar') || cleanQuery.includes('registrarse')) {
                    return `¡Crear tu tienda toma menos de 3 minutos! ⚡<br><br>` +
                           `Prueba premium <b>@json($wiStoreTrialLabel)</b>. @json($wiStoreTrialDisclaimer)<br><br>` +
                           `👉 <a href="/register" class="${linkClass}">Registrarme en WI-Store</a>`;
                }

                if (cleanQuery.includes('pago') || cleanQuery.includes('bcv') || cleanQuery.includes('banco') || cleanQuery.includes('pagar') || cleanQuery.includes('métodos')) {
                    return `Aceptamos varios métodos de pago:<br><br>` +
                           `• <b>Pago Móvil y transferencias</b> a tasa BCV.<br>` +
                           `• <b>Zelle</b>, <b>Binance (USDT)</b> y <b>PayPal</b>.`;
                }

                if (cleanQuery.includes('contacto') || cleanQuery.includes('asesor') || cleanQuery.includes('soporte') || cleanQuery.includes('whatsapp') || cleanQuery.includes('humano') || cleanQuery.includes('correo') || cleanQuery.includes('email')) {
                    return `Te conecto con nuestro equipo:<br><br>` +
                           `📧 <a href="mailto:{{ $wiStoreSupportEmail }}" class="${linkClass}">{{ $wiStoreSupportEmail }}</a><br>` +
                           `📲 <a href="https://wa.me/584121305420?text=Hola!%20Necesito%20soporte%20sobre%20WI-Store" target="_blank" class="${linkClass}">Chat de WhatsApp</a><br>` +
                           `📞 <b>+58 (412) 130-5420</b>`;
                }

                if (cleanQuery.includes('hola') || cleanQuery.includes('buenas') || cleanQuery.includes('buenos') || cleanQuery.includes('saludo')) {
                    return `¡Qué gusto saludarte! 😊 ¿En qué te ayudo hoy?`;
                }

                return `Para esa consulta te recomiendo hablar con nuestro equipo:<br><br>` +
                       `📧 <a href="mailto:{{ $wiStoreSupportEmail }}" class="${linkClass}">{{ $wiStoreSupportEmail }}</a><br>` +
                       `📲 <a href="https://wa.me/584121305420?text=Hola!%20Tengo%20una%20duda:%20${encodeURIComponent(query)}" target="_blank" class="${linkClass}">Hablar con asesor</a><br><br>` +
                       `O elige una opción del menú de arriba.`;
            },

            scrollToBottom() {
                const feed = this.$refs.messageFeed;
                if (feed) feed.scrollTop = feed.scrollHeight;
            }
        };
    }
</script>
