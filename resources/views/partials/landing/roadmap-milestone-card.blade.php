<article class="roadmap-milestone roadmap-milestone--{{ $m['index'] }}">
    <div class="roadmap-milestone__layout">
        @include('partials.landing.roadmap-milestone-card-body', ['m' => $m])
        <div class="roadmap-milestone__holo" aria-hidden="true">
            @include('partials.landing.roadmap-milestone-holo', ['m' => $m])
        </div>
    </div>
</article>
