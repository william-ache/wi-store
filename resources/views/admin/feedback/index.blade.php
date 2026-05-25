@extends('layouts.admin')

@section('title', 'Feedback')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- CABECERA DE LA PÁGINA -->
    <div>
        <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-white tracking-tight">Feedback</h2>
        <p class="text-xs text-slate-450 dark:text-slate-500 font-semibold mt-0.5">
            Reporta bugs, comparte ideas o déjanos un comentario sobre {{ config('app.name', 'WIStore') }}.
            Soporte: <a href="mailto:{{ $wistoreSupportEmail }}" class="text-primary hover:underline font-bold">{{ $wistoreSupportEmail }}</a>
        </p>
    </div>

    <!-- TARJETA DEL FORMULARIO -->
    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-[28px] p-6 sm:p-8 shadow-sm transition-colors duration-300"
         x-data="{ type: 'comentario', charCount: 0 }">
        
        <form action="{{ route('admin.feedback.store', ['shop_slug' => config('current_shop')->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Hidden Type Input -->
            <input type="hidden" name="type" :value="type">

            <!-- 1. TIPO DE FEEDBACK SELECTOR -->
            <div class="space-y-2.5">
                <label class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">
                    Tipo de feedback
                </label>
                <div class="flex flex-wrap gap-3">
                    <!-- Bug Tab Button -->
                    <button type="button" @click="type = 'bug'"
                            class="px-5 py-2.5 rounded-xl border font-bold text-xs flex items-center gap-2 transition-all duration-200 select-none cursor-pointer"
                            :class="type === 'bug' 
                                ? 'bg-rose-500/10 border-rose-500/50 text-rose-600 dark:text-rose-400' 
                                : 'bg-slate-50 dark:bg-slate-800/50 border-slate-100 dark:border-slate-800/80 text-slate-500 dark:text-slate-400 hover:border-slate-200 dark:hover:border-slate-700'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>Bug</span>
                    </button>

                    <!-- Idea Tab Button -->
                    <button type="button" @click="type = 'idea'"
                            class="px-5 py-2.5 rounded-xl border font-bold text-xs flex items-center gap-2 transition-all duration-200 select-none cursor-pointer"
                            :class="type === 'idea' 
                                ? 'bg-amber-500/10 border-amber-500/50 text-amber-600 dark:text-amber-400' 
                                : 'bg-slate-50 dark:bg-slate-800/50 border-slate-100 dark:border-slate-800/80 text-slate-500 dark:text-slate-400 hover:border-slate-200 dark:hover:border-slate-700'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        <span>Idea</span>
                    </button>

                    <!-- Comentario Tab Button -->
                    <button type="button" @click="type = 'comentario'"
                            class="px-5 py-2.5 rounded-xl border font-bold text-xs flex items-center gap-2 transition-all duration-200 select-none cursor-pointer"
                            :class="type === 'comentario' 
                                ? 'bg-purple-500/10 border-purple-500/50 text-purple-600 dark:text-purple-400' 
                                : 'bg-slate-50 dark:bg-slate-800/50 border-slate-100 dark:border-slate-800/80 text-slate-500 dark:text-slate-400 hover:border-slate-200 dark:hover:border-slate-700'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>Comentario</span>
                    </button>
                </div>
            </div>

            <!-- 2. CAMPO TÍTULO -->
            <div class="space-y-1.5">
                <label for="title" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">
                    Título
                </label>
                <input type="text" name="title" id="title" required
                       placeholder="Resumen breve del feedback"
                       value="{{ old('title') }}"
                       class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300">
                @error('title')
                    <span class="text-[10px] text-rose-500 font-bold block pl-1 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- 3. CAMPO DESCRIPCIÓN -->
            <div class="space-y-1.5">
                <label for="description" class="text-[11px] font-black uppercase tracking-wider text-slate-400 block pl-1">
                    Descripción
                </label>
                <div class="relative">
                    <textarea name="description" id="description" required rows="5" maxlength="1000"
                              placeholder="Describe con detalle tu feedback..."
                              @input="charCount = $event.target.value.length"
                              class="w-full bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80 rounded-2xl px-4 py-3.5 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-purple-500/40 focus:border-purple-500/40 focus:bg-white dark:focus:bg-slate-800/60 shadow-inner transition-all duration-300 resize-none">{{ old('description') }}</textarea>
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

            <!-- 4. BOTÓN ENVIAR -->
            <div class="pt-2">
                <button type="submit"
                        class="px-6 py-4 bg-purple-600 hover:bg-purple-700 text-white font-extrabold text-xs uppercase tracking-widest rounded-2xl shadow-md hover:shadow-lg active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer border border-white/5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    <span>Enviar feedback</span>
                </button>
            </div>

        </form>
    </div>

    <!-- MIS ENVÍOS ANTERIORES -->
    <div class="space-y-4">
        <h3 class="text-sm font-black text-slate-850 dark:text-white pl-1 uppercase tracking-wider">
            Mis envíos anteriores
        </h3>

        @if($feedbacks->isEmpty())
        <!-- Estado Vacío Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-[28px] p-12 text-center shadow-sm transition-colors duration-300 select-none">
            <div class="w-16 h-16 rounded-3xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100/50 dark:border-slate-800/40 flex items-center justify-center mx-auto mb-4 text-slate-350 dark:text-slate-600 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <p class="text-xs font-extrabold text-slate-400 dark:text-slate-500">
                Aún no has enviado feedback
            </p>
        </div>
        @else
        <!-- Listado de Envíos -->
        <div class="space-y-4">
            @foreach($feedbacks as $item)
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-850/80 rounded-[24px] p-5 shadow-sm transition-colors duration-300 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <!-- Type Badge -->
                        @if($item->type === 'bug')
                            <span class="inline-flex items-center gap-1 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-wider shrink-0 select-none">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Bug
                            </span>
                        @elseif($item->type === 'idea')
                            <span class="inline-flex items-center gap-1 bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-wider shrink-0 select-none">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-550"></span>
                                Idea
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-purple-500/10 border border-purple-500/20 text-purple-600 dark:text-purple-400 rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-wider shrink-0 select-none">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                Comentario
                            </span>
                        @endif

                        <h4 class="text-xs font-black text-slate-800 dark:text-white truncate leading-none">
                            {{ $item->title }}
                        </h4>
                    </div>

                    <!-- Date info -->
                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 shrink-0 select-none font-mono">
                        {{ $item->created_at->format('d/m/Y h:i A') }}
                    </span>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                    {{ $item->description }}
                </p>

                <!-- Status indicators -->
                <div class="flex justify-end pt-2 border-t border-slate-50 dark:border-slate-800/40">
                    @if($item->status === 'pending')
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider select-none">
                            ⏳ En revisión
                        </span>
                    @elseif($item->status === 'reviewed')
                        <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-wider select-none">
                            ✓ Revisado
                        </span>
                    @else
                        <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-wider select-none">
                            ✓ Resuelto
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
