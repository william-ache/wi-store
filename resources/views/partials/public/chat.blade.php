<!-- Client Support Floating Chat Widget -->
<div x-data="publicChatWidget()"
     x-init="initWidget()"
     class="fixed bottom-6 right-6 z-[9999] select-none font-sans"
     x-cloak>

    <!-- Pulsing Online Badge (When closed) -->
    <div x-show="!chatOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-4"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-4"
         class="absolute bottom-3 right-20 flex items-center bg-white border border-slate-200/80 px-3 py-1 rounded-full shadow-[0_4px_12px_rgba(0,0,0,0.08)] pointer-events-none whitespace-nowrap">
        <span class="relative flex h-2.5 w-2.5 mr-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
        </span>
        <span class="text-xs font-black text-slate-700">Online</span>
    </div>

    <!-- MAIN CHAT TRIGGER BUTTON (Orange Circle "?") -->
    <button x-show="!chatOpen"
            @click="toggleChat()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-75"
            class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white shadow-[0_8px_24px_rgba(249,115,22,0.4)] hover:shadow-[0_12px_32px_rgba(249,115,22,0.5)] hover:scale-105 active:scale-95 transition-all duration-300 focus:outline-none border-2 border-white">
        <span class="text-2xl font-black">?</span>
    </button>

    <!-- CLOSE BUTTON (White Circle with Orange "X") -->
    <button x-show="chatOpen"
            @click="toggleChat()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-75"
            class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-[0_8px_24px_rgba(0,0,0,0.12)] hover:shadow-[0_12px_32px_rgba(0,0,0,0.18)] hover:scale-105 active:scale-95 transition-all duration-300 focus:outline-none border border-slate-100">
        <i class="fa-solid fa-xmark text-orange-500 text-2xl font-bold"></i>
    </button>

    <!-- PREMIUM CHAT BOX CONTAINER -->
    <div x-show="chatOpen"
         x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
         class="absolute bottom-20 right-0 w-[calc(100vw-32px)] sm:w-[385px] h-[520px] bg-white rounded-[24px] border border-orange-500/20 shadow-[0_16px_48px_rgba(0,0,0,0.15)] flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-white shrink-0">
            <div class="flex items-center gap-2">
                <span class="flex h-2.5 w-2.5 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="font-extrabold text-slate-800 text-base tracking-tight">Soporte WIStore</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 shadow-inner">
                <i class="fa-solid fa-face-smile text-lg"></i>
            </div>
        </div>

        <!-- Sub-header Alert Pane -->
        <div class="px-5 py-3.5 bg-gradient-to-r from-pink-50 via-purple-50 to-indigo-50 border-b border-slate-100 flex items-start gap-3 shrink-0">
            <span class="flex h-2 w-2 mt-1.5 relative shrink-0">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <div class="space-y-0.5">
                <h4 class="text-xs font-black text-rose-600">¡Estamos en línea!</h4>
                <p class="text-[11px] text-slate-500 leading-normal">Cuéntanos qué necesitas y te responderemos enseguida.</p>
            </div>
        </div>

        <!-- Chat Body (Messages Feed) -->
        <div x-ref="messageFeed"
             class="flex-1 overflow-y-auto px-5 py-4 space-y-4 bg-slate-50/50 scroll-smooth">
            
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.sender === 'user' 
                                 ? 'bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-[18px] rounded-tr-none shadow-[0_3px_10px_rgba(249,115,22,0.2)]' 
                                 : 'bg-white text-slate-700 rounded-[18px] rounded-tl-none border border-slate-100 shadow-sm'"
                         class="max-w-[85%] px-4 py-3 text-xs leading-relaxed break-words">
                        <span x-html="msg.text"></span>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white text-slate-400 rounded-[18px] rounded-tl-none border border-slate-100 px-4 py-3 shadow-sm flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>

            <!-- Pre-set options list -->
            <div x-show="!isTyping" class="pt-2 space-y-2">
                <div class="text-[10px] uppercase font-black tracking-wider text-slate-400 mb-2">Preguntas Rápidas</div>
                <div class="flex flex-wrap gap-2">
                    <button @click="sendUserMessage('Planes de Precios 💎')"
                            class="bg-white border border-slate-200 hover:border-orange-500/50 hover:bg-orange-50/20 text-slate-700 hover:text-orange-600 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95 duration-200">
                        Planes de Precios 💎
                    </button>
                    <button @click="sendUserMessage('Probar 7 Días Gratis ⚡')"
                            class="bg-white border border-slate-200 hover:border-orange-500/50 hover:bg-orange-50/20 text-slate-700 hover:text-orange-600 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95 duration-200">
                        Probar 7 Días Gratis ⚡
                    </button>
                    <button @click="sendUserMessage('Métodos de Pago 💸')"
                            class="bg-white border border-slate-200 hover:border-orange-500/50 hover:bg-orange-50/20 text-slate-700 hover:text-orange-600 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95 duration-200">
                        Métodos de Pago 💸
                    </button>
                    <button @click="sendUserMessage('Hablar con Asesor Humano 📞')"
                            class="bg-white border border-slate-200 hover:border-orange-500/50 hover:bg-orange-50/20 text-slate-700 hover:text-orange-600 px-3.5 py-2 rounded-xl text-[11px] font-bold shadow-sm transition-all active:scale-95 duration-200">
                        Hablar con Asesor 📞
                    </button>
                </div>
            </div>

        </div>

        <!-- Input Footer Area -->
        <div class="p-3 border-t border-slate-100 bg-white flex flex-col gap-2 shrink-0">
            <div class="flex items-center bg-slate-50 border border-slate-200 rounded-full px-4 py-2 hover:border-slate-300 focus-within:border-orange-500/50 focus-within:ring-1 focus-within:ring-orange-500/20 transition-all">
                <input type="text"
                       x-model="inputText"
                       @keydown.enter="sendUserMessage()"
                       placeholder="Escribe tu mensaje..."
                       class="flex-1 bg-transparent text-xs text-slate-700 placeholder-slate-400 focus:outline-none py-1">
                <button @click="sendUserMessage()"
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white flex items-center justify-center shadow-md active:scale-95 transition-all shrink-0 ml-2">
                    <i class="fa-solid fa-paper-plane text-[11px]"></i>
                </button>
            </div>
            <div class="text-[9px] text-slate-400 text-center select-none font-medium">
                Powered by <span class="font-extrabold text-orange-500">WIStore</span>
            </div>
        </div>

    </div>

