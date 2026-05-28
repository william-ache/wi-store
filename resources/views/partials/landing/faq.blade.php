@php
    $landingFaqs = [
        [
            'q' => '¿Qué es WI-Store?',
            'a' => 'WI-Store es una plataforma para crear tu menú o catálogo digital con fotos y precios. Tus clientes eligen desde el enlace y los pedidos te llegan ordenados a WhatsApp o Telegram, sin comisiones por venta.',
        ],
        [
            'q' => '¿Cómo empiezo a usar WI-Store?',
            'a' => 'Regístrate gratis y activa tu prueba de ' . $wiStoreTrialDays . ' días. En minutos subes productos, personalizas tu tienda y compartes el enlace. No necesitas tarjeta para empezar.',
        ],
        [
            'q' => '¿Cuáles son las funcionalidades principales?',
            'a' => 'Catálogo con categorías, pedidos al WhatsApp o Telegram, panel para gestionar productos y pedidos, personalización de marca (logo y colores), y planes según el tamaño de tu negocio.',
        ],
        [
            'q' => '¿Para qué tipos de negocio sirve?',
            'a' => 'Restaurantes, cafeterías, repostería, tiendas de ropa, regalos, ferretería y cualquier negocio que venda por catálogo. Si tienes productos con precio, WI-Store te sirve.',
        ],
        [
            'q' => '¿Es fácil de usar? ¿Tienen soporte?',
            'a' => 'Sí. Está pensado para quien no sabe de páginas web. Tienes panel claro, tutoriales y soporte por correo y WhatsApp si te atoras en la configuración.',
        ],
        [
            'q' => '¿Cuánto cuesta?',
            'a' => 'Empiezas con prueba gratis de ' . $wiStoreTrialDays . ' días. Luego eliges un plan mensual fijo: sin comisiones por pedido ni por venta. Revisa la sección de precios para comparar planes.',
        ],
    ];
@endphp

<section id="faq" class="py-14 md:py-20 relative z-10 overflow-x-clip" aria-labelledby="faq-heading">
    <div class="landing-container relative z-10">
        <header class="text-center mb-10 md:mb-12 max-w-2xl mx-auto">
            <h2 id="faq-heading" class="text-2xl md:text-4xl font-black tracking-tight text-slate-900">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-cyan-500">FAQ</span>
                <span class="text-slate-900"> – Preguntas frecuentes</span>
            </h2>
            <p class="mt-3 text-sm md:text-base text-slate-600 leading-relaxed">
                Conoce más sobre WI-Store y descubre cómo puede ayudarte a organizar y hacer crecer tu negocio.
            </p>
        </header>

        <div class="max-w-3xl mx-auto space-y-3" role="list">
            @foreach ($landingFaqs as $index => $faq)
                @php $id = $index + 1; @endphp
                <article class="landing-faq-item"
                         role="listitem"
                         :class="activeFaq === {{ $id }} ? 'is-open' : ''">
                    <button type="button"
                            id="landing-faq-btn-{{ $id }}"
                            @click="activeFaq = activeFaq === {{ $id }} ? null : {{ $id }}"
                            :aria-expanded="activeFaq === {{ $id }}"
                            aria-controls="landing-faq-panel-{{ $id }}"
                            class="landing-faq-trigger w-full flex items-center justify-between gap-4 text-left px-5 py-4 md:px-6 md:py-5">
                        <span class="text-sm md:text-base font-bold text-slate-900 pr-2">{{ $faq['q'] }}</span>
                        <span class="landing-faq-toggle shrink-0" aria-hidden="true">
                            <i class="fas text-lg leading-none"
                               :class="activeFaq === {{ $id }} ? 'fa-minus' : 'fa-plus'"></i>
                        </span>
                    </button>
                    <div id="landing-faq-panel-{{ $id }}"
                         x-show="activeFaq === {{ $id }}"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-cloak
                         role="region"
                         aria-labelledby="landing-faq-btn-{{ $id }}"
                         class="landing-faq-panel px-5 pb-4 md:px-6 md:pb-5 -mt-1">
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
