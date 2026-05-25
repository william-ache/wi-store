<!-- Client Support Floating Chat Widget -->
<div x-data="publicChatWidget()"
     x-init="initWidget()"
     class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-[9999] select-none font-sans w-14 h-14"
     x-cloak>

    <!-- Un solo botón toggle -->
    <button @click="toggleChat()"
            class="absolute inset-0 rounded-full flex items-center justify-center transition-all duration-300 focus:outline-none hover:scale-105 active:scale-95"
            :class="chatOpen ? 'bg-white border border-purple-200/80 shadow-[0_8px_24px_rgba(0,0,0,0.12)]' : 'bg-gradient-to-br from-purple-600 via-fuchsia-500 to-cyan-500 border-2 border-white/90 shadow-[0_8px_28px_rgba(168,85,247,0.45)]'"
            :aria-label="chatOpen ? 'Cerrar chat' : 'Abrir chat'">
        <span x-show="!chatOpen" class="relative flex items-center justify-center">
            @include('partials.public.chat-bot-face', ['size' => 'md', 'class' => 'text-white'])
            <span class="absolute -top-0.5 -right-0.5 flex h-3.5 w-3.5 items-center justify-center pointer-events-none">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border-2 border-white"></span>
            </span>
        </span>
        <i x-show="chatOpen" x-cloak class="fa-solid fa-xmark text-purple-600 text-2xl font-bold"></i>
    </button>

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
                <p class="text-[11px] text-slate-500 leading-normal">Pregúntame lo que quieras sobre WIStore.</p>
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

            <div x-show="!isTyping" class="pt-2 space-y-2 pl-10">
                <div class="text-[10px] uppercase font-black tracking-wider text-purple-400/90 mb-2">Preguntas rápidas</div>
                <div class="flex flex-wrap gap-2">
                    <button @click="sendUserMessage('Planes de Precios 💎')"
                            class="bg-white border border-purple-200/80 hover:border-purple-400 hover:bg-purple-50 text-slate-700 hover:text-purple-700 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95">
                        Planes de Precios 💎
                    </button>
                    <button @click="sendUserMessage('Probar 7 Días Gratis ⚡')"
                            class="bg-white border border-purple-200/80 hover:border-cyan-400 hover:bg-cyan-50 text-slate-700 hover:text-cyan-700 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95">
                        Probar 7 Días Gratis ⚡
                    </button>
                    <button @click="sendUserMessage('Métodos de Pago 💸')"
                            class="bg-white border border-purple-200/80 hover:border-purple-400 hover:bg-purple-50 text-slate-700 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95">
                        Métodos de Pago 💸
                    </button>
                    <button @click="sendUserMessage('Hablar con Asesor Humano 📞')"
                            class="bg-white border border-purple-200/80 hover:border-fuchsia-400 hover:bg-fuchsia-50 text-slate-700 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95">
                        Hablar con Asesor 📞
                    </button>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 border-t border-purple-100/80 bg-white flex flex-col gap-2 shrink-0">
            <div class="flex items-center bg-slate-50 border border-purple-200/60 rounded-full px-4 py-2 focus-within:border-purple-400 focus-within:ring-2 focus-within:ring-purple-500/15 transition-all">
                <input type="text"
                       x-model="inputText"
                       @keydown.enter="sendUserMessage()"
                       placeholder="Escribe tu mensaje..."
                       class="flex-1 bg-transparent text-xs text-slate-700 placeholder-slate-400 focus:outline-none py-1">
                <button @click="sendUserMessage()"
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 hover:brightness-110 text-white flex items-center justify-center shadow-md active:scale-95 transition-all shrink-0 ml-2">
                    <i class="fa-solid fa-paper-plane text-[11px]"></i>
                </button>
            </div>
            <div class="text-[9px] text-slate-400 text-center font-medium">
                Powered by <span class="font-extrabold bg-gradient-to-r from-purple-600 to-cyan-500 bg-clip-text text-transparent">WIStore</span>
            </div>
        </div>
    </div>
</div>

<style>
    .wi-chat-bot-msg a {
        color: #7c3aed;
        font-weight: 700;
        text-decoration: underline;
    }
    .wi-chat-bot-msg a:hover {
        color: #0891b2;
    }
</style>

<script>
    function publicChatWidget() {
        return {
            chatOpen: false,
            inputText: '',
            messages: [],
            isTyping: false,

            initWidget() {
                this.messages = [
                    {
                        sender: 'bot',
                        text: '¡Hola! 👋 Soy <b>Wibi</b>, el asistente de <b>WIStore</b>. Estoy aquí para ayudarte paso a paso.'
                    },
                    {
                        sender: 'bot',
                        text: '¿Qué te gustaría saber? Toca una opción rápida o escríbeme:'
                    }
                ];
            },

            toggleChat() {
                this.chatOpen = !this.chatOpen;
                if (this.chatOpen) {
                    this.$nextTick(() => this.scrollToBottom());
                }
            },

            sendUserMessage(text = null) {
                const messageText = text ? text.trim() : this.inputText.trim();
                if (!messageText) return;

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
                           `💎 <b>Standard:</b> Catálogo, pedidos por WhatsApp y 0% comisiones.<br><br>` +
                           `👑 <b>Premium:</b> Todo lo anterior + pagos integrados y soporte VIP.<br><br>` +
                           `👉 <a href="/comparativa" class="${linkClass}">Ver comparativa de planes</a>`;
                }

                if (cleanQuery.includes('registro') || cleanQuery.includes('crear') || cleanQuery.includes('cuenta') || cleanQuery.includes('probar') || cleanQuery.includes('registrarse')) {
                    return `¡Crear tu tienda toma menos de 3 minutos! ⚡<br><br>` +
                           `Prueba premium <b>7 días gratis</b> sin tarjeta.<br><br>` +
                           `👉 <a href="/register" class="${linkClass}">Registrarme en WIStore</a>`;
                }

                if (cleanQuery.includes('pago') || cleanQuery.includes('bcv') || cleanQuery.includes('banco') || cleanQuery.includes('pagar') || cleanQuery.includes('métodos')) {
                    return `Aceptamos varios métodos de pago:<br><br>` +
                           `• <b>Pago Móvil y transferencias</b> a tasa BCV.<br>` +
                           `• <b>Zelle</b>, <b>Binance (USDT)</b> y <b>PayPal</b>.`;
                }

                if (cleanQuery.includes('contacto') || cleanQuery.includes('asesor') || cleanQuery.includes('soporte') || cleanQuery.includes('whatsapp') || cleanQuery.includes('humano') || cleanQuery.includes('correo') || cleanQuery.includes('email')) {
                    return `Te conecto con nuestro equipo:<br><br>` +
                           `📧 <a href="mailto:{{ $wistoreSupportEmail }}" class="${linkClass}">{{ $wistoreSupportEmail }}</a><br>` +
                           `📲 <a href="https://wa.me/584121305420?text=Hola!%20Necesito%20soporte%20sobre%20WIStore" target="_blank" class="${linkClass}">Chat de WhatsApp</a><br>` +
                           `📞 <b>+58 (412) 130-5420</b>`;
                }

                if (cleanQuery.includes('hola') || cleanQuery.includes('buenas') || cleanQuery.includes('buenos') || cleanQuery.includes('saludo')) {
                    return `¡Qué gusto saludarte! 😊 ¿En qué te ayudo hoy?`;
                }

                return `Para esa consulta te recomiendo hablar con nuestro equipo:<br><br>` +
                       `📧 <a href="mailto:{{ $wistoreSupportEmail }}" class="${linkClass}">{{ $wistoreSupportEmail }}</a><br>` +
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