</div>

<!-- Auto-contained Widget JavaScript Logic -->
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
                        text: '¡Hola! 👋 Bienvenido al soporte interactivo de <b>WIStore</b>. Estoy aquí para guiarte en lo que necesites.'
                    },
                    {
                        sender: 'bot',
                        text: '¿De qué te gustaría hablar hoy? Selecciona una de las opciones rápidas o escríbeme directamente:'
                    }
                ];
            },
            
            toggleChat() {
                this.chatOpen = !this.chatOpen;
                if (this.chatOpen) {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                }
            },
            
            sendUserMessage(text = null) {
                const messageText = text ? text.trim() : this.inputText.trim();
                if (!messageText) return;
                
                // Add user message
                this.messages.push({
                    sender: 'user',
                    text: messageText
                });
                
                if (!text) {
                    this.inputText = '';
                }
                
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
                
                // Simulate bot typing response
                this.isTyping = true;
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
                
                setTimeout(() => {
                    this.isTyping = false;
                    const botReply = this.generateBotReply(messageText);
                    this.messages.push({
                        sender: 'bot',
                        text: botReply
                    });
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                }, 800);
            },
            
            generateBotReply(query) {
                const cleanQuery = query.toLowerCase();
                
                if (cleanQuery.includes('precio') || cleanQuery.includes('plan') || cleanQuery.includes('costo') || cleanQuery.includes('planes')) {
                    return `Ofrecemos planes comerciales altamente competitivos diseñados para el éxito de tu negocio:<br><br>` +
                           `💎 <b>Plan Standard ($14.99/mes):</b> Incluye catálogo digital completo, pedidos por WhatsApp, personalización básica y 0% comisiones.<br><br>` +
                           `👑 <b>Plan Premium ($24.99/mes):</b> Incluye todo lo del Standard más dominio personalizado, soporte prioritario, analítica avanzada, códigos QR dinámicos y personalización premium.<br><br>` +
                           `⚡ <i>¡Prueba el Plan Premium gratis por 7 días sin tarjeta!</i>`;
                }
                
                if (cleanQuery.includes('registro') || cleanQuery.includes('crear') || cleanQuery.includes('cuenta') || cleanQuery.includes('probar') || cleanQuery.includes('registrarse')) {
                    return `¡Crear tu tienda digital toma menos de 3 minutos! ⚡<br><br>` +
                           `No requieres tarjeta de crédito ni compromisos previos. Inicias directamente con una <b>prueba premium de 7 días gratis</b>.<br><br>` +
                           `👉 Registra tu comercio ingresando a: <a href="/register" class="underline font-bold text-orange-500 hover:text-orange-600">Registrarme en WIStore</a>.`;
                }
                
                if (cleanQuery.includes('pago') || cleanQuery.includes('bcv') || cleanQuery.includes('banco') || cleanQuery.includes('pagar') || cleanQuery.includes('métodos')) {
                    return `Aceptamos múltiples canales de pago para tu mayor comodidad:<br><br>` +
                           `• <b>Pago Móvil y Transferencias Bancarias</b> indexados a la tasa oficial diaria emitida por el Banco Central de Venezuela (BCV).<br>` +
                           `• <b>Zelle</b>, <b>Binance Pay (USDT)</b> y <b>PayPal</b>.<br><br>` +
                           `El sistema genera automáticamente el recibo detallado con las instrucciones de pago exactas en cada ciclo de facturación.`;
                }
                
                if (cleanQuery.includes('contacto') || cleanQuery.includes('asesor') || cleanQuery.includes('soporte') || cleanQuery.includes('whatsapp') || cleanQuery.includes('humano')) {
                    return `Puedes hablar de inmediato con uno de nuestros agentes de soporte humano en WhatsApp para resolver cualquier duda técnica o comercial:<br><br>` +
                           `📲 Enlace directo: <a href="https://wa.me/584121305420?text=Hola!%20Necesito%20soporte%20sobre%20WIStore" target="_blank" class="underline font-bold text-orange-500 hover:text-orange-600">Iniciar Chat de WhatsApp</a><br>` +
                           `📞 Teléfono de atención: <b>+58 (412) 130-5420</b>`;
                }
                
                if (cleanQuery.includes('hola') || cleanQuery.includes('buenas') || cleanQuery.includes('buenos') || cleanQuery.includes('saludo')) {
                    return `¡Hola! Qué gusto saludarte. ¿En qué podemos ayudarte el día de hoy?`;
                }
                
                return `Entiendo tu consulta. Para darte la mejor asistencia, puedes hablar directamente con nuestro equipo de soporte técnico y comercial a través de WhatsApp:<br><br>` +
                       `📲 Enlace: <a href="https://wa.me/584121305420?text=Hola!%20Tengo%20una%20duda:%20${encodeURIComponent(query)}" target="_blank" class="underline font-bold text-orange-500 hover:text-orange-600">Hablar con Asesor Humano</a><br><br>` +
                       `O bien, puedes seleccionar una de las opciones del menú interactivo de arriba.`;
            },
            
            scrollToBottom() {
                const feed = this.$refs.messageFeed;
                if (feed) {
                    feed.scrollTop = feed.scrollHeight;
                }
            }
        };
    }
</script>
