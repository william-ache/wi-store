@php
    $shop = config('current_shop');
    $isPremiumPlan = ($shop->plan ?? '') === 'premium';
    $logoUrl = null;
    if ($shop && $shop->logo_path) {
        $logoUrl = filter_var($shop->logo_path, FILTER_VALIDATE_URL)
            ? $shop->logo_path
            : asset('storage/' . $shop->logo_path);
    }
    $name = $shop->name ?? 'WI-Store';
    $initials = collect(preg_split('/\s+/', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
        ->join('') ?: 'WS';
@endphp

<style>
    @keyframes wi-loader-float-crown {
        0%, 100% { transform: translate(-50%, 0); }
        50% { transform: translate(-50%, -6px); }
    }
    .wi-loader-crown {
        animation: wi-loader-float-crown 3s infinite ease-in-out;
    }
    .wi-loader-premium-ring {
        box-shadow: 0 0 15px rgba(251, 191, 36, 0.45);
    }
    #admin-request-loader:not(.hidden) {
        pointer-events: all;
    }
</style>

<div id="admin-request-loader"
     class="hidden opacity-0 fixed inset-0 ui-overlay flex flex-col justify-center items-center z-[99999] transition-opacity duration-300 backdrop-blur-sm"
     aria-hidden="true"
     role="status">
    <div class="relative w-24 h-24 flex justify-center items-center">
        @if ($isPremiumPlan)
            <div class="absolute -top-7 left-1/2 z-40 pointer-events-none wi-loader-crown flex items-center justify-center">
                <i class="fas fa-crown text-[22px] text-amber-400 filter drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)]"></i>
                <span class="absolute w-1.5 h-1.5 rounded-full bg-white animate-ping opacity-75" style="top: 1px;"></span>
            </div>
        @endif
        <div class="absolute inset-0 border-4 {{ $isPremiumPlan ? 'border-yellow-100/50 dark:border-yellow-900/30' : 'border-slate-100 dark:border-slate-800' }} rounded-full animate-spin"
             style="border-top-color: {{ $isPremiumPlan ? '#F59E0B' : (config('current_shop')->color_primary ?? '#E60067') }};"></div>
        <div class="w-20 h-20 rounded-full {{ $isPremiumPlan ? 'wi-loader-premium-ring border-2 border-yellow-400 ui-surface' : 'bg-slate-200 dark:bg-slate-800 text-slate-400 shadow-sm' }} overflow-hidden flex items-center justify-center text-xs font-bold relative z-10">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo" class="w-full h-full object-cover"
                     id="admin-loader-logo-img"
                     onerror="this.style.display='none'; document.getElementById('admin-loader-logo-fallback')?.classList.remove('hidden');">
                <div id="admin-loader-logo-fallback"
                     class="hidden w-full h-full text-white flex items-center justify-center text-lg font-black tracking-wider"
                     style="background-color: {{ config('current_shop')->color_primary ?? '#E60067' }};">
                    {{ $initials }}
                </div>
            @else
                <div class="w-full h-full text-white flex items-center justify-center text-lg font-black tracking-wider"
                     style="background-color: {{ config('current_shop')->color_primary ?? '#E60067' }};">
                    {{ $initials }}
                </div>
            @endif
        </div>
    </div>
</div>
