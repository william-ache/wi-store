@php
    $active = $activeModule ?? '';
    $nav = [
        'empresas' => ['label' => 'Empresas', 'icon' => 'fa-building', 'route' => 'super-admin.companies.index'],
        'noticias' => ['label' => 'Noticias', 'icon' => 'fa-newspaper', 'route' => 'super-admin.news.index'],
        'ajustes' => ['label' => 'Ajustes · Planes', 'icon' => 'fa-sliders', 'route' => 'super-admin.settings.plans'],
    ];
@endphp

<aside class="sa-sidebar" aria-label="Módulos del panel">
    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-3 mb-3">Módulos</p>
    <nav class="space-y-1">
        @foreach ($nav as $key => $item)
            <a href="{{ route($item['route']) }}"
               class="sa-nav-link {{ $active === $key ? 'is-active' : '' }}">
                <i class="fas {{ $item['icon'] }} w-4 text-center text-sm opacity-80" aria-hidden="true"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
    <div class="mt-auto pt-8 px-3">
        <p class="text-[10px] text-slate-400 leading-relaxed">
            Configura precios y textos de planes en <strong class="text-slate-600">Ajustes</strong>; se reflejan en la landing.
        </p>
    </div>
</aside>
