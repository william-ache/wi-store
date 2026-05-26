@props(['usage'])

@php
    $isUnlimited = $usage['limit'] === null;
    $barWidth = $isUnlimited ? ($usage['current'] > 0 ? 100 : 0) : $usage['percent'];
    $fraction = $isUnlimited
        ? $usage['current'] . ' · Ilimitado'
        : $usage['current'] . ' / ' . $usage['limit'];
@endphp

<div class="ui-card rounded-2xl p-5 border border-slate-100 dark:border-slate-800 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
    <div class="flex justify-between items-center text-xs font-semibold text-slate-500 dark:text-slate-400 mb-3">
        <span>{{ $usage['resource_label'] }} · Plan {{ $usage['plan_name'] }}</span>
        <span>{{ $fraction }}</span>
    </div>
    <div class="w-full h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
        <div
            class="h-full bg-primary rounded-full transition-all duration-500 {{ $usage['at_limit'] ? 'opacity-90' : '' }}"
            style="width: {{ $barWidth }}%"
        ></div>
    </div>
</div>
