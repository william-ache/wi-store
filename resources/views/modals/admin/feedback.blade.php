<!-- VENTANA MODAL GLOBAL DE FEEDBACK -->
<div x-data="{ 
    tab: 'form',
    feedbacks: [],
    loadingFeedbacks: false,
    
    async fetchFeedbacks() {
        if (this.feedbacks.length > 0) return;
        this.loadingFeedbacks = true;
        try {
            const response = await fetch('/{{ config('current_shop')->slug }}/admin/feedback', {
                headers: { 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.success) {
                this.feedbacks = data.feedbacks;
            }
        } catch (e) {
            console.error('Error al obtener el historial de feedback:', e);
        } finally {
            this.loadingFeedbacks = false;
        }
    }
}"
@keydown.escape.window="showFeedbackModal = false"
x-show="showFeedbackModal"
x-cloak
class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <!-- Fondo de desenfoque oscuro -->
    <div x-show="showFeedbackModal" 
         x-transition.opacity.duration.300ms 
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" 
         @click="showFeedbackModal = false"></div>

    <!-- Contenedor del Modal -->
    <div x-show="showFeedbackModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative bg-white dark:bg-slate-900 rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden flex flex-col p-6 sm:p-8 transition-colors duration-300 z-10 border border-slate-100 dark:border-slate-800">
        
        <!-- Botón de Cerrar (X) -->
        <button @click="showFeedbackModal = false" 
                class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 dark:bg-slate-800 dark:hover:bg-slate-700/80 dark:text-slate-400 dark:hover:text-slate-200 transition-all duration-200 cursor-pointer border border-slate-100/50 dark:border-slate-700/50 focus:outline-none outline-none">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Cabecera del Modal -->
        <div class="pr-12">
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>Feedback</span>
            </h3>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 mt-1">
                Ayúdanos a mejorar {{ config('app.name', 'WIStore') }} compartiendo tu experiencia.
                ¿Urgente? <a href="mailto:{{ $wistoreSupportEmail }}" class="text-primary hover:underline font-bold">{{ $wistoreSupportEmail }}</a>
            </p>
        </div>

        <!-- Selector de Pestañas (Tabs) -->
        <div class="flex border-b border-slate-100 dark:border-slate-800/80 mt-5 mb-5 text-xs font-bold">
            <button @click="tab = 'form'"
                    class="pb-2.5 px-4 transition-all duration-300 relative cursor-pointer focus:outline-none outline-none"
                    :class="tab === 'form' ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-350'">
                <span>Enviar Feedback</span>
                <span x-show="tab === 'form'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
            </button>
            <button @click="tab = 'history'; fetchFeedbacks()"
                    class="pb-2.5 px-4 transition-all duration-300 relative cursor-pointer focus:outline-none outline-none"
                    :class="tab === 'history' ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-350'">
                <span>Mi Historial</span>
                <span x-show="tab === 'history'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
            </button>
        </div>

        <!-- CONTENIDO DEL TAB: FORMULARIO -->
        <div x-show="tab === 'form'" class="flex-grow overflow-y-auto max-h-[60vh] pr-1">
            <form action="{{ route('admin.feedback.store', ['shop_slug' => config('current_shop')->slug]) }}" method="POST" class="space-y-4" x-data="{ type: '{{ old('type', 'comentario') }}', charCount: {{ strlen(old('description', '')) }} }">
                @csrf
                
                <!-- Hidden Type Input -->
                <input type="hidden" name="type" :value="type">

                <!-- 1. TIPO DE FEEDBACK SELECTOR -->
                <div class="space-y-2">
                    <label class="text-[11px] font-black uppercase tracking-wider text-slate-450 dark:text-slate-500 block pl-1">
                        Tipo de feedback
                    </label>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Bug Button -->
                        <button type="button" @click="type = 'bug'"
                                class="w-full py-2.5 rounded-xl border font-bold text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all duration-300 select-none cursor-pointer hover:scale-[1.02] active:scale-95 shadow-sm focus:outline-none outline-none"
                                :class="type === 'bug' 
                                    ? 'bg-rose-500/10 border-rose-500/40 text-rose-600 dark:text-rose-400 shadow-[0_0_15px_rgba(244,63,94,0.1)] font-extrabold' 
                                    : 'bg-slate-50 dark:bg-slate-800/40 border-slate-100 dark:border-slate-800/85 text-slate-400 dark:text-slate-500 hover:bg-slate-100/50 dark:hover:bg-slate-800/60 hover:text-slate-500 dark:hover:text-slate-400'">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span>Bug</span>
                        </button>

                        <!-- Idea Button -->
                        <button type="button" @click="type = 'idea'"
                                class="w-full py-2.5 rounded-xl border font-bold text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all duration-300 select-none cursor-pointer hover:scale-[1.02] active:scale-95 shadow-sm focus:outline-none outline-none"
                                :class="type === 'idea' 
                                    ? 'bg-amber-500/10 border-amber-500/40 text-amber-600 dark:text-amber-400 shadow-[0_0_15px_rgba(245,158,11,0.1)] font-extrabold' 
                                    : 'bg-slate-50 dark:bg-slate-800/40 border-slate-100 dark:border-slate-800/85 text-slate-400 dark:text-slate-500 hover:bg-slate-100/50 dark:hover:bg-slate-800/60 hover:text-slate-500 dark:hover:text-slate-400'">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            <span>Idea</span>
                        </button>

                        <!-- Comentario Button -->
                        <button type="button" @click="type = 'comentario'"
                                class="w-full py-2.5 rounded-xl border font-bold text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all duration-300 select-none cursor-pointer hover:scale-[1.02] active:scale-95 shadow-sm focus:outline-none outline-none"
                                :class="type === 'comentario' 
                                    ? 'bg-primary/10 border-primary/45 text-primary shadow-[0_0_15px_rgba(var(--color-primary-rgb),0.1)] font-extrabold' 
                                    : 'bg-slate-50 dark:bg-slate-800/40 border-slate-100 dark:border-slate-800/85 text-slate-400 dark:text-slate-500 hover:bg-slate-100/50 dark:hover:bg-slate-800/60 hover:text-slate-500 dark:hover:text-slate-400'">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <span>Comentario</span>
                        </button>
                    </div>
                </div>

                <!-- 2. CAMPO TÍTULO -->
                <div class="space-y-1.5">
                    <label for="feedback-title" class="text-[11px] font-black uppercase tracking-wider text-slate-450 dark:text-slate-500 block pl-1">
                        Título
                    </label>
                    <input type="text" name="title" id="feedback-title" required
                           placeholder="Resumen breve del feedback"
                           value="{{ old('title') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-450 dark:placeholder-slate-550 focus:outline-none focus:ring-1 focus:ring-primary/40 focus:border-primary/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                    @error('title')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- 3. CAMPO DESCRIPCIÓN -->
                <div class="space-y-1.5">
                    <label for="feedback-description" class="text-[11px] font-black uppercase tracking-wider text-slate-450 dark:text-slate-500 block pl-1">
                        Descripción
                    </label>
                    <div class="relative">
                        <textarea name="description" id="feedback-description" required rows="4" maxlength="1000"
                                  placeholder="Describe con detalle tu feedback..."
                                  @input="charCount = $event.target.value.length"
                                  class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-450 dark:placeholder-slate-550 focus:outline-none focus:ring-1 focus:ring-primary/40 focus:border-primary/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300 resize-none">{{ old('description') }}</textarea>
                    </div>
                    <div class="flex items-center justify-between pl-1">
                        @error('description')
                            <span class="text-[10px] text-rose-500 font-bold block">{{ $message }}</span>
                        @else
                            <div></div>
                        @enderror
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wide select-none" 
                              x-text="charCount + '/1000'">0/1000</span>
                    </div>
                </div>

                <!-- 4. ACCIONES -->
                <div class="pt-3 flex justify-end gap-3">
                    <button type="button" @click="showFeedbackModal = false"
                            class="px-5 py-3.5 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-extrabold text-xs uppercase tracking-wider rounded-2xl hover:bg-slate-55 dark:hover:bg-slate-800/60 hover:text-slate-700 dark:hover:text-slate-300 transition-all duration-300 cursor-pointer focus:outline-none outline-none">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-3.5 bg-primary hover:opacity-90 text-white font-extrabold text-xs uppercase tracking-widest rounded-2xl shadow-md hover:shadow-lg active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer border border-white/10 shadow-primary/15 hover:shadow-primary/25 focus:outline-none outline-none">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        <span>Enviar feedback</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- CONTENIDO DEL TAB: HISTORIAL -->
        <div x-show="tab === 'history'" class="flex-grow overflow-y-auto max-h-[60vh] pr-1">
            
            <!-- Estado: Cargando -->
            <div x-show="loadingFeedbacks" class="py-12 flex flex-col items-center justify-center gap-3">
                <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Cargando historial...</span>
            </div>

            <!-- Estado: Vacío -->
            <div x-show="!loadingFeedbacks && feedbacks.length === 0" 
                 class="py-8 text-center select-none">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100/50 dark:border-slate-800/60 flex items-center justify-center mx-auto mb-4 text-slate-300 dark:text-slate-650 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <p class="text-xs font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-wide">
                    Aún no has enviado feedback
                </p>
            </div>

            <!-- Listado de Feedbacks -->
            <div x-show="!loadingFeedbacks && feedbacks.length > 0" class="space-y-3.5 py-1">
                <template x-for="item in feedbacks" :key="item.id">
                    <div class="bg-slate-50/50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/60 rounded-2xl p-4 transition-colors duration-300 space-y-2">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 min-w-0">
                                <!-- Type Badges -->
                                <template x-if="item.type === 'bug'">
                                    <span class="inline-flex items-center gap-1 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-lg px-2 py-0.5 text-[9px] font-black uppercase tracking-wider shrink-0 select-none">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Bug
                                    </span>
                                </template>
                                <template x-if="item.type === 'idea'">
                                    <span class="inline-flex items-center gap-1 bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 rounded-lg px-2 py-0.5 text-[9px] font-black uppercase tracking-wider shrink-0 select-none">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Idea
                                    </span>
                                </template>
                                <template x-if="item.type === 'comentario'">
                                    <span class="inline-flex items-center gap-1 bg-primary/10 border border-primary/20 text-primary rounded-lg px-2 py-0.5 text-[9px] font-black uppercase tracking-wider shrink-0 select-none">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                        Comentario
                                    </span>
                                </template>

                                <h4 class="text-xs font-black text-slate-800 dark:text-white truncate leading-none" x-text="item.title"></h4>
                            </div>

                            <!-- Date -->
                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 shrink-0 select-none font-mono" x-text="item.created_at_formatted"></span>
                        </div>

                        <p class="text-xs text-slate-505 dark:text-slate-400 leading-relaxed font-semibold" x-text="item.description"></p>

                        <!-- Status Indicator -->
                        <div class="flex justify-end pt-1.5 border-t border-slate-100/50 dark:border-slate-800/40">
                            <template x-if="item.status === 'pending'">
                                <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider select-none">
                                    ⏳ En revisión
                                </span>
                            </template>
                            <template x-if="item.status === 'reviewed'">
                                <span class="text-[9px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider select-none">
                                    ✓ Revisado
                                </span>
                            </template>
                            <template x-if="item.status !== 'pending' && item.status !== 'reviewed'">
                                <span class="text-[9px] font-bold text-emerald-500 dark:text-emerald-450 uppercase tracking-wider select-none">
                                    ✓ Resuelto
                                </span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

        </div>

    </div>
</div>
