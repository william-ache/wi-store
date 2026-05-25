@props([
    'id',
    'title',
    'subtitle',
    'icon' => '📋',
    'optional' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border transition-all duration-300 overflow-hidden']) }}
     x-bind:class="sections['{{ $id }}']
         ? 'border-primary/25 bg-white dark:bg-slate-900/50 shadow-sm'
         : 'border-slate-200/80 dark:border-slate-800/80 bg-slate-50/40 dark:bg-slate-950/30'">

    <div class="settings-section-header flex items-center gap-3 p-3.5 sm:p-4 md:p-5 cursor-pointer select-none"
         x-on:click="sections['{{ $id }}'] ? togglePanel('{{ $id }}') : enableSection('{{ $id }}')">
        <span class="w-10 h-10 md:w-11 md:h-11 rounded-xl flex items-center justify-center text-lg md:text-xl shrink-0 transition-colors"
              x-bind:class="sections['{{ $id }}'] ? 'bg-primary/15' : 'bg-slate-200/60 dark:bg-slate-800'">
            {{ $icon }}
        </span>
        <div class="flex-grow min-w-0">
            <div class="flex items-center gap-2 flex-wrap">
                <h4 class="text-xs md:text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-wide">{{ $title }}</h4>
                <span x-show="sections['{{ $id }}']" x-cloak
                      class="settings-section-chip text-[9px] md:text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                    Activo
                </span>
            </div>
            <p class="text-[10px] md:text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-snug">{{ $subtitle }}</p>
        </div>
        @if($optional)
            <button type="button"
                    x-show="!sections['{{ $id }}']"
                    x-on:click.stop="enableSection('{{ $id }}')"
                    class="shrink-0 text-[10px] md:text-xs font-black uppercase tracking-wider px-3 py-1.5 md:px-3.5 md:py-2 rounded-lg bg-primary text-white hover:brightness-105 active:scale-95 transition shadow-sm">
                Activar
            </button>
            <button type="button"
                    x-show="sections['{{ $id }}']"
                    x-cloak
                    x-on:click.stop="togglePanel('{{ $id }}')"
                    class="shrink-0 w-8 h-8 md:w-9 md:h-9 rounded-lg border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i class="fas text-[10px] md:text-xs transition-transform duration-200"
                   x-bind:class="openPanel === '{{ $id }}' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        @else
            <button type="button"
                    x-on:click.stop="togglePanel('{{ $id }}')"
                    class="shrink-0 w-8 h-8 md:w-9 md:h-9 rounded-lg border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i class="fas text-[10px] md:text-xs transition-transform duration-200"
                   x-bind:class="openPanel === '{{ $id }}' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        @endif
    </div>

    <div @if($optional) x-show="sections['{{ $id }}'] && openPanel === '{{ $id }}'" @else x-show="openPanel === '{{ $id }}'" @endif
         x-collapse
         class="border-t border-slate-100 dark:border-slate-800/80">
        <div class="settings-section-body p-3.5 sm:p-4 md:p-5 pt-3 md:pt-4 space-y-3 md:space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>
