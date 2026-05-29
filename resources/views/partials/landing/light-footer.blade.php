<footer class="w-full py-6 text-xs text-slate-500 relative z-10 border-t border-slate-200/80 bg-white/60 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p>© 2026 WI-Store. Todos los derechos reservados.</p>
        <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
            <a href="mailto:{{ $wiStoreSupportEmail }}" class="hover:text-purple-700 transition-colors">{{ $wiStoreSupportEmail }}</a>
            <span class="hidden sm:inline text-slate-300">•</span>
            <a href="{{ route('legal.privacidad') }}" class="hover:text-slate-800 transition-colors">Políticas y Privacidad</a>
            <span class="text-slate-300">•</span>
            <a href="{{ route('contacto') }}" class="hover:text-slate-800 transition-colors">Contacto</a>
        </div>
    </div>
</footer>
