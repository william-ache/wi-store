<!-- MODAL CALIFICAR WI-STORE (Marketing) -->
<div x-data="{
    tab: 'form',
    testimonial: null,
    loadingTestimonial: false,
    rating: {{ old('rating', 5) }},
    charCount: {{ strlen(old('comment', '')) }},
    setRating(value) { this.rating = value; },
    async fetchTestimonial() {
        if (this.testimonial !== null) return;
        this.loadingTestimonial = true;
        try {
            const response = await fetch('/{{ config('current_shop')->slug }}/admin/rate-wi-store', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.success) {
                this.testimonial = data.testimonial;
            }
        } catch (e) {
            console.error('Error al obtener calificación:', e);
        } finally {
            this.loadingTestimonial = false;
        }
    }
}"
@keydown.escape.window="showRateModal = false"
x-show="showRateModal"
x-cloak
class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <div x-show="showRateModal"
         x-transition.opacity.duration.300ms
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
         @click="showRateModal = false"></div>

    <div x-show="showRateModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="relative ui-card rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden flex flex-col p-6 sm:p-8 transition-colors duration-300 z-10 border border-slate-100 dark:border-slate-800">

        <button @click="showRateModal = false"
                class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 hover:bg-slate-100 text-slate-400 hover:text-slate-600 dark:bg-slate-800 dark:hover:bg-slate-700/80 dark:text-slate-400 dark:hover:text-slate-200 transition-all duration-200 border border-slate-100/50 dark:border-slate-700/50"
                aria-label="Cerrar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="pr-12">
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight flex items-center gap-2">
                <i class="fas fa-star text-amber-400"></i>
                <span>Calificar WI-Store</span>
            </h3>
            <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 mt-1">
                Cuéntanos tu experiencia. Tu reseña puede aparecer en la landing para otros comercios.
            </p>
        </div>

        <div class="flex border-b border-slate-100 dark:border-slate-800/80 mt-5 mb-5 text-xs font-bold">
            <button type="button" @click="tab = 'form'"
                    class="pb-2.5 px-4 transition-all duration-300 relative"
                    :class="tab === 'form' ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-350'">
                <span>Calificar</span>
                <span x-show="tab === 'form'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
            </button>
            <button type="button" @click="tab = 'history'; fetchTestimonial()"
                    class="pb-2.5 px-4 transition-all duration-300 relative"
                    :class="tab === 'history' ? 'text-primary' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-350'">
                <span>Mi calificación</span>
                <span x-show="tab === 'history'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
            </button>
        </div>

        <div x-show="tab === 'form'" class="flex-grow overflow-y-auto max-h-[60vh] pr-1">
            <form action="{{ route('admin.rate-wi-store.store', ['shop_slug' => config('current_shop')->slug]) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="rating" :value="rating">

                <div class="space-y-2">
                    <label class="text-[11px] font-black uppercase tracking-wider text-slate-450 dark:text-slate-500 block pl-1">
                        Calificación
                    </label>
                    <div class="flex items-center gap-1.5" role="group" aria-label="Calificación de 1 a 5 estrellas">
                        <template x-for="star in 5" :key="star">
                            <button type="button"
                                    @click="setRating(star)"
                                    class="w-10 h-10 rounded-xl border transition-all duration-200 flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400/80"
                                    :class="star <= rating
                                        ? 'bg-amber-500/15 border-amber-400/50 text-amber-400 scale-105'
                                        : 'bg-slate-50 dark:bg-slate-800/40 border-slate-100 dark:border-slate-800 text-slate-300 dark:text-slate-600 hover:border-amber-400/30'"
                                    :aria-label="star + ' estrellas'"
                                    :aria-pressed="star <= rating">
                                <i class="fas fa-star text-sm"></i>
                            </button>
                        </template>
                        <span class="ml-2 text-xs font-bold text-slate-500 dark:text-slate-400 tabular-nums" x-text="rating + '/5'"></span>
                    </div>
                    @error('rating')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="rate-title" class="text-[11px] font-black uppercase tracking-wider text-slate-450 dark:text-slate-500 block pl-1">
                        Asunto
                    </label>
                    <input type="text" name="title" id="rate-title" required
                           placeholder="Ej: Fácil de usar y mis pedidos llegan ordenados"
                           value="{{ old('title') }}"
                           class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-450 dark:placeholder-slate-550 focus:outline-none focus:ring-1 focus:ring-primary/40 focus:border-primary/40 shadow-inner transition-all">
                    @error('title')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="rate-comment" class="text-[11px] font-black uppercase tracking-wider text-slate-450 dark:text-slate-500 block pl-1">
                        Comentario
                    </label>
                    <textarea name="comment" id="rate-comment" required rows="4" maxlength="1000"
                              placeholder="Describe cómo WI-Store te ayudó con tu negocio..."
                              @input="charCount = $event.target.value.length"
                              class="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-450 dark:placeholder-slate-550 focus:outline-none focus:ring-1 focus:ring-primary/40 focus:border-primary/40 shadow-inner transition-all resize-none">{{ old('comment') }}</textarea>
                    <div class="flex justify-end pl-1">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500" x-text="charCount + '/1000'">0/1000</span>
                    </div>
                    @error('comment')
                        <span class="text-[10px] text-rose-500 font-bold block pl-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-3 flex justify-end gap-3">
                    <button type="button" @click="showRateModal = false"
                            class="px-5 py-3.5 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-extrabold text-xs uppercase tracking-wider rounded-2xl hover:bg-slate-55 dark:hover:bg-slate-800/60 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-3.5 bg-primary hover:opacity-90 text-white font-extrabold text-xs uppercase tracking-widest rounded-2xl shadow-md active:scale-[0.98] transition-all flex items-center gap-2">
                        <i class="fas fa-star text-xs"></i>
                        <span>Publicar calificación</span>
                    </button>
                </div>
            </form>
        </div>

        <div x-show="tab === 'history'" class="flex-grow overflow-y-auto max-h-[60vh] pr-1">
            <div x-show="loadingTestimonial" class="py-12 flex flex-col items-center justify-center gap-3">
                <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <div x-show="!loadingTestimonial && !testimonial" class="py-8 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100/50 dark:border-slate-800/60 flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <p class="text-xs font-extrabold text-slate-400 dark:text-slate-500 uppercase tracking-wide">
                    Aún no has calificado WI-Store
                </p>
            </div>

            <div x-show="!loadingTestimonial && testimonial" class="bg-slate-50/50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-800/60 rounded-2xl p-4 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-0.5 text-amber-400">
                        <template x-for="star in 5" :key="'hist-' + star">
                            <i class="fas fa-star text-xs" :class="star <= testimonial?.rating ? 'text-amber-400' : 'text-slate-600'"></i>
                        </template>
                    </div>
                    <span class="text-[9px] font-bold text-slate-400 font-mono" x-text="testimonial?.created_at_formatted"></span>
                </div>
                <h4 class="text-sm font-black text-slate-800 dark:text-white" x-text="testimonial?.title"></h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed" x-text="testimonial?.comment"></p>
                <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wide" x-show="testimonial?.is_published">
                    ✓ Visible en la landing
                </p>
            </div>
        </div>
    </div>
</div>
