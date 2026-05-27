@php
    $side = ($m['index'] % 2 === 1) ? 'right' : 'left';
@endphp

<div class="roadmap-mobile-step roadmap-mobile-step--{{ $side }}">
    @if ($side === 'left')
        <div class="roadmap-mobile-step__card">
            @include('partials.landing.roadmap-milestone-card-body', ['m' => $m])
        </div>
        <div class="roadmap-mobile-step__node" aria-hidden="true">
            @include('partials.landing.roadmap-milestone-holo', ['m' => $m])
        </div>
        <div class="roadmap-mobile-step__spacer" aria-hidden="true"></div>
    @else
        <div class="roadmap-mobile-step__spacer" aria-hidden="true"></div>
        <div class="roadmap-mobile-step__node" aria-hidden="true">
            @include('partials.landing.roadmap-milestone-holo', ['m' => $m])
        </div>
        <div class="roadmap-mobile-step__card">
            @include('partials.landing.roadmap-milestone-card-body', ['m' => $m])
        </div>
    @endif
</div>
