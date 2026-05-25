@props(['entity'])

@php
    $config = \App\Support\AdminExcel\AdminExcelRegistry::get($entity);
    $shopSlug = config('current_shop')->slug;
    $routeParams = ['shop_slug' => $shopSlug, 'entity' => $entity];
    $result = session('excel_result');
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }} x-data="{ importing: false }">
    @if (session('success') && $result)
        <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-[11px] font-bold text-emerald-700 dark:text-emerald-300">
            {{ session('success') }}
            @if (!empty($result['errors']))
                <ul class="mt-1 list-disc pl-4 font-semibold text-amber-700 dark:text-amber-300 max-h-24 overflow-y-auto">
                    @foreach (array_slice($result['errors'], 0, 8) as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @if (count($result['errors']) > 8)
                        <li>… y {{ count($result['errors']) - 8 }} error(es) más</li>
                    @endif
                </ul>
            @endif
        </div>
    @elseif (session('warning') && $result)
        <div class="rounded-xl border border-amber-500/30 bg-amber-500/10 px-3 py-2 text-[11px] font-bold text-amber-700 dark:text-amber-300">
            {{ session('warning') }}
            @if (!empty($result['errors']))
                <ul class="mt-1 list-disc pl-4 font-semibold max-h-24 overflow-y-auto">
                    @foreach (array_slice($result['errors'], 0, 8) as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.excel.export', $routeParams) }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 text-[11px] font-black uppercase tracking-wide hover:bg-emerald-500/20 transition-colors"
           title="Exportar {{ $config['label'] }} a Excel">
            <i class="fas fa-file-export text-[10px]"></i>
            Exportar
        </a>

        @if ($config['importable'] ?? true)
            <a href="{{ route('admin.excel.template', $routeParams) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 text-[11px] font-black uppercase tracking-wide hover:border-primary/30 hover:text-primary transition-colors"
               title="Descargar plantilla Excel">
                <i class="fas fa-file-download text-[10px]"></i>
                Plantilla
            </a>

            <form action="{{ route('admin.excel.import', $routeParams) }}" method="POST" enctype="multipart/form-data"
                  class="inline-flex items-center gap-2" @submit="importing = true">
                @csrf
                <label class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-purple-500/30 bg-purple-500/10 text-purple-700 dark:text-purple-300 text-[11px] font-black uppercase tracking-wide hover:bg-purple-500/20 transition-colors cursor-pointer"
                       :class="importing ? 'opacity-60 pointer-events-none' : ''">
                    <i class="fas fa-file-import text-[10px]"></i>
                    <span x-text="importing ? 'Importando…' : 'Importar'"></span>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="hidden" required
                           @change="$el.form.requestSubmit()">
                </label>
            </form>
        @endif
    </div>
</div>

@if ($result && (session('success') || session('warning')))
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof datatable !== 'undefined' && datatable.ajax) {
                    datatable.ajax.reload(null, false);
                }
            });
        </script>
    @endpush
@endif
