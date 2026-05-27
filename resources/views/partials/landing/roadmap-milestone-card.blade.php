<article class="roadmap-milestone roadmap-milestone--{{ $m['index'] }}">
    @include('partials.landing.roadmap-milestone-card-body', ['m' => $m])
    <div aria-hidden="true">
        @include('partials.landing.roadmap-milestone-holo', ['m' => $m])
    </div>
</article>
