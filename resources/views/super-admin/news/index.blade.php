@extends('layouts.super-admin')

@section('title', 'Noticias — Super Admin')

@section('page-header')
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Noticias</h1>
            <p class="text-sm text-slate-500 mt-1">Comunicados y novedades de la plataforma (borrador o publicado).</p>
        </div>
        <button type="button"
                onclick="document.getElementById('news-form').scrollIntoView({ behavior: 'smooth' })"
                class="sa-btn-primary text-xs px-4 py-2.5 inline-flex items-center gap-2 shrink-0">
            <i class="fas fa-plus" aria-hidden="true"></i>
            Nueva noticia
        </button>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-[1fr_22rem] gap-6">
        <section class="sa-panel p-5 md:p-6">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-500 mb-4">Publicadas y borradores</h2>

            @if ($newsItems->isEmpty())
                <p class="text-sm text-slate-500 py-8 text-center">Aún no hay noticias. Crea la primera con el formulario.</p>
            @else
                <div class="space-y-3">
                    @foreach ($newsItems as $item)
                        <article class="rounded-xl border border-slate-200 bg-slate-50/80 p-4 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="text-sm font-bold text-slate-900">{{ $item->title }}</h3>
                                    @if ($item->is_published)
                                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Publicada</span>
                                    @else
                                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200">Borrador</span>
                                    @endif
                                </div>
                                @if ($item->excerpt)
                                    <p class="text-xs text-slate-600 line-clamp-2">{{ $item->excerpt }}</p>
                                @endif
                                <p class="text-[10px] text-slate-400 mt-2">
                                    /{{ $item->slug }}
                                    @if ($item->published_at)
                                        · {{ $item->published_at->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                            </div>
                            <details class="shrink-0 text-xs">
                                <summary class="cursor-pointer font-bold text-purple-700 hover:text-purple-900">Editar</summary>
                                <form action="{{ route('super-admin.news.update', $item) }}" method="POST" class="mt-3 space-y-2 min-w-[16rem]">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="title" value="{{ $item->title }}" required class="sa-field w-full px-3 py-2 text-sm">
                                    <input type="text" name="excerpt" value="{{ $item->excerpt }}" placeholder="Resumen" class="sa-field w-full px-3 py-2 text-sm">
                                    <textarea name="body" rows="3" placeholder="Contenido" class="sa-field w-full px-3 py-2 text-sm">{{ $item->body }}</textarea>
                                    <label class="flex items-center gap-2 text-slate-600">
                                        <input type="checkbox" name="is_published" value="1" @checked($item->is_published) class="rounded border-slate-300">
                                        Publicada
                                    </label>
                                    <input type="datetime-local" name="published_at"
                                           value="{{ $item->published_at?->format('Y-m-d\TH:i') }}"
                                           class="sa-field w-full px-3 py-2 text-sm">
                                    <div class="flex gap-2 pt-1">
                                        <button type="submit" class="sa-btn-primary px-3 py-1.5 rounded-lg text-[11px]">Guardar</button>
                                    </div>
                                </form>
                                <form action="{{ route('super-admin.news.destroy', $item) }}" method="POST" class="mt-2"
                                      onsubmit="return confirm('¿Eliminar esta noticia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[11px] font-bold text-rose-600 hover:text-rose-800">Eliminar</button>
                                </form>
                            </details>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section id="news-form" class="sa-panel p-5 md:p-6 h-fit xl:sticky xl:top-24">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-500 mb-4">Nueva noticia</h2>
            <form action="{{ route('super-admin.news.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Título</label>
                    <input type="text" name="title" required class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                </div>
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Resumen</label>
                    <input type="text" name="excerpt" class="sa-field w-full px-3 py-2.5 text-sm mt-1">
                </div>
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Contenido</label>
                    <textarea name="body" rows="5" class="sa-field w-full px-3 py-2.5 text-sm mt-1"></textarea>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300">
                    Publicar al guardar
                </label>
                <button type="submit" class="sa-btn-primary w-full py-2.5 rounded-xl text-xs font-extrabold">
                    Crear noticia
                </button>
            </form>
        </section>
    </div>
@endsection
